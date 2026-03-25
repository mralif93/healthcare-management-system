<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminDoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'doctor');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('staff_id', 'like', '%' . $request->search . '%')
                  ->orWhere('specialization', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $doctors = $query->latest()->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'password'       => ['required', Password::min(8)],
            'status'         => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // Auto-generate staff ID (DR-XXXXX)
        $latest = User::where('role', 'doctor')->orderBy('id', 'desc')->first();
        $nextId = $latest ? (int) substr($latest->staff_id, 3) + 1 : 1;
        $validated['staff_id'] = 'DR-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        $validated['role']     = 'doctor';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor account created successfully.');
    }

    public function show(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        $doctor->load('doctorConsultations');
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => ['required', 'email', Rule::unique('users')->ignore($doctor->id)],
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'password'       => ['nullable', Password::min(8)],
            'status'         => ['required', Rule::in(['active', 'inactive'])],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor profile updated successfully.');
    }

    public function destroy(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor account removed.');
    }
}

