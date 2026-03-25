@extends('layouts.admin')

@section('title', 'Appointment Management')
@section('page_title', 'Appointment Schedule')

@section('content')
<div class="space-y-6 animate__animated animate__fadeInUp animate__faster">

    {{-- Gradient Hero Bar --}}
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-1">Administration Module</p>
                <h2 class="text-2xl font-bold tracking-tight">Appointments Management</h2>
                <p class="text-xs opacity-70 mt-1">Manage all clinical booking sessions across every doctor.</p>
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="shrink-0 bg-white/20 hover:bg-white/30 border border-white/30 text-white px-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all active:scale-95 flex items-center space-x-2 backdrop-blur-sm">
                <i class="hgi-stroke hgi-calendar-add-01 text-sm"></i>
                <span>Create New Appointment</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('admin.appointments.index') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, patient, or doctor..."
                           class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400">
                </div>
                <select name="status" class="bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-600 outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all flex items-center space-x-2 active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-search-01 text-sm"></i>
                    <span>Search</span>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">× Clear</a>
                @endif
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
