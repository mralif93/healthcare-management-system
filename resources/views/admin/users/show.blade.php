@extends('layouts.admin')

@section('title', 'Personnel Profile')
@section('page_title', 'Personnel Intelligence')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-20">
    <!-- Header Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 {{ $user->role === 'doctor' ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600' }} rounded-xl flex items-center justify-center shadow-inner">
                <i class="hgi-stroke {{ $user->role === 'doctor' ? 'hgi-doctor-01' : 'hgi-manager' }} text-3xl font-black"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $user->name }}</h2>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="text-[10px] font-black text-brand-600 uppercase tracking-widest">{{ $user->staff_id ?: 'ID PENDING' }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-black {{ $user->role === 'doctor' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-indigo-600 bg-indigo-50 border-indigo-100' }} border px-2 py-0.5 rounded uppercase tracking-widest">{{ $user->role }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
                <i class="hgi-stroke hgi-pencil-edit-02"></i>
                <span>Modify Profile</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-slate-100 text-slate-500 px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Directory
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Account Metadata -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Security & Status</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Account Status</span>
                        <span class="px-2 py-0.5 {{ $user->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} border rounded text-[9px] font-black uppercase">{{ $user->status }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Email Verified</span>
                        <span class="text-[10px] font-bold text-slate-600">{{ $user->email_verified_at ? 'AUTHORIZED' : 'PENDING' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Member Since</span>
                        <span class="text-[10px] font-bold text-slate-600 uppercase">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl p-6 text-white shadow-xl shadow-slate-200 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black text-brand-400 uppercase tracking-[0.2em] mb-4">Contact Gateway</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="hgi-stroke hgi-mail-01 text-brand-500 text-sm"></i>
                            <span class="text-xs font-bold truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="hgi-stroke hgi-phone text-brand-500 text-sm"></i>
                            <span class="text-xs font-bold">{{ $user->phone ?: 'No number linked' }}</span>
                        </div>
                    </div>
                </div>
                <i class="hgi-stroke hgi-security absolute -right-4 -bottom-4 text-7xl opacity-10"></i>
            </div>
        </div>

        <!-- Role Specific Intelligence -->
        <div class="lg:col-span-2 space-y-6">
            @if($user->role === 'doctor')
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                        <i class="hgi-stroke hgi-stethoscope text-emerald-600"></i>
                        <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Clinical Specialization</h3>
                    </div>
                    <div class="p-8">
                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ $user->specialization ?: 'General Practitioner' }}</p>
                        <p class="text-xs font-medium text-slate-500 mt-2 leading-relaxed">Authorized to conduct consultations, issue digital prescriptions, and manage patient medical history within the clinical vault.</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                    <i class="hgi-stroke hgi-analytics-up text-brand-600"></i>
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">System Activity Log</h3>
                </div>
                <div class="p-10 text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="hgi-stroke hgi-time-02 text-slate-300"></i>
                    </div>
                    <p class="text-xs font-medium text-slate-400">Activity monitoring is active. Access the Audit Logs module for full personnel session history.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
