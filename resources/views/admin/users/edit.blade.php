@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Update Personnel Record')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Edit Personnel Record</h1>
                <p class="text-sm text-white/70 mt-1">{{ $user->name }} &bull; {{ ucfirst($user->role) }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">
                Directory
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
                    <h3 class="text-sm font-bold text-slate-900">Edit Personnel Record</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Update account information for {{ $user->name }}</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-brand-50 text-brand-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $user->role }}</span>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Full Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        @error('name') <p class="flex items-center gap-1 text-red-500 text-xs mt-1"><i class="hgi-stroke hgi-alert-circle text-xs"></i>{{ $message }}</p> @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400"></i> Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        @error('email') <p class="flex items-center gap-1 text-red-500 text-xs mt-1"><i class="hgi-stroke hgi-alert-circle text-xs"></i>{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5">
                        <label for="role" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-shield-user text-slate-400"></i> Access Role <span class="text-red-400">*</span>
                        </label>
                        <select name="role" id="role" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ old('role', $user->role) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-toggle-on text-slate-400"></i> Account Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Staff ID -->
                    <div class="space-y-1.5">
                        <label for="staff_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-id-verified text-slate-400"></i> Personnel ID <span class="text-[10px] text-slate-400 font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="staff_id" id="staff_id" value="{{ old('staff_id', $user->staff_id) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Specialization -->
                    <div class="space-y-1.5">
                        <label for="specialization" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-stethoscope text-slate-400"></i> Specialization
                        </label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $user->specialization) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <!-- Password Update Section -->
                <div class="pt-6 border-t border-slate-100">
                    <h4 class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-5">
                        <i class="hgi-stroke hgi-lock-password text-brand-600"></i> Security Update <span class="text-[10px] text-slate-400 font-normal ml-1">(Leave blank to keep current password)</span>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="password" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> New Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> Confirm Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
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
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
