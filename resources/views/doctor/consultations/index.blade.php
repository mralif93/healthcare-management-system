@extends('layouts.doctor')

@section('title', 'Consultations')
@section('page_title', 'Clinical Records')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white shadow-xl shadow-emerald-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Clinical Module</p>
                <h1 class="text-2xl font-black tracking-tight">Consultation Archive</h1>
                <p class="text-sm text-white/70 mt-1">Clinical records &amp; session history</p>
            </div>
            <a href="{{ route('doctor.consultations.create') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2 shrink-0">
                <i class="hgi-stroke hgi-plus-sign"></i>
                <span>Manual Entry</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('doctor.consultations.index') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-emerald-500/20 focus-within:border-emerald-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by patient name or ID..."
                           class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400">
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all flex items-center space-x-2 active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-search-01 text-sm"></i>
                    <span>Search</span>
                </button>
                @if(request('search'))
                    <a href="{{ route('doctor.consultations.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">× Clear</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Consult Date</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Details</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Diagnosis / Impression</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Records</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($consultations as $cons)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4 font-black text-slate-900 uppercase">
                            {{ \Carbon\Carbon::parse($cons->consultation_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3 text-xs">
                                <div class="w-8 h-8 rounded bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold uppercase">
                                    {{ substr($cons->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-none">{{ $cons->patient->name }}</p>
                                    <p class="text-[9px] font-black text-slate-400 uppercase mt-1">{{ $cons->patient->patient_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">
                            {{ Str::limit($cons->diagnosis, 60) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('doctor.consultations.show', $cons) }}" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="View Full Report">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-20 text-center text-slate-400 text-xs italic">No past clinical sessions recorded in the vault.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultations->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $consultations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
