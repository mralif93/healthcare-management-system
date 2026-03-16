@extends('layouts.doctor')

@section('title', 'Schedule')
@section('page_title', 'Daily Agenda')

@section('content')
<div class="mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-wrap justify-between items-center gap-4">
        <form action="{{ route('doctor.schedule') }}" method="GET" class="flex items-center space-x-4">
            <label for="date" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Date</label>
            <input type="date" name="date" id="date" value="{{ $date }}" 
                onchange="this.form.submit()"
                class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
        </form>
        <div class="text-right">
            <h3 class="text-lg font-bold text-slate-900 leading-none">{{ \Carbon\Carbon::parse($date)->format('l, M d') }}</h3>
            <p class="text-[10px] font-black text-brand-600 uppercase tracking-widest mt-1">{{ count($appointments) }} Clinical Sessions</p>
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
                                <a href="{{ route('doctor.consultations.create', $apt->id) }}" class="inline-flex px-4 py-1.5 bg-brand-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95">
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
