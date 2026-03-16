@extends('layouts.doctor')

@section('title', 'Consultation Record')
@section('page_title', 'Session Intelligence')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <a href="{{ route('doctor.consultations.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors flex items-center space-x-2 group">
            <i class="hgi-stroke hgi-arrow-left-01 text-sm group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] font-black uppercase tracking-widest">Return to Archive</span>
        </a>
        <button onclick="window.print()" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest flex items-center space-x-2 hover:bg-black transition-all shadow-lg shadow-slate-200">
            <i class="hgi-stroke hgi-printer"></i>
            <span>Generate Report</span>
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="text-[10px] font-black text-brand-600 uppercase tracking-[0.2em] mb-1 block">Clinical Summary</span>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Consultation Record</h2>
                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('l, F j, Y') }}</p>
            </div>
            <div class="text-left md:text-right border-l-4 md:border-l-0 md:border-r-4 border-emerald-500 pl-4 md:pl-0 md:pr-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient File</p>
                <p class="text-lg font-bold text-slate-900 leading-tight">{{ $consultation->patient->name }}</p>
                <p class="text-[10px] font-bold text-brand-600 uppercase tracking-widest mt-1">{{ $consultation->patient->patient_id }}</p>
            </div>
        </div>

        <div class="p-10 space-y-10">
            <!-- Symptoms -->
            <section>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Subjective Findings (Symptoms)</h3>
                <div class="text-xs font-medium text-slate-700 leading-relaxed bg-slate-50 p-6 rounded-xl border border-slate-100 italic">
                    {!! nl2br(e($consultation->symptoms)) !!}
                </div>
            </section>

            <!-- Diagnosis -->
            <section>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Clinical Impression (Diagnosis)</h3>
                <div class="text-sm font-bold text-slate-900 leading-relaxed bg-emerald-50/50 border-l-4 border-emerald-500 p-6 rounded-r-xl">
                    {!! nl2br(e($consultation->diagnosis)) !!}
                </div>
            </section>

            <!-- Prescription -->
            <section>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Medical Prescription (Rx)</h3>
                <div class="bg-slate-900 text-brand-300 p-8 rounded-2xl font-mono text-xs leading-relaxed shadow-inner border border-white/5">
                    <div class="mb-4 flex items-center space-x-2 text-white/40">
                        <i class="hgi-stroke hgi-hospital-01"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Pharmacy Authorization</span>
                    </div>
                    {!! nl2br(e($consultation->prescription ?: 'No medication issued for this session.')) !!}
                </div>
            </section>

            @if($consultation->notes)
            <section>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Specialist Annotations</h3>
                <div class="text-xs font-medium text-slate-500 italic leading-relaxed">
                    {!! nl2br(e($consultation->notes)) !!}
                </div>
            </section>
            @endif
        </div>

        <div class="px-10 py-6 border-t border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-2">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Attending Specialist:</span>
                <span class="text-[10px] font-bold text-slate-900 uppercase tracking-widest">Dr. {{ $consultation->doctor->name }}</span>
            </div>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest tracking-tighter">System Log: {{ $consultation->created_at->format('M d, Y • H:i') }}</p>
        </div>
    </div>
</div>
@endsection
