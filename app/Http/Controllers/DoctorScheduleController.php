<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::id();
        $date = $request->get('date', now()->toDateString());

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->orderBy('appointment_time')
            ->get();

        return view('doctor.schedule', compact('appointments', 'date'));
    }
}
