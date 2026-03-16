<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_id', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $patients = $query->latest()->paginate(10);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
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

        return redirect()->route('admin.patients.index')->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('patients')->ignore($patient->id)],
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient details updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient record deleted.');
    }
}
