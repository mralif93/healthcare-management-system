@extends('layouts.doctor')

@section('title', 'Consultations')
@section('page_title', 'Clinical Records')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Clinical Archive</h3>
        <a href="{{ route('doctor.consultations.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
            <i class="hgi-stroke hgi-plus-sign font-black"></i>
            <span>Manual Entry</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap gap-4 items-center">
            <form action="{{ route('doctor.consultations.index') }}" method="GET" class="flex-1 min-w-[300px] flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or ID..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 transition-all outline-none">
                </div>
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Search Records</button>
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
