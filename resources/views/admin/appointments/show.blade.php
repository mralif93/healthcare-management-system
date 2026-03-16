@extends('layouts.admin')

@section('title', 'Appointment Details')
@section('page_title', 'Session Intelligence')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">
    <!-- Header Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600 shadow-inner">
                <i class="hgi-stroke hgi-calendar-01 text-3xl font-black"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $appointment->appointment_id }}</h2>
                <div class="flex items-center space-x-3 mt-1 text-slate-400">
                    <span class="text-[10px] font-black text-brand-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border
                @if($appointment->status === 'confirmed') bg-green-50 text-green-600 border-green-100 
                @elseif($appointment->status === 'pending') bg-orange-50 text-orange-600 border-orange-100 
                @else bg-slate-50 text-slate-400 border-slate-100 @endif">
                {{ $appointment->status }}
            </span>
            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95">
                Modify
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Patient Info -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Patient Assignment</h3>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                    <i class="hgi-stroke hgi-user text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900">{{ $appointment->patient->name }}</p>
                    <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mt-0.5">ID: {{ $appointment->patient->patient_id }}</p>
                    <a href="{{ route('admin.patients.show', $appointment->patient_id) }}" class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-brand-600 mt-2 block transition-colors">View Medical Profile</a>
                </div>
            </div>
        </div>

        <!-- Doctor Info -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Consulting Specialist</h3>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                    <i class="hgi-stroke hgi-doctor-01 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900">Dr. {{ $appointment->doctor->name }}</p>
                    <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mt-0.5">{{ $appointment->doctor->specialization }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Clinical Details -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Session Intelligence</h3>
        </div>
        <div class="p-8 space-y-8">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Reason for Appointment</p>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-xs font-medium text-slate-700 leading-relaxed italic">
                    "{{ $appointment->reason ?: 'No clinical reason provided.' }}"
                </div>
            </div>
            @if($appointment->notes)
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-right">Internal Administration Notes</p>
                <div class="bg-slate-900 text-slate-300 p-4 rounded-lg text-xs font-medium leading-relaxed">
                    {{ $appointment->notes }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="flex justify-end">
        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Permanently delete this record?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-[10px] font-black text-red-400 uppercase tracking-[0.2em] hover:text-red-600 transition-colors">Terminate Record</button>
        </form>
    </div>
</div>
@endsection
