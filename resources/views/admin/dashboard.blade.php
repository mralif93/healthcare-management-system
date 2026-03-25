@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Command Hero -->
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-600 to-brand-800 rounded-2xl p-6 text-white shadow-xl shadow-brand-900/20">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-1/2 w-64 h-32 bg-brand-500/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-brand-200 text-[10px] font-black uppercase tracking-[0.2em] mb-1">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                <h2 class="text-xl font-bold leading-tight">Good {{ \Carbon\Carbon::now()->hour < 12 ? 'Morning' : (\Carbon\Carbon::now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ Auth::user()->name }}!</h2>
                <p class="text-brand-200 text-sm mt-1 font-medium">Here's your clinic command overview for today.</p>
            </div>
            <div class="hidden sm:flex items-center space-x-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-5 py-3 flex-shrink-0">
                <i class="hgi-stroke hgi-hospital-01 text-3xl text-white/80"></i>
                <div>
                    <p class="text-[10px] font-black text-brand-100 uppercase tracking-[0.2em]">Today's Load</p>
                    <p class="text-2xl font-bold text-white leading-none mt-0.5">{{ $stats['appointments_today'] }}</p>
                    <p class="text-[10px] text-brand-200 font-medium mt-0.5">Appointments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-user-group text-brand-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Active</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_patients']) }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Total Patients</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-doctor-01 text-violet-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-violet-700 bg-violet-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Medical</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['total_doctors'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Doctors</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-calendar-01 text-orange-500 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-orange-700 bg-orange-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Today</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['appointments_today'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Appointments</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-manager text-indigo-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Ops</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['total_staff'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Staff Members</p>
        </div>
    </div>

    <!-- Data Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Recent Appointments -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="hgi-stroke hgi-calendar-01 text-brand-600 text-sm"></i>
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Recent Appointments</h3>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="text-[10px] font-bold text-brand-600 hover:text-brand-800 transition-colors flex items-center space-x-1 uppercase tracking-widest">
                    <span>View All</span>
                    <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recent_appointments as $apt)
                <div class="flex items-center space-x-4 px-6 py-3.5 hover:bg-slate-50/60 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ substr($apt->patient->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 leading-none truncate">{{ $apt->patient->name }}</p>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Dr. {{ $apt->doctor->name }} · {{ $apt->patient->patient_id }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @php
                            $statusMap = [
                                'confirmed'  => 'bg-green-50 text-green-700 border-green-100',
                                'pending'    => 'bg-orange-50 text-orange-700 border-orange-100',
                                'completed'  => 'bg-blue-50 text-blue-700 border-blue-100',
                                'cancelled'  => 'bg-red-50 text-red-600 border-red-100',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide border {{ $statusMap[$apt->status] ?? 'bg-slate-50 text-slate-500 border-slate-100' }}">
                            {{ $apt->status }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-14 text-center">
                    <i class="hgi-stroke hgi-calendar-01 text-4xl text-slate-200 block mb-3"></i>
                    <p class="text-sm text-slate-400 font-medium">No recent appointments found.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- New Registrations -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-user-add-01 text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">New Registrations</h3>
            </div>
            <div class="divide-y divide-slate-50 flex-1">
                @forelse($recent_patients as $patient)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50/60 transition-colors group">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 text-xs font-bold flex-shrink-0">
                            {{ substr($patient->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 leading-none">{{ $patient->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $patient->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.patients.show', $patient->id) }}"
                       class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-brand-600 flex items-center justify-center text-slate-400 group-hover:text-white transition-all flex-shrink-0">
                        <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
                    </a>
                </div>
                @empty
                <div class="px-6 py-14 text-center">
                    <i class="hgi-stroke hgi-user-add-01 text-4xl text-slate-200 block mb-3"></i>
                    <p class="text-sm text-slate-400 font-medium">No new registrations yet.</p>
                </div>
                @endforelse
            </div>
            <div class="px-6 py-3.5 bg-slate-50/50 border-t border-slate-100">
                <a href="{{ route('admin.patients.index') }}"
                   class="flex items-center justify-center space-x-1.5 text-[10px] font-bold text-slate-500 hover:text-brand-600 transition-colors uppercase tracking-widest">
                    <span>View Patient Registry</span>
                    <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
