@extends('layouts.staff')

@section('title', 'Patient Records')
@section('page_title', 'Patient Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Operational Directory</h3>
        <a href="{{ route('staff.patients.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
            <i class="hgi-stroke hgi-user-add-01"></i>
            <span>Register New Patient</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3">
        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
        <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('staff.patients.index') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, or phone..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all">
                </div>
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Search Registry</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Full Name</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Gender/Age</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact Number</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Operation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4 font-black text-brand-600 uppercase tracking-tighter">{{ $patient->patient_id }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $patient->name }}</td>
                        <td class="px-6 py-4 font-medium text-slate-600"><span class="capitalize">{{ $patient->gender }}</span>, {{ $patient->age }} yrs</td>
                        <td class="px-6 py-4 font-bold text-slate-500">{{ $patient->phone }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('staff.patients.show', $patient) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Open Medical File">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-20 text-center text-slate-400 text-xs italic">The patient directory is currently empty.</td></tr>
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
