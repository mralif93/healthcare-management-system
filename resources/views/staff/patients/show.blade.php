@extends('layouts.staff')

@section('title', 'Patient Details')
@section('page_title', 'Clinical Record')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div class="bg-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 shrink-0">
                    <i class="hgi-stroke hgi-user text-3xl text-white"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Clinical Record</p>
                    <h1 class="text-2xl font-black tracking-tight">{{ $patient->name }}</h1>
                    <p class="text-sm text-white/70 mt-1">
                        {{ $patient->patient_id }} &bull; {{ ucfirst($patient->gender) }} &bull; {{ $patient->age }} Yrs
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('staff.appointments.create', ['patient_id' => $patient->id]) }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-calendar-add-01"></i>
                    <span>Book Appointment</span>
                </a>
                <a href="{{ route('staff.patients.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Registry
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Patient ID</p>
            <p class="text-sm font-black text-indigo-600 uppercase">{{ $patient->patient_id }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Gender / Age</p>
            <p class="text-sm font-black text-slate-900 capitalize">{{ $patient->gender }}, {{ $patient->age }} yrs</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Blood Group</p>
            <p class="text-sm font-black text-red-600">{{ $patient->blood_group ?: 'Unknown' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Registered</p>
            <p class="text-sm font-black text-slate-900">{{ $patient->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- 3-Column Equal Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-contact text-indigo-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Patient Contact</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-call text-indigo-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Phone</p>
                        <p class="text-xs font-bold text-slate-700">{{ $patient->phone }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-mail-01 text-indigo-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Email</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $patient->email ?: 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-location-01 text-indigo-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Address</p>
                        <p class="text-xs font-bold text-slate-700 leading-relaxed">{{ $patient->address ?: 'No registered address.' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-pulse-01 text-indigo-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Status</p>
                        <span class="inline-flex px-2 py-0.5 {{ $patient->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} border rounded text-[9px] font-black uppercase">{{ $patient->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Allergy Alert -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-alert-circle text-indigo-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Allergy Alert</h3>
            </div>
            <div class="p-6">
                <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100 min-h-[120px]">
                    {{ $patient->allergies ?: 'No known clinical allergies reported.' }}
                </p>
            </div>
        </div>

        <!-- Clinical History -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-file-attachment text-indigo-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Clinical History</h3>
            </div>
            <div class="p-6">
                <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100 min-h-[120px]">
                    {{ $patient->medical_history ?: 'No medical history recorded.' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
