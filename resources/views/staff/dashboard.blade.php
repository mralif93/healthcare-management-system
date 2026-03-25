@extends('layouts.staff')

@section('title', 'Dashboard')
@section('page_title', 'Operations Dashboard')

@section('content')
<div class="space-y-5">

    <!-- Hero Action Bar -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-6 text-white shadow-xl shadow-indigo-900/20">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-1/3 w-56 h-28 bg-indigo-500/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 mb-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em]">Live System Feed</p>
                </div>
                <h2 class="text-xl font-bold leading-tight">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-indigo-200 text-sm mt-1 font-medium">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
            </div>
            <div class="flex items-center space-x-2 flex-shrink-0">
                <a href="{{ route('staff.patients.create') }}"
                   class="flex items-center space-x-2 bg-white text-indigo-700 px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:bg-indigo-50 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-user-add-01 text-base"></i>
                    <span>Register Patient</span>
                </a>
                <a href="{{ route('staff.appointments.create') }}"
                   class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-white/20 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-calendar-add-01 text-base"></i>
                    <span>New Booking</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-calendar-01 text-indigo-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Today</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['today_appointments'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Appointments</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-green-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Done</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['checked_in'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Checked In</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-time-02 text-orange-500 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-orange-700 bg-orange-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Waiting</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['pending_appointments'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Pending</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-user-add-01 text-blue-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-widest">New</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['new_patients'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">New Patients</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Patient Queue -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="hgi-stroke hgi-queue-01 text-indigo-600 text-sm"></i>
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Active Patient Queue</h3>
                </div>
                <a href="{{ route('staff.checkin') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center space-x-1 uppercase tracking-widest">
                    <span>Manage Check-ins</span>
                    <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($upcoming as $apt)
                <div class="flex items-center space-x-4 px-6 py-3.5 hover:bg-slate-50/60 transition-colors group">
                    <div class="text-center w-12 flex-shrink-0">
                        <p class="text-sm font-bold text-slate-900 leading-none">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i') }}</p>
                        <p class="text-[9px] font-semibold text-slate-400 uppercase mt-0.5">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('A') }}</p>
                    </div>
                    <div class="w-px h-8 bg-slate-100 flex-shrink-0"></div>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm flex-shrink-0">
                        {{ substr($apt->patient->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 leading-none truncate">{{ $apt->patient->name }}</p>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Dr. {{ $apt->doctor->name }} · {{ $apt->patient->patient_id }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($apt->status === 'pending')
                            <a href="{{ route('staff.checkin', ['search' => $apt->appointment_id]) }}"
                               class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-green-600 text-white rounded-xl text-xs font-semibold hover:bg-green-700 transition-all active:scale-95 shadow-sm shadow-green-200">
                                <i class="hgi-stroke hgi-checkmark-circle-02 text-sm"></i>
                                <span>Check In</span>
                            </a>
                        @else
                            <span class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-50 text-slate-400 rounded-xl text-xs font-semibold border border-slate-100">
                                <i class="hgi-stroke hgi-tick-double-01 text-sm"></i>
                                <span>Arrived</span>
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-14 text-center">
                    <i class="hgi-stroke hgi-queue-01 text-4xl text-slate-200 block mb-3"></i>
                    <p class="text-sm text-slate-400 font-medium">Queue is clear for now.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- In-Clinic Doctors -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-doctor-01 text-emerald-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">In Clinic Today</h3>
            </div>
            <div class="divide-y divide-slate-50 flex-1">
                @forelse($doctors as $doctor)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50/60 transition-colors group">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 text-sm font-bold">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-green-500 border-2 border-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 leading-none">{{ $doctor->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $doctor->specialization ?? 'General' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.doctor-schedules', ['doctor_id' => $doctor->id]) }}"
                       class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-indigo-600 flex items-center justify-center text-slate-400 group-hover:text-white transition-all">
                        <i class="hgi-stroke hgi-calendar-01 text-xs"></i>
                    </a>
                </div>
                @empty
                <div class="px-6 py-14 text-center">
                    <i class="hgi-stroke hgi-doctor-01 text-4xl text-slate-200 block mb-3"></i>
                    <p class="text-sm text-slate-400 font-medium">No doctors on schedule today.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
