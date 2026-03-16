@extends('layouts.doctor')

@section('title', 'Patient Record')
@section('page_title', 'Clinical Intelligence')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-20">
    <!-- Clinical Summary Card -->
    <div class="bg-white rounded-xl border border-emerald-100 p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="hgi-stroke hgi-user text-3xl font-black"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $patient->name }}</h2>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="text-[10px] font-black text-brand-600 uppercase tracking-widest">{{ $patient->patient_id }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ ucfirst($patient->gender) }} • {{ $patient->age }} Years</span>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('doctor.consultations.create', ['patient_id' => $patient->id]) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-emerald-700 transition-all active:scale-95 flex items-center space-x-2">
                <i class="hgi-stroke hgi-plus-sign"></i>
                <span>New Consult</span>
            </a>
            <a href="{{ route('doctor.patients.index') }}" class="bg-slate-100 text-slate-500 px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Directory
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Medical Profile Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Bio-Stats</h3>
                </div>
                <div class="p-6 space-y-4 text-xs">
                    <div class="flex justify-between items-center border-b border-slate-50 pb-2">
                        <span class="font-black text-slate-400 uppercase">Blood Group</span>
                        <span class="font-black text-red-600">{{ $patient->blood_group ?: '??' }}</span>
                    </div>
                    <div class="space-y-1 pt-2">
                        <span class="font-black text-slate-400 uppercase text-[9px]">Last Phone</span>
                        <p class="font-bold text-slate-700">{{ $patient->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-emerald-50 shadow-sm overflow-hidden border-l-4 border-l-orange-500">
                <div class="px-6 py-4 border-b border-emerald-50 bg-emerald-50/30">
                    <h3 class="text-[10px] font-black text-orange-600 uppercase tracking-[0.2em]">Allergy Alert</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium text-slate-600 leading-relaxed italic">
                        {{ $patient->allergies ?: 'No critical clinical allergies reported.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Consultation History Timeline -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic">Full Consultation Timeline</h3>
            
            <div class="space-y-4">
                @forelse($allConsultations as $cons)
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden group hover:border-emerald-200 transition-all">
                        <div class="px-6 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="hgi-stroke hgi-calendar-01 text-xs text-slate-400"></i>
                                <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ \Carbon\Carbon::parse($cons->consultation_date)->format('M d, Y') }}</span>
                                <span class="text-[9px] font-bold text-slate-400 italic">by Dr. {{ $cons->doctor->name }}</span>
                            </div>
                            <a href="{{ route('doctor.consultations.show', $cons) }}" class="text-[9px] font-black text-brand-600 uppercase tracking-widest hover:underline">Full Report</a>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    </div>
                @empty
                    <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-16 text-center">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">No past clinical sessions archived.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
