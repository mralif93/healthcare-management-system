@extends('layouts.admin')

@section('title', 'Edit Patient')
@section('page_title', 'Update Patient Record')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Modify File: {{ $patient->patient_id }}</h3>
            <span class="px-2 py-1 bg-brand-50 text-brand-600 rounded text-[10px] font-black uppercase tracking-widest">{{ $patient->name }}</span>
        </div>

        <form action="{{ route('admin.patients.update', $patient) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <label for="phone" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Date of Birth -->
                <div class="space-y-1.5">
                    <label for="date_of_birth" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Gender -->
                <div class="space-y-1.5">
                    <label for="gender" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Gender</label>
                    <select name="gender" id="gender" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Blood Group -->
                <div class="space-y-1.5">
                    <label for="blood_group" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Blood Group</label>
                    <select name="blood_group" id="blood_group"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                            <option value="{{ $group }}" {{ old('blood_group', $patient->blood_group) == $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="address" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Residential Address</label>
                <textarea name="address" id="address" rows="2"
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ old('address', $patient->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-50">
                <div class="space-y-1.5">
                    <label for="allergies" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ old('allergies', $patient->allergies) }}</textarea>
                </div>
                <div class="space-y-1.5">
                    <label for="medical_history" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Medical History</label>
                    <textarea name="medical_history" id="medical_history" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ old('medical_history', $patient->medical_history) }}</textarea>
                </div>
            </div>

            <div class="pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.patients.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="px-8 py-2.5 bg-brand-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Update Registry
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
