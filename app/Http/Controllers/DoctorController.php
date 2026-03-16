<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();
        
        $stats = [
            'remaining_today' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', now())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'completed_today' => Consultation::where('doctor_id', $doctorId)
                ->whereDate('consultation_date', now())
                ->count(),
            'total_patients' => Appointment::where('doctor_id', $doctorId)->distinct('patient_id')->count(),
        ];

        $next_patient = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_time')
            ->first();

        $recent_consultations = Consultation::with('patient')
            ->where('doctor_id', $doctorId)
            ->latest()
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'next_patient', 'recent_consultations'));
    }
}
