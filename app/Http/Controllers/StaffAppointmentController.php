<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\AppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StaffAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('appointment_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('patient', function($pq) use ($request) {
                      $pq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $appointments = $query->latest()->paginate(10);

        return view('staff.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->orderBy('name')->get();
        $doctors = User::where('role', 'doctor')->where('status', 'active')->orderBy('name')->get();
        
        return view('staff.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $validated['status'] = 'pending';

        // Auto-generate appointment ID and QR token
        $latest = Appointment::orderBy('id', 'desc')->first();
        $nextId = $latest ? (int) substr($latest->appointment_id, 4) + 1 : 1;
        $validated['appointment_id'] = 'APT-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        $validated['qr_token'] = Str::uuid()->toString();

        $appointment = Appointment::create($validated);

        // Notify the assigned doctor
        $doctor = User::find($appointment->doctor_id);
        if ($doctor) {
            $appointment->load('patient');
            $doctor->notify(new AppointmentBooked($appointment));
        }

        return redirect()->route('staff.appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function checkin(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('patient_id', 'like', '%' . $search . '%');
            });
        }

        $appointments = $query->orderBy('appointment_time')->get();

        return view('staff.checkin', compact('appointments'));
    }

    public function confirmArrival(Appointment $appointment)
    {
        if ($appointment->status === 'pending') {
            $appointment->update(['status' => 'confirmed']);
        }

        return redirect()->route('staff.checkin')->with('success', "Patient {$appointment->patient->name} has been checked in successfully.");
    }

    public function ticket(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);

        $qrSvg = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($appointment->qr_token);

        return view('staff.appointments.ticket', compact('appointment', 'qrSvg'));
    }

    public function scanQr(Request $request)
    {
        $request->validate(['qr_token' => 'required|string']);

        $appointment = Appointment::with('patient')
            ->where('qr_token', $request->qr_token)
            ->first();

        if (!$appointment) {
            return redirect()->route('staff.checkin')->with('error', 'Invalid QR code. No matching appointment found.');
        }

        if ($appointment->appointment_date !== now()->toDateString()) {
            return redirect()->route('staff.checkin')->with('error', "This QR is for {$appointment->appointment_date}, not today.");
        }

        if ($appointment->status === 'completed' || $appointment->status === 'cancelled') {
            return redirect()->route('staff.checkin')->with('error', "Appointment {$appointment->appointment_id} is already {$appointment->status}.");
        }

        if ($appointment->status === 'confirmed') {
            return redirect()->route('staff.checkin')->with('success', "Patient {$appointment->patient->name} is already checked in.");
        }

        $appointment->update(['status' => 'confirmed']);

        return redirect()->route('staff.checkin')->with('success', "✓ QR Verified — {$appointment->patient->name} ({$appointment->appointment_id}) checked in.");
    }

    public function doctorSchedules(Request $request)
    {
        $doctors = User::where('role', 'doctor')->where('status', 'active')->get();
        
        $selectedDoctorId = $request->get('doctor_id');
        $date = $request->get('date', now()->toDateString());
        
        $appointments = [];
        if ($selectedDoctorId) {
            $appointments = Appointment::with('patient')
                ->where('doctor_id', $selectedDoctorId)
                ->where('appointment_date', $date)
                ->orderBy('appointment_time')
                ->get();
        }

        return view('staff.doctor_schedules', compact('doctors', 'appointments', 'selectedDoctorId', 'date'));
    }
}
