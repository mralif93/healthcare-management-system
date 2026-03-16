@extends('layouts.admin')

@section('title', 'My Profile')
@section('page_title', 'Personnel Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">
    
    <!-- Profile Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-8 shadow-sm flex items-center space-x-8">
        <div class="w-24 h-24 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 shadow-inner">
            <i class="hgi-stroke hgi-user-circle text-5xl font-black"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">{{ $user->name }}</h2>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $user->role }} • Clinical Administrator</p>
            <div class="mt-4 flex items-center space-x-2">
                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-widest border border-slate-200">ID: {{ $user->staff_id }}</span>
                <span class="px-3 py-1 bg-green-50 rounded-lg text-[9px] font-black text-green-600 uppercase tracking-widest border border-green-100">Active Session</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-xl shadow-lg shadow-green-100 flex items-center space-x-3 animate-in fade-in slide-in-from-top-2 duration-300">
            <i class="hgi-stroke hgi-checkmark-circle-02"></i>
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Settings Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Identity Synchronization</h3>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-8 space-y-8">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Display Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Work Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50">
                <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-6 italic">Security Gateway</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Master Password</label>
                        <input type="password" name="password" placeholder="Leave blank to maintain current"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <button type="submit" class="px-10 py-3 bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-[0.3em] shadow-xl shadow-slate-200 hover:bg-brand-600 hover:-translate-y-0.5 transition-all active:scale-95">
                    Sync Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
