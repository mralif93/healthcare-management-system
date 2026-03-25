@extends('layouts.admin')

@section('title', 'Add User')
@section('page_title', 'Register New Personnel')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Register New Personnel</h1>
                <p class="text-sm text-white/70 mt-1">System user account creation</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">
                Directory
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-3">
            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-user-add-01 text-brand-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Account Details</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Fill in all required fields to register a new system user</p>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Full Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Enter full name"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        @error('name') <p class="flex items-center gap-1 text-red-500 text-xs mt-1"><i class="hgi-stroke hgi-alert-circle text-xs"></i>{{ $message }}</p> @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400"></i> Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="name@clinic.com"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        @error('email') <p class="flex items-center gap-1 text-red-500 text-xs mt-1"><i class="hgi-stroke hgi-alert-circle text-xs"></i>{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5" x-data="{ role: '{{ old('role') }}' }">
                        <label for="role" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-shield-user text-slate-400"></i> Access Role <span class="text-red-400">*</span>
                        </label>
                        <select name="role" id="role" x-model="role" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                            <option value="staff">Staff</option>
                        </select>
                        @error('role') <p class="flex items-center gap-1 text-red-500 text-xs mt-1"><i class="hgi-stroke hgi-alert-circle text-xs"></i>{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-toggle-on text-slate-400"></i> Account Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Staff ID -->
                    <div class="space-y-1.5">
                        <label for="staff_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-id-verified text-slate-400"></i> Personnel ID <span class="text-[10px] text-slate-400 font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="staff_id" id="staff_id" value="{{ old('staff_id') }}" placeholder="e.g. DOC-001"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Specialization -->
                    <div class="space-y-1.5" id="specialization_container">
                        <label for="specialization" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-stethoscope text-slate-400"></i> Specialization <span class="text-[10px] text-slate-400 font-normal">(Doctors only)</span>
                        </label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" placeholder="e.g. Cardiology"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <!-- Password Section -->
                <div class="pt-6 border-t border-slate-100">
                    <h4 class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-5">
                        <i class="hgi-stroke hgi-lock-password text-brand-600"></i> Security Credentials
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="password" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" name="password" id="password" required placeholder="••••••••"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> Confirm Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-white hover:border-slate-300 transition-all">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>Back to Directory</span>
                </a>
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-100/50 hover:bg-brand-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Register User</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
