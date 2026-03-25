@extends('layouts.doctor')

@section('title', 'New Consultation')
@section('page_title', 'Clinical Intake')

@section('content')
<div class="space-y-6 animate__animated animate__fadeInUp animate__faster">

    <!-- Hero Banner -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 80% 50%, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Clinical Module</p>
                <h1 class="text-2xl font-black tracking-tight">New Consultation</h1>
                @if($appointment ?? null)
                    <p class="text-sm text-white/70 mt-1">{{ $appointment->patient->name }} &bull; {{ $appointment->patient->patient_id }}</p>
                @else
                    <p class="text-sm text-white/70 mt-1">Clinical intake &amp; session documentation</p>
                @endif
            </div>
            <div class="flex items-center gap-4 shrink-0">
                @if($appointment ?? null)
                    <div class="text-center bg-white/10 border border-white/20 rounded-xl px-4 py-2.5">
                        <p class="text-[9px] font-black uppercase tracking-widest text-white/60">Scheduled</p>
                        <p class="text-base font-black mt-0.5">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                    </div>
                @endif
                <a href="{{ route('doctor.consultations.index') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-arrow-left-01"></i><span>All Records</span>
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('doctor.consultations.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- ── SECTION 1: Session & Patient ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-calendar-03 text-emerald-600 text-sm"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Session Details</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Appointment reference and session date</p>
                </div>
            </div>
            <div class="p-6">
                @if($appointment ?? null)
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Patient (read-only display) -->
                        <div class="md:col-span-2 space-y-1.5">
                            <p class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <i class="hgi-stroke hgi-user text-slate-400"></i> Patient
                            </p>
                            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm flex-shrink-0">
                                    {{ substr($appointment->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $appointment->patient->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $appointment->patient->patient_id }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Session Date -->
                        <div class="space-y-1.5">
                            <label for="consultation_date" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-calendar-03 text-slate-400"></i> Session Date <span class="text-red-400">*</span>
                            </label>
                            <input type="date" name="consultation_date" id="consultation_date" value="{{ old('consultation_date', date('Y-m-d')) }}" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Patient Select -->
                        <div class="md:col-span-2 space-y-1.5">
                            <label for="patient_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-user text-slate-400"></i> Patient <span class="text-red-400">*</span>
                            </label>
                            <select name="patient_id" id="patient_id" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                                <option value="">— Select Patient —</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->patient_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Session Date -->
                        <div class="space-y-1.5">
                            <label for="consultation_date" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <i class="hgi-stroke hgi-calendar-03 text-slate-400"></i> Session Date <span class="text-red-400">*</span>
                            </label>
                            <input type="date" name="consultation_date" id="consultation_date" value="{{ old('consultation_date', date('Y-m-d')) }}" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── SECTION 2: Presenting Symptoms ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="hgi-stroke hgi-activity-01 text-amber-600 text-sm"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Presenting Symptoms</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Subjective complaints and patient-reported findings</p>
                </div>
                <span class="ml-auto text-[9px] font-black text-red-400 uppercase tracking-widest bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">Required</span>
            </div>
            <div class="p-6">
                <textarea name="symptoms" id="symptoms" rows="4" required
                    placeholder="Describe the patient's chief complaint, onset, duration, severity, and any associated symptoms..."
                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all resize-none">{{ old('symptoms') }}</textarea>
                <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                    <i class="hgi-stroke hgi-information-circle text-xs"></i>
                    Include onset, duration, severity, and any aggravating or relieving factors.
                </p>
            </div>
        </div>

        {{-- ── SECTION 3: Diagnosis & Prescription ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <!-- Clinical Diagnosis -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="hgi-stroke hgi-health text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Clinical Diagnosis</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Objective findings and clinical impression</p>
                    </div>
                    <span class="ml-auto text-[9px] font-black text-red-400 uppercase tracking-widest bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">Required</span>
                </div>
                <div class="p-6">
                    <textarea name="diagnosis" id="diagnosis" rows="6" required
                        placeholder="Document the confirmed or differential diagnosis based on examination findings..."
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all resize-none">{{ old('diagnosis') }}</textarea>
                </div>
            </div>

            <!-- Medical Prescription -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="hgi-stroke hgi-medicine-01 text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide">Medical Prescription</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Rx — Medication, dosage, frequency &amp; duration</p>
                    </div>
                    <span class="ml-auto text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full">Optional</span>
                </div>
                <div class="p-6">
                    <textarea name="prescription" id="prescription" rows="6"
                        placeholder="e.g. Paracetamol 500mg — 3x daily for 5 days&#10;Amoxicillin 250mg — 2x daily for 7 days&#10;..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all font-mono resize-none">{{ old('prescription') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── SECTION 4: Internal Notes ── --}}
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
                <textarea name="notes" id="notes" rows="3"
                    placeholder="Specialist referral notes, follow-up instructions, or any confidential clinical observations..."
                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 outline-none transition-all resize-none">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- ── Form Actions ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-4 flex items-center justify-between">
            <a href="{{ route('doctor.consultations.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all">
                <i class="hgi-stroke hgi-arrow-left-01 text-sm"></i>
                <span>Back to Records</span>
            </a>
            <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                <i class="hgi-stroke hgi-checkmark-circle-02 text-sm"></i>
                <span>Save Consultation</span>
            </button>
        </div>

    </form>
</div>
@endsection
