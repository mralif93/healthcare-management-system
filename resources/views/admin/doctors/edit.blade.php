@extends('layouts.admin')

@section('title', 'Edit Doctor')
@section('page_title', 'Update Doctor Profile')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Edit Doctor Profile</h1>
                <p class="text-sm text-white/70 mt-1">{{ $doctor->staff_id }} &bull; {{ $doctor->name }}</p>
            </div>
            <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">
                Doctor Registry
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-red-600 text-xs font-medium space-y-1">
        @foreach($errors->all() as $error)
            <p>• {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-pencil-edit-02 text-brand-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Edit Doctor Account</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Updating profile for {{ $doctor->staff_id }}</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-brand-50 text-brand-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $doctor->name }}</span>
        </div>

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
            @csrf @method('PUT')
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $doctor->name) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400"></i> Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $doctor->email) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5">
                        <label for="phone" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-call text-slate-400"></i> Phone Number
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $doctor->phone) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Specialization -->
                    <div class="space-y-1.5">
                        <label for="specialization" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-stethoscope text-slate-400"></i> Specialization
                        </label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $doctor->specialization) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- New Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-lock-password text-slate-400"></i> New Password
                            <span class="text-[10px] text-slate-400 font-normal">(leave blank to keep)</span>
                        </label>
                        <input type="password" name="password" id="password" placeholder="Min. 8 characters"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-toggle-on text-slate-400"></i> Account Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="active" {{ old('status', $doctor->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $doctor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.doctors.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-white hover:border-slate-300 transition-all">
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

