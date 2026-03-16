@extends('layouts.staff')

@section('title', 'Doctor Schedules')
@section('page_title', 'Clinical Calendar')

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <form action="{{ route('staff.doctor-schedules') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end text-xs">
            <div class="space-y-1.5">
                <label for="doctor_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Specialist</label>
                <select name="doctor_id" id="doctor_id" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 transition-all outline-none">
                    <option value="">-- Choose Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $selectedDoctorId == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} ({{ $doctor->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1.5">
                <label for="date" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Calendar Date</label>
                <input type="date" name="date" id="date" value="{{ $date }}" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 transition-all outline-none">
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white px-6 py-2.5 rounded-lg font-black text-[10px] uppercase tracking-[0.2em] hover:bg-black transition-all shadow-lg shadow-slate-100">
                Synchronize Schedule
            </button>
        </form>
    </div>

    @if($selectedDoctorId)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-brand-50/30 flex justify-between items-center">
                <h3 class="text-xs font-black text-brand-600 uppercase tracking-widest">
                    Agenda for Dr. {{ $doctors->find($selectedDoctorId)->name }} • {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                </h3>
                <span class="text-[10px] font-black bg-white text-slate-500 px-3 py-1 rounded-full border border-slate-100 uppercase tracking-widest shadow-sm">
                    {{ count($appointments) }} Sessions
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/30 border-b border-slate-100">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-32">Slot Time</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Name</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Primary Reason</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($appointments as $apt)
                        <tr class="hover:bg-slate-50/50 transition-colors text-xs {{ $apt->status === 'cancelled' ? 'opacity-40 grayscale' : '' }}">
                            <td class="px-6 py-4 font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $apt->patient->name }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->patient->patient_id }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-500">
                                {{ Str::limit($apt->reason, 50) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase border
                                    @if($apt->status === 'confirmed') bg-green-50 text-green-600 border-green-100 
                                    @elseif($apt->status === 'pending') bg-orange-50 text-orange-600 border-orange-100 
                                    @else bg-slate-50 text-slate-400 border-slate-100 @endif">
                                    {{ $apt->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-20 text-center text-slate-400 text-xs italic">No clinical sessions booked for this specific period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-slate-50 rounded-2xl p-20 text-center border border-dashed border-slate-200">
            <i class="hgi-stroke hgi-doctor-01 text-6xl text-slate-200 mb-6 inline-block"></i>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">Initialize Specialist Filter to View Agenda</p>
        </div>
    @endif
</div>
@endsection
