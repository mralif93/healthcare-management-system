@extends('layouts.doctor')

@section('title', 'Dashboard')
@section('page_title', 'Clinical Console')

@section('content')
<div class="space-y-5">

    <!-- Next Patient Hero -->
    @if($next_patient)
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl p-6 text-white shadow-xl shadow-emerald-900/20">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-1/3 w-64 h-28 bg-emerald-500/20 rounded-full blur-3xl"></div>
            </div>
            <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                        {{ substr($next_patient->patient->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center space-x-2 mb-1.5">
                            <span class="inline-flex items-center space-x-1.5 bg-white/15 border border-white/20 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-300 animate-pulse"></span>
                                <span>Next Up · {{ \Carbon\Carbon::parse($next_patient->appointment_time)->format('h:i A') }}</span>
                            </span>
                        </div>
                        <h2 class="text-xl font-bold leading-tight">{{ $next_patient->patient->name }}</h2>
                        @if($next_patient->reason)
                            <p class="text-emerald-200 text-sm mt-1 font-medium">"{{ Str::limit($next_patient->reason, 70) }}"</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('doctor.consultations.create', $next_patient->id) }}"
                   class="flex items-center space-x-2 bg-white text-emerald-700 px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:bg-emerald-50 transition-all active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-stethoscope text-base"></i>
                    <span>Start Consultation</span>
                </a>
            </div>
        </div>
    @else
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 text-white shadow-xl">
            <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="hgi-stroke hgi-coffee-01 text-xl text-white/70"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        <h2 class="text-lg font-bold">No pending patients</h2>
                        <p class="text-slate-400 text-sm mt-0.5">Your queue is clear for this session. Enjoy the downtime!</p>
                    </div>
                </div>
                <a href="{{ route('doctor.patients.index') }}"
                   class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-white/20 transition-all active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-user-group text-base"></i>
                    <span>View Patients</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Stats Strip -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-time-02 text-emerald-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-orange-700 bg-orange-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Pending</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['remaining_today'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Remaining Today</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-blue-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Done</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['completed_today'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Completed Today</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center">
                    <i class="hgi-stroke hgi-user-group text-violet-600 text-lg"></i>
                </div>
                <span class="text-[9px] font-bold text-violet-700 bg-violet-50 px-2 py-0.5 rounded-full uppercase tracking-widest">Registry</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['total_patients'] }}</p>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mt-1">Total Patients</p>
        </div>
    </div>

    <!-- Recent Consultations -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="hgi-stroke hgi-clipboard text-emerald-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Recent Consultations</h3>
            </div>
            <a href="{{ route('doctor.consultations.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-800 transition-colors flex items-center space-x-1 uppercase tracking-widest">
                <span>View All</span>
                <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
            </a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recent_consultations as $cons)
            <div class="flex items-center space-x-4 px-6 py-3.5 hover:bg-slate-50/60 transition-colors group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    {{ substr($cons->patient->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 leading-none truncate">{{ $cons->patient->name }}</p>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">{{ \Carbon\Carbon::parse($cons->consultation_date)->format('d M Y') }} · {{ $cons->patient->patient_id }}</p>
                </div>
                <a href="{{ route('doctor.consultations.show', $cons->id) }}"
                   class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-emerald-600 flex items-center justify-center text-slate-400 group-hover:text-white transition-all flex-shrink-0">
                    <i class="hgi-stroke hgi-arrow-right-01 text-sm"></i>
                </a>
            </div>
            @empty
            <div class="px-6 py-14 text-center">
                <i class="hgi-stroke hgi-clipboard text-4xl text-slate-200 block mb-3"></i>
                <p class="text-sm text-slate-400 font-medium">No clinical records yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
