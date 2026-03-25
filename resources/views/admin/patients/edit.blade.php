@extends('layouts.admin')

@section('title', 'Edit Patient')
@section('page_title', 'Update Patient Record')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Edit Patient Record</h1>
                <p class="text-sm text-white/70 mt-1">{{ $patient->patient_id }} &bull; {{ $patient->name }}</p>
            </div>
            <a href="{{ route('admin.patients.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">
                Patient Registry
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-pencil-edit-02 text-brand-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Edit Patient Record</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Updating file for {{ $patient->patient_id }}</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-brand-50 text-brand-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $patient->name }}</span>
        </div>

        <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400"></i> Email Address <span class="text-[10px] text-slate-400 font-normal">(Optional)</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5">
                        <label for="phone" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-call text-slate-400"></i> Phone Number <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Date of Birth -->
                    <div class="space-y-1.5">
                        <label for="date_of_birth" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-calendar-03 text-slate-400"></i> Date of Birth <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Gender -->
                    <div class="space-y-1.5">
                        <label for="gender" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user-multiple-02 text-slate-400"></i> Gender <span class="text-red-400">*</span>
                        </label>
                        <select name="gender" id="gender" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Blood Group -->
                    <div class="space-y-1.5">
                        <label for="blood_group" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-blood-bag text-slate-400"></i> Blood Group
                        </label>
                        <select name="blood_group" id="blood_group"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                <option value="{{ $group }}" {{ old('blood_group', $patient->blood_group) == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-1.5">
                    <label for="address" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <i class="hgi-stroke hgi-home-01 text-slate-400"></i> Residential Address
                    </label>
                    <textarea name="address" id="address" rows="2"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">{{ old('address', $patient->address) }}</textarea>
                </div>

                <!-- Medical Section -->
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-5">
                        <i class="hgi-stroke hgi-health text-brand-600"></i> Medical Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="allergies" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-alert-circle text-slate-400"></i> Known Allergies
                            </label>
                            <textarea name="allergies" id="allergies" rows="3"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">{{ old('allergies', $patient->allergies) }}</textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label for="medical_history" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-file-01 text-slate-400"></i> Medical History
                            </label>
                            <textarea name="medical_history" id="medical_history" rows="3"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">{{ old('medical_history', $patient->medical_history) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.patients.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-white hover:border-slate-300 transition-all">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>Back to Registry</span>
                </a>
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-100/50 hover:bg-brand-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
