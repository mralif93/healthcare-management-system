<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    public function index(Request $request)
    {
        // Patients who have appointments or consultations with this doctor
        $doctorId = Auth::id();
        
        $query = Patient::whereHas('consultations', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->orWhereHas('appointments', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        });

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_id', 'like', '%' . $request->search . '%');
            });
        }

        $patients = $query->distinct()->latest()->paginate(10);

        return view('doctor.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        // Load patient history
        $consultations = $patient->consultations()->where('doctor_id', Auth::id())->latest()->get();
        $allConsultations = $patient->consultations()->with('doctor')->latest()->get();

        return view('doctor.patients.show', compact('patient', 'consultations', 'allConsultations'));
    }
}
