@extends('layouts.admin')

@section('title', 'Appointment Details')
@section('page_title', 'Session Intelligence')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">{{ $appointment->appointment_id }}</h1>
                <p class="text-sm text-white/70 mt-1">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }} &bull;
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border border-white/30 backdrop-blur-sm
                    @if($appointment->status === 'confirmed') bg-green-400/20 text-white
                    @elseif($appointment->status === 'pending') bg-orange-400/20 text-white
                    @else bg-white/10 text-white/70 @endif">
                    {{ $appointment->status }}
                </span>
                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="px-5 py-2 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-pencil-edit-02"></i>
                    <span>Modify</span>
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Date</p>
            <p class="text-sm font-black text-slate-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
            <p class="text-[9px] font-bold text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Time</p>
            <p class="text-sm font-black text-slate-900">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
            <p class="text-[9px] font-bold text-slate-400 mt-0.5">Scheduled</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Patient</p>
            <p class="text-sm font-black text-slate-900 truncate">{{ $appointment->patient->name }}</p>
            <p class="text-[9px] font-bold text-brand-600 uppercase mt-0.5">{{ $appointment->patient->patient_id }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Specialist</p>
            <p class="text-sm font-black text-slate-900 truncate">Dr. {{ $appointment->doctor->name }}</p>
            <p class="text-[9px] font-bold text-brand-600 uppercase mt-0.5 truncate">{{ $appointment->doctor->specialization }}</p>
        </div>
    </div>

    <!-- People + Session Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Patient Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-user text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Patient Assignment</h3>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                    <i class="hgi-stroke hgi-user text-brand-600 text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black text-slate-900">{{ $appointment->patient->name }}</p>
                    <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mt-0.5">{{ $appointment->patient->patient_id }}</p>
                    <a href="{{ route('admin.patients.show', $appointment->patient) }}" class="inline-flex items-center space-x-1 text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-brand-600 mt-2 transition-colors">
                        <span>View Full Profile</span>
                        <i class="hgi-stroke hgi-arrow-right-01 text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Doctor Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-doctor-01 text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Consulting Specialist</h3>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                    <i class="hgi-stroke hgi-doctor-01 text-brand-600 text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black text-slate-900">Dr. {{ $appointment->doctor->name }}</p>
                    <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mt-0.5">{{ $appointment->doctor->specialization }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Attending Physician</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Details -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-file-attachment text-brand-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Session Details</h3>
        </div>
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Reason for Appointment</p>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-xs font-medium text-slate-700 leading-relaxed min-h-[80px]">
                    {{ $appointment->reason ?: 'No clinical reason provided.' }}
                </div>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Internal Notes</p>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-xs font-medium text-slate-700 leading-relaxed min-h-[80px]">
                    {{ $appointment->notes ?: 'No internal notes recorded.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-xl border border-red-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 bg-red-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-delete-02 text-red-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">Danger Zone</h3>
        </div>
        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">Delete this appointment record</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">This action is permanent and cannot be undone.</p>
            </div>
            <form id="del-appointment-{{ $appointment->id }}" action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="openConfirmModal('delete', 'Delete Appointment', 'Are you sure you want to permanently delete this appointment record? This cannot be undone.', 'del-appointment-{{ $appointment->id }}')"
                    class="shrink-0 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
                Delete Record
            </button>
        </div>
    </div>
</div>
@endsection
