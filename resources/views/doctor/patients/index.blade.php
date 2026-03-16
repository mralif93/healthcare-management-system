@extends('layouts.doctor')

@section('title', 'My Patients')
@section('page_title', 'Clinical Directory')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Assigned Patients</h3>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('doctor.patients.index') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patients by name or ID..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all">
                </div>
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Search</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Identity</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Gender / Age</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Medical File</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4 font-black text-brand-600 uppercase tracking-tighter">{{ $patient->patient_id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-[10px]">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-900">{{ $patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-slate-600 uppercase text-[10px] tracking-widest">{{ $patient->gender }}</span>
                            <span class="text-slate-300 mx-1">/</span>
                            <span class="font-bold text-slate-900">{{ $patient->age }}Y</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('doctor.patients.show', $patient) }}" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="View History">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-20 text-center text-slate-400 text-xs italic">No patients found in your clinical directory.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
