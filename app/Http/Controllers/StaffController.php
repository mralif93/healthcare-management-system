<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', now())->count(),
            'checked_in' => Appointment::whereDate('appointment_date', now())->where('status', 'confirmed')->count(),
            'new_patients' => Patient::whereDate('created_at', now())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];

        $upcoming = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        $doctors = User::where('role', 'doctor')->where('status', 'active')->get();

        return view('staff.dashboard', compact('stats', 'upcoming', 'doctors'));
    }
}
