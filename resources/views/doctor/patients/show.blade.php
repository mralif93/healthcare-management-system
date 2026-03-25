@extends('layouts.doctor')

@section('title', 'Patient Record')
@section('page_title', 'Clinical Intelligence')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
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
                <a href="{{ route('doctor.consultations.create', ['patient_id' => $patient->id]) }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-plus-sign"></i>
                    <span>New Consult</span>
                </a>
                <a href="{{ route('doctor.patients.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Directory
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Patient ID</p>
            <p class="text-sm font-black text-emerald-600 uppercase">{{ $patient->patient_id }}</p>
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
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</p>
            <span class="inline-flex px-2 py-0.5 {{ $patient->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} border rounded text-[10px] font-black uppercase">{{ $patient->status }}</span>
        </div>
    </div>

    <!-- Contact + Bio / Allergy (2-col) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contact & Bio -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-heart-check text-emerald-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Contact & Bio</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-call text-emerald-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Phone</p>
                        <p class="text-xs font-bold text-slate-700">{{ $patient->phone }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-mail-01 text-emerald-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Email</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $patient->email ?: 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-location-01 text-emerald-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Address</p>
                        <p class="text-xs font-bold text-slate-700 leading-relaxed">{{ $patient->address ?: 'No registered address.' }}</p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-50 flex justify-between items-center">
                    <span class="text-[9px] font-black text-slate-400 uppercase">Registered</span>
                    <span class="text-[10px] font-bold text-slate-700">{{ $patient->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Allergy Alert -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-alert-circle text-emerald-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Allergy Alert</h3>
            </div>
            <div class="p-6">
                <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100 min-h-[100px]">
                    {{ $patient->allergies ?: 'No critical clinical allergies reported.' }}
                </p>
                @if($patient->medical_history)
                <div class="mt-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Medical History</p>
                    <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                        {{ $patient->medical_history }}
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Full Consultation Timeline (full-width) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-calendar-01 text-emerald-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Full Consultation Timeline</h3>
        </div>
        <div class="p-6 space-y-4">
            @forelse($allConsultations as $cons)
                <div class="rounded-xl border border-slate-200 overflow-hidden group hover:border-emerald-200 transition-all">
                    <div class="px-6 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <i class="hgi-stroke hgi-calendar-01 text-xs text-slate-400"></i>
                            <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ \Carbon\Carbon::parse($cons->consultation_date)->format('M d, Y') }}</span>
                            <span class="text-[9px] font-bold text-slate-400">by Dr. {{ $cons->doctor->name }}</span>
                        </div>
                        <a href="{{ route('doctor.consultations.show', $cons) }}" class="inline-flex items-center space-x-1 text-[9px] font-black text-emerald-600 uppercase tracking-widest hover:underline">
                            <span>Full Report</span>
                            <i class="hgi-stroke hgi-arrow-right-01 text-[10px]"></i>
                        </a>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Diagnosis</p>
                            <p class="text-xs font-bold text-slate-800 leading-relaxed">{{ $cons->diagnosis }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Prescription</p>
                            <p class="text-xs font-medium text-slate-500 leading-relaxed line-clamp-2">{{ $cons->prescription ?: 'No drugs issued.' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-12 text-center">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto mb-3 border border-slate-200">
                        <i class="hgi-stroke hgi-calendar-01 text-slate-300"></i>
                    </div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">No past clinical sessions archived.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
