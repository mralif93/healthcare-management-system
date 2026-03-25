@extends('layouts.admin')

@section('title', 'My Profile')
@section('page_title', 'Personnel Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 shrink-0">
                <i class="hgi-stroke hgi-user-circle text-4xl text-white"></i>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">{{ $user->name }}</h1>
                <div class="flex items-center space-x-3 mt-2">
                    <span class="px-3 py-1 bg-white/20 border border-white/30 rounded-lg text-[9px] font-black text-white uppercase tracking-widest">ID: {{ $user->staff_id }}</span>
                    <span class="px-3 py-1 bg-green-400/30 border border-green-300/30 rounded-lg text-[9px] font-black text-white uppercase tracking-widest">Active Session</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-3">
            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-user-edit-01 text-brand-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Profile Information</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Update your name, email and contact details</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf @method('PUT')

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter your full name"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400"></i> Work Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-call text-slate-400"></i> Contact Phone
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+60 xxx xxx xxxx"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <!-- Security Section -->
                <div class="pt-6 border-t border-slate-100">
                    <h4 class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-5">
                        <i class="hgi-stroke hgi-lock-password text-brand-600"></i> Change Password
                        <span class="text-[10px] text-slate-400 font-normal ml-1">(Leave blank to keep current)</span>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> New Password
                            </label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-lock-01 text-slate-400"></i> Confirm New Password
                            </label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex justify-end">
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-100/50 hover:bg-brand-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Save Profile</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
