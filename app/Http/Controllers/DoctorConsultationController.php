<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\ConsultationCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorConsultationController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::id();
        $query = Consultation::with('patient')->where('doctor_id', $doctorId);

        if ($request->has('search')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_id', 'like', '%' . $request->search . '%');
            });
        }

        $consultations = $query->latest()->paginate(10);

        return view('doctor.consultations.index', compact('consultations'));
    }

    public function create(Appointment $appointment = null)
    {
        if ($appointment && $appointment->doctor_id !== Auth::id()) {
            abort(403, 'You are not authorized to consult for this appointment.');
        }

        $patients = Patient::where('status', 'active')->orderBy('name')->get();

        return view('doctor.consultations.create', compact('appointment', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'consultation_date' => 'required|date',
        ]);

        $validated['doctor_id'] = Auth::id();

        $consultation = Consultation::create($validated);

        // Mark appointment as completed
        if ($request->filled('appointment_id')) {
            Appointment::where('id', $request->appointment_id)->update(['status' => 'completed']);
        }

        // Notify all admin users about the completed consultation
        $consultation->load(['patient', 'doctor']);
        User::where('role', 'admin')->each(function ($admin) use ($consultation) {
            $admin->notify(new ConsultationCompleted($consultation));
        });

        return redirect()->route('doctor.consultations.show', $consultation)->with('success', 'Consultation saved successfully.');
    }

    public function show(Consultation $consultation)
    {
        if ($consultation->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        return view('doctor.consultations.show', compact('consultation'));
    }
}
