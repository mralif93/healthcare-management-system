@extends('layouts.staff')

@section('title', 'Appointments')
@section('page_title', 'Operational Schedule')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Clinical Bookings</h3>
        <a href="{{ route('staff.appointments.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
            <i class="hgi-stroke hgi-calendar-add-01"></i>
            <span>New Booking</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3">
        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
        <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap gap-4 items-center">
            <form action="{{ route('staff.appointments.index') }}" method="GET" class="flex-1 min-w-[300px] flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID or Patient Name..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all">
                </div>
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Search Bookings</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Appointment ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Details</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Assigned Doctor</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Current Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Ticket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($appointments as $apt)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4">
                            <div class="text-center">
                                <p class="font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i') }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('A') }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-black text-brand-600 uppercase tracking-tighter">{{ $apt->appointment_id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $apt->patient->name }}</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">{{ $apt->patient->patient_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                <span class="font-bold text-slate-600 italic">Dr. {{ $apt->doctor->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                @if($apt->status === 'confirmed') bg-green-50 text-green-600 border-green-100
                                @elseif($apt->status === 'pending') bg-orange-50 text-orange-600 border-orange-100
                                @elseif($apt->status === 'completed') bg-blue-50 text-blue-600 border-blue-100
                                @else bg-slate-50 text-slate-400 border-slate-100 @endif">
                                {{ $apt->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($apt->qr_token)
                            <a href="{{ route('staff.appointments.ticket', $apt) }}" target="_blank"
                               title="Print Ticket"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-500 border border-indigo-100 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zM6 20h4"/></svg>
                            </a>
                            @else
                            <span class="text-slate-200 text-[9px]">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-20 text-center text-slate-400 text-xs italic">No clinical bookings scheduled.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
