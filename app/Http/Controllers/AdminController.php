<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'appointments_today' => Appointment::whereDate('appointment_date', now())->count(),
        ];

        $recent_patients = Patient::latest()->take(5)->get();
        $recent_appointments = Appointment::with(['patient', 'doctor'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_patients', 'recent_appointments'));
    }
}
