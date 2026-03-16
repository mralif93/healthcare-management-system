@extends('layouts.staff')

@section('title', 'Check-in')
@section('page_title', 'Daily Patient Check-in')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-4 italic">Registry Verification</h3>
        <form action="{{ route('staff.checkin') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter Patient Name or ID for today's list..." class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
            </div>
            <button type="submit" class="bg-brand-600 text-white px-6 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brand-700 transition-all shadow-lg shadow-brand-100 active:scale-95">
                Verify
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($appointments as $apt)
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-brand-600 uppercase tracking-widest">{{ $apt->appointment_id }}</span>
                        <h4 class="text-sm font-black text-slate-900 leading-none group-hover:text-brand-600 transition-colors">{{ $apt->patient->name }}</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">ID: {{ $apt->patient->patient_id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-indigo-600">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</p>
                        <span class="text-[8px] font-black px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 border border-slate-200 uppercase mt-1 inline-block">{{ $apt->status }}</span>
                    </div>
                </div>
                
                <div class="py-3 border-t border-slate-50 space-y-2">
                    <div class="flex items-center space-x-2">
                        <i class="hgi-stroke hgi-doctor-01 text-[10px] text-slate-400"></i>
                        <span class="text-[10px] font-bold text-slate-600 italic">Dr. {{ $apt->doctor->name }}</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="hgi-stroke hgi-note-01 text-[10px] text-slate-400 mt-0.5"></i>
                        <span class="text-[10px] font-medium text-slate-500 line-clamp-1 leading-relaxed">{{ $apt->reason }}</span>
                    </div>
                </div>

                <button class="w-full mt-2 bg-indigo-50 text-indigo-600 py-2 rounded-lg text-[9px] font-black uppercase tracking-[0.2em] border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all active:scale-95 flex items-center justify-center space-x-2">
                    <i class="hgi-stroke hgi-qr-code-01"></i>
                    <span>Confirm Arrival</span>
                </button>
            </div>
        @empty
            <div class="col-span-full bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-16 text-center">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">No patient records matches the current search for today.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
