@extends('layouts.admin')

@section('title', 'Appointment Management')
@section('page_title', 'Appointment Schedule')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Clinical Calendar</h3>
        <a href="{{ route('admin.appointments.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
            <i class="hgi-stroke hgi-calendar-add-01"></i>
            <span>Schedule Session</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3">
        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
        <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('admin.appointments.index') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID, Patient, or Doctor..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all">
                </div>
                <select name="status" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-600 outline-none">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Appointment ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Doctor</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($appointments as $apt)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4 font-black text-brand-600 uppercase tracking-tighter">{{ $apt->appointment_id }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">
                            {{ \Carbon\Carbon::parse($apt->appointment_date)->format('M d, Y') }} <br>
                            <span class="text-[10px] text-slate-400 font-medium uppercase">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $apt->patient->name }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700">Dr. {{ $apt->doctor->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border
                                @if($apt->status === 'confirmed') bg-green-50 text-green-600 border-green-100 
                                @elseif($apt->status === 'pending') bg-orange-50 text-orange-600 border-orange-100 
                                @elseif($apt->status === 'completed') bg-blue-50 text-blue-600 border-blue-100 
                                @else bg-slate-50 text-slate-400 border-slate-100 @endif">
                                {{ $apt->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.appointments.show', $apt) }}" class="w-8 h-8 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="Session Intelligence">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.appointments.edit', $apt) }}" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Modify Session">
                                    <i class="hgi-stroke hgi-pencil-edit-02 text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-20 text-center text-slate-400 text-xs italic">No appointments found in the schedule.</td></tr>
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
