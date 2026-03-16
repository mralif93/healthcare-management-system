<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_id', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $patients = $query->latest()->paginate(10);

        return view('staff.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('staff.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patients',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // Auto-generate patient ID (P-XXXXX)
        $latestPatient = Patient::orderBy('id', 'desc')->first();
        $nextId = $latestPatient ? (int) substr($latestPatient->patient_id, 2) + 1 : 1;
        $validated['patient_id'] = 'P-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        Patient::create($validated);

        return redirect()->route('staff.patients.index')->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('staff.patients.show', compact('patient'));
    }
}
