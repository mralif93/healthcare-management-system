@extends('layouts.doctor')

@section('title', 'Consultation Record')
@section('page_title', 'Consultation Record')

@section('content')
<div class="space-y-5 pb-6 animate__animated animate__fadeInUp animate__faster">

    {{-- ── Hero Banner ── --}}
    <div class="bg-emerald-600 rounded-2xl p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 80% 50%, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Clinical Module</p>
                <h1 class="text-2xl font-black tracking-tight">Consultation Record</h1>
                <p class="text-sm text-white/70 mt-1">
                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('l, F j, Y') }} &bull; {{ $consultation->patient->name }}
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button onclick="window.print()" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-printer"></i>
                    <span>Print Report</span>
                </button>
                <a href="{{ route('doctor.consultations.index') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>All Records</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Session Overview Strip ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Patient --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-user text-emerald-600 text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Patient</p>
                <p class="text-sm font-bold text-slate-900 truncate">{{ $consultation->patient->name }}</p>
                <p class="text-[10px] font-semibold text-emerald-600 mt-0.5">{{ $consultation->patient->patient_id }}</p>
            </div>
        </div>
        {{-- Date --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-calendar-03 text-blue-600 text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Session Date</p>
                <p class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M d, Y') }}</p>
                <p class="text-[10px] font-semibold text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('l') }}</p>
            </div>
        </div>
        {{-- Physician --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-doctor-01 text-violet-600 text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Attending Physician</p>
                <p class="text-sm font-bold text-slate-900 truncate">{{ $consultation->doctor->name }}</p>
                <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Recorded {{ $consultation->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- ── Symptoms ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
            <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-activity-01 text-amber-600 text-sm"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Presenting Symptoms</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Subjective complaints and patient-reported findings</p>
            </div>
        </div>
        <div class="p-6">
            <div class="text-sm text-slate-700 leading-relaxed bg-amber-50/40 border border-amber-100 rounded-xl p-4 min-h-[80px]">
                {!! nl2br(e($consultation->symptoms ?: '— No symptoms recorded for this session.')) !!}
            </div>
        </div>
    </div>

    {{-- ── Diagnosis & Prescription ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Diagnosis --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-health text-blue-600 text-sm"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Clinical Diagnosis</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Objective findings and clinical impression</p>
                </div>
            </div>
            <div class="p-6">
                <div class="text-sm text-slate-700 leading-relaxed bg-blue-50/40 border border-blue-100 rounded-xl p-4 min-h-[120px]">
                    {!! nl2br(e($consultation->diagnosis ?: '— No diagnosis recorded for this session.')) !!}
                </div>
            </div>
        </div>

        {{-- Prescription --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-medicine-01 text-emerald-600 text-sm"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Medical Prescription</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Rx — Medication, dosage, frequency &amp; duration</p>
                </div>
            </div>
            <div class="p-6">
                <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 border border-slate-200 rounded-xl p-4 min-h-[120px] font-mono whitespace-pre-wrap">
                    {!! nl2br(e($consultation->prescription ?: '— No medication prescribed for this session.')) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- ── Internal Notes (conditional) ── --}}
    @if($consultation->notes)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
            <div class="w-8 h-8 bg-violet-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-bubble-chat-lock text-violet-600 text-sm"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Internal Notes</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Private physician notes — not shared with patient</p>
            </div>
            <span class="ml-auto flex items-center gap-1 text-[9px] font-black text-violet-600 uppercase tracking-widest bg-violet-50 border border-violet-100 px-2 py-0.5 rounded-full">
                <i class="hgi-stroke hgi-lock-01 text-[9px]"></i> Confidential
            </span>
        </div>
        <div class="p-6">
            <div class="text-sm text-slate-600 leading-relaxed bg-violet-50/40 border border-violet-100 rounded-xl p-4 italic">
                {!! nl2br(e($consultation->notes)) !!}
            </div>
        </div>
    </div>
    @endif

    {{-- ── Record Footer ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <i class="hgi-stroke hgi-doctor-01 text-emerald-600 text-xs"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Attending Specialist</p>
                <p class="text-xs font-bold text-slate-800">{{ $consultation->doctor->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-[9px] font-semibold text-slate-400 uppercase tracking-widest">
            <i class="hgi-stroke hgi-clock-01 text-xs"></i>
            Recorded {{ $consultation->created_at->format('M d, Y \a\t H:i') }}
        </div>
    </div>

</div>
@endsection
