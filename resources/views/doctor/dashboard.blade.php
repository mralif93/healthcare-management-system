@extends('layouts.doctor')

@section('title', 'Dashboard')
@section('page_title', 'Clinical Overview')

@section('content')
<div class="space-y-6">
    
    <!-- Compact Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 shrink-0">
                <i class="hgi-stroke hgi-time-02 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Remaining</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['remaining_today'] }} Patients</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                <i class="hgi-stroke hgi-checkmark-circle-02 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Completed</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['completed_today'] }} Consults</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-emerald-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 shrink-0">
                <i class="hgi-stroke hgi-user-group text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Registry</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['total_patients'] }} Patients</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Next Patient: Professional Focus -->
        <div class="space-y-6">
            @if($next_patient)
                <div class="bg-white rounded-xl border-2 border-emerald-500 p-6 shadow-lg shadow-emerald-100 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                                <i class="hgi-stroke hgi-user text-3xl font-black"></i>
                            </div>
                            <div>
                                <span class="bg-emerald-500 text-white text-[9px] font-bold uppercase px-2 py-0.5 rounded-full mb-1 inline-block tracking-widest">Next Up • {{ \Carbon\Carbon::parse($next_patient->appointment_time)->format('h:i A') }}</span>
                                <h2 class="text-2xl font-bold text-slate-900 leading-tight">{{ $next_patient->patient->name }}</h2>
                                <p class="text-slate-500 text-xs font-medium italic mt-1">"{{ Str::limit($next_patient->reason, 60) }}"</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('doctor.consultations.create', $next_patient->id) }}" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-emerald-700 transition-all active:scale-95">
                                Start Consult
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-slate-50 rounded-xl p-10 text-center border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium">No pending appointments for this session.</p>
                </div>
            @endif

            <!-- Recent Activity List -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Recent Consultations</h3>
                    <a href="{{ route('doctor.consultations.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 uppercase">View History</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recent_consultations as $cons)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] font-bold uppercase">
                                    {{ substr($cons->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">{{ $cons->patient->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-widest">{{ \Carbon\Carbon::parse($cons->consultation_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('doctor.consultations.show', $cons->id) }}" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:text-emerald-600 transition-all">
                                <i class="hgi-stroke hgi-view-list-01 text-xs"></i>
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-slate-400 text-xs italic">No clinical records found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
