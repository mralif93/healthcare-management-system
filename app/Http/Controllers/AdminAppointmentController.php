<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\AppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('appointment_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('patient', function($pq) use ($request) {
                      $pq->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('doctor', function($dq) use ($request) {
                      $dq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest()->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->orderBy('name')->get();
        $doctors = User::where('role', 'doctor')->where('status', 'active')->orderBy('name')->get();
        
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        // Auto-generate appointment ID (APT-XXXXX)
        $latest = Appointment::orderBy('id', 'desc')->first();
        $nextId = $latest ? (int) substr($latest->appointment_id, 4) + 1 : 1;
        $validated['appointment_id'] = 'APT-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $appointment = Appointment::create($validated);

        // Notify the assigned doctor
        $doctor = User::find($appointment->doctor_id);
        if ($doctor) {
            $appointment->load('patient');
            $doctor->notify(new AppointmentBooked($appointment));
        }

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 'active')->orderBy('name')->get();
        $doctors = User::where('role', 'doctor')->where('status', 'active')->orderBy('name')->get();
        
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted.');
    }
}
