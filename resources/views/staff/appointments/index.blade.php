@extends('layouts.staff')

@section('title', 'Appointments')
@section('page_title', 'Operational Schedule')

@section('content')
<div class="space-y-6"
     x-data="{
         ticketOpen: false,
         ticketUrl: '',
         ticketPdfUrl: '',
         ticketWaUrl: '',
         ticketId: '',
         openTicket(htmlUrl, pdfUrl, waUrl, id) {
             this.ticketUrl    = htmlUrl;
             this.ticketPdfUrl = pdfUrl;
             this.ticketWaUrl  = waUrl;
             this.ticketId     = id;
             this.ticketOpen   = true;
         },
         closeTicket() {
             this.ticketOpen   = false;
             this.ticketUrl    = '';
             this.ticketPdfUrl = '';
             this.ticketWaUrl  = '';
         }
     }">

    {{-- Appointment Ticket Modal --}}
    <template x-teleport="body">
        <div x-show="ticketOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] flex items-center justify-center backdrop-blur-sm bg-slate-900/60 p-4"
             @click.self="closeTicket()">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col"
                 style="height: 92vh;">

                {{-- Modal Header --}}
                <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between shrink-0 border-b border-indigo-400/50">
                    <div>
                        <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">Appointment Ticket</p>
                        <h2 class="text-sm font-black text-white" x-text="ticketId"></h2>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- WhatsApp share (only shown when patient has a phone number) --}}
                        <a :href="ticketWaUrl" target="_blank" x-show="ticketWaUrl"
                           class="text-[#25D366] hover:text-white transition-colors text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5"
                           title="Send via WhatsApp">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                        <a :href="ticketPdfUrl" target="_blank"
                           class="text-indigo-200 hover:text-white transition-colors text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5">
                            <i class="hgi-stroke hgi-download-04 text-xs"></i>
                            <span>Download</span>
                        </a>
                        <button @click="closeTicket()" class="text-indigo-200 hover:text-white transition-colors ml-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Ticket iframe (HTML view — Tailwind + HugeIcons rendered by browser) --}}
                <div class="flex-1 overflow-hidden bg-white">
                    <iframe :src="ticketUrl"
                            class="w-full h-full border-0"
                            title="Appointment Ticket">
                    </iframe>
                </div>
            </div>
        </div>
    </template>

    <!-- Hero Section -->
    <div class="bg-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Staff Operations</p>
                <h1 class="text-2xl font-black tracking-tight">Appointments Management</h1>
                <p class="text-sm text-white/70 mt-1">Clinical bookings &amp; patient sessions</p>
            </div>
            <a href="{{ route('staff.appointments.create') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2 shrink-0">
                <i class="hgi-stroke hgi-calendar-add-01"></i>
                <span>Create New Appointment</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('staff.appointments.index') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID or patient name..."
                           class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400">
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all flex items-center space-x-2 active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-search-01 text-sm"></i>
                    <span>Search</span>
                </button>
                @if(request('search'))
                    <a href="{{ route('staff.appointments.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">× Clear</a>
                @endif
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
                        <td class="px-6 py-4 font-black text-indigo-600 uppercase tracking-tighter">{{ $apt->appointment_id }}</td>
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
                            @php
                                // WhatsApp URL is built server-side by the controller — just pass the route
                                $waUrl = $apt->patient->phone
                                    ? route('staff.appointments.whatsapp', $apt)
                                    : '';
                            @endphp
                            <button @click="openTicket('{{ route('staff.appointments.ticket', $apt) }}', '{{ route('staff.appointments.ticket.pdf', $apt) }}', '{{ $waUrl }}', '{{ $apt->appointment_id }}')"
                                    title="View Ticket"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-500 border border-indigo-100 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all">
                                <i class="hgi-stroke hgi-qr-code-01 text-xs"></i>
                            </button>
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
