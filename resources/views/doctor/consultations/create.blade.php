@extends('layouts.doctor')

@section('title', 'New Consultation')
@section('page_title', 'Clinical Intake')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <form action="{{ route('doctor.consultations.store') }}" method="POST" class="space-y-6">
        @csrf
        
        @if($appointment)
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
            
            <div class="bg-brand-600 rounded-xl p-6 text-white shadow-xl shadow-brand-100 flex justify-between items-center relative overflow-hidden">
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60">Linked Clinical Session</span>
                    <h3 class="text-xl font-bold tracking-tight">{{ $appointment->patient->name }}</h3>
                    <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mt-1">{{ $appointment->patient->patient_id }} • {{ $appointment->patient->age }}Y • {{ $appointment->patient->gender }}</p>
                </div>
                <div class="text-right relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Scheduled Time</p>
                    <p class="text-lg font-bold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                </div>
                <i class="hgi-stroke hgi-hospital-01 absolute -right-4 -bottom-4 text-8xl opacity-10 rotate-12"></i>
            </div>
        @else
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <label for="patient_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Initialize Patient Registry</label>
                <select name="patient_id" id="patient_id" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 transition-all outline-none">
                    <option value="">-- Search Directory --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->patient_id }})
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-note-01 text-brand-600"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Clinical Observation Notes</h3>
            </div>
            
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="consultation_date" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Session Date</label>
                        <input type="date" name="consultation_date" id="consultation_date" value="{{ date('Y-m-d') }}" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-xs font-bold text-slate-900 focus:bg-white outline-none focus:border-brand-500 transition-all">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="symptoms" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Presenting Symptoms</label>
                    <textarea name="symptoms" id="symptoms" rows="3" required placeholder="Subjective findings and patient complaints..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-medium text-slate-700 focus:bg-white outline-none focus:border-brand-500 transition-all">{{ old('symptoms') }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="diagnosis" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Clinical Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" rows="3" required placeholder="Objective findings and clinical impression..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 focus:bg-white outline-none focus:border-brand-500 transition-all">{{ old('diagnosis') }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="prescription" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Medical Prescription</label>
                    <textarea name="prescription" id="prescription" rows="4" placeholder="Rx: Medication, Dosage, Frequency, Duration..."
                        class="w-full bg-slate-900 text-brand-300 border-none rounded-xl px-6 py-4 text-xs font-mono leading-relaxed focus:ring-4 focus:ring-brand-500/10 transition-all">{{ old('prescription') }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="notes" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Internal Clinical Notes (Private)</label>
                    <textarea name="notes" id="notes" rows="2" placeholder="Confidential notes for specialist reference..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-medium text-slate-500 focus:bg-white outline-none focus:border-brand-500 transition-all">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30 flex justify-end space-x-3">
                <a href="{{ route('doctor.consultations.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all">Discard</a>
                <button type="submit" class="px-10 py-2.5 bg-brand-600 text-white rounded-lg text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Archive Session
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
