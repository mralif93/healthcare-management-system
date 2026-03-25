@extends('layouts.doctor')

@section('title', 'Schedule')
@section('page_title', 'Daily Agenda')

@section('content')
<div class="mx-auto space-y-6">

    <!-- Hero Section -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Clinical Module</p>
                <h1 class="text-2xl font-black tracking-tight">Daily Schedule</h1>
                <p class="text-sm text-white/70 mt-1">
                    {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }} &bull; {{ count($appointments) }} Sessions
                </p>
            </div>
            <form action="{{ route('doctor.schedule') }}" method="GET" class="flex items-center space-x-3">
                <label for="date" class="text-[10px] font-black text-white/60 uppercase tracking-widest shrink-0">Date</label>
                <input type="date" name="date" id="date" value="{{ $date }}"
                    onchange="this.form.submit()"
                    class="bg-white/20 border border-white/30 backdrop-blur-sm rounded-xl px-4 py-2 text-xs font-bold text-white placeholder-white/50 focus:bg-white/30 outline-none transition-all">
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-32">Slot Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Details</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Primary Reason</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Current Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Operation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-xs">
                    @forelse($appointments as $apt)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-black text-slate-900 leading-none uppercase">
                            {{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 leading-none">{{ $apt->patient->name }}</div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">ID: {{ $apt->patient->patient_id }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-500 leading-relaxed italic">
                            "{{ Str::limit($apt->reason, 40) }}"
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border
                                @if($apt->status === 'confirmed') bg-green-50 text-green-600 border-green-100 
                                @elseif($apt->status === 'pending') bg-orange-50 text-orange-600 border-orange-100 
                                @elseif($apt->status === 'completed') bg-blue-50 text-blue-600 border-blue-100 
                                @else bg-slate-50 text-slate-400 border-slate-100 @endif">
                                {{ $apt->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($apt->status !== 'completed' && $apt->status !== 'cancelled')
                                <a href="{{ route('doctor.consultations.create', $apt->id) }}" class="inline-flex px-4 py-1.5 bg-emerald-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-md hover:bg-emerald-700 transition-all active:scale-95">
                                    Start Consult
                                </a>
                            @else
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] italic">Archive Ready</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400 text-xs italic">
                            No appointments found for this specific clinical period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
