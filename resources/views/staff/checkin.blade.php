@extends('layouts.staff')

@section('title', 'Check-in')
@section('page_title', 'Daily Patient Check-in')

@section('content')
<div class="space-y-6"
     x-data="{
        scanOpen: false,
        openScanner() {
            this.scanOpen = true;
            this.$nextTick(() => startQrCamera());
        },
        closeScanner() {
            stopQrCamera();
            this.scanOpen = false;
        }
     }">

    {{-- QR Scanner Modal — teleported to <body> so fixed inset-0 always covers the full viewport --}}
    <template x-teleport="body">
        <div x-show="scanOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] flex items-center justify-center backdrop-blur-sm bg-slate-900/60 p-4"
             @click.self="closeScanner()">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">QR Check-in</p>
                        <h2 class="text-sm font-black text-white">Scan Patient QR Code</h2>
                    </div>
                    <button @click="closeScanner()" class="text-indigo-200 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Camera reader — html5-qrcode mounts here --}}
                    <div id="qr-reader" class="w-full rounded-xl overflow-hidden border border-slate-200 bg-slate-50 min-h-[220px]"></div>

                    {{-- Hidden form auto-submitted after a successful scan --}}
                    <form action="{{ route('staff.checkin.scan') }}" method="POST" id="scan-form">
                        @csrf
                        <input type="hidden" name="qr_token" id="qr-token-input">
                    </form>

                    <div class="border-t border-slate-100 pt-4">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center mb-3">Or enter token manually</p>
                        <form action="{{ route('staff.checkin.scan') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="qr_token" placeholder="Paste QR token..." class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none transition-all">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- Search & Scan controls --}}
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] italic">Registry Verification</h3>
            <button @click="openScanner()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all active:scale-95 flex items-center gap-2 shadow-md shadow-indigo-100">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zM6 20h4"/></svg>
                Scan QR Code
            </button>
        </div>

        <form action="{{ route('staff.checkin') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by patient name or ID..." autocomplete="off" spellcheck="false" class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
            </div>
            <button type="submit" class="bg-brand-600 text-white px-6 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brand-700 transition-all shadow-lg shadow-brand-100 active:scale-95">
                Verify
            </button>
        </form>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3 animate__animated animate__fadeIn">
        <i class="hgi-stroke hgi-checkmark-circle-02 text-lg shrink-0"></i>
        <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-red-600 flex items-center space-x-3 animate__animated animate__fadeIn">
        <i class="hgi-stroke hgi-alert-circle text-lg shrink-0"></i>
        <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($appointments as $apt)
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group {{ $apt->status === 'confirmed' ? 'border-green-200' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-brand-600 uppercase tracking-widest">{{ $apt->appointment_id }}</span>
                        <h4 class="text-sm font-black text-slate-900 leading-none group-hover:text-brand-600 transition-colors">{{ $apt->patient->name }}</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">ID: {{ $apt->patient->patient_id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-indigo-600">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</p>
                        <span class="text-[8px] font-black px-1.5 py-0.5 rounded mt-1 inline-block uppercase
                            @if($apt->status === 'confirmed') bg-green-50 text-green-600 border border-green-100
                            @else bg-orange-50 text-orange-600 border border-orange-100 @endif">
                            {{ $apt->status }}
                        </span>
                    </div>
                </div>

                <div class="py-3 border-t border-slate-50 space-y-2">
                    <div class="flex items-center space-x-2">
                        <i class="hgi-stroke hgi-doctor-01 text-[10px] text-slate-400"></i>
                        <span class="text-[10px] font-bold text-slate-600 italic">Dr. {{ $apt->doctor->name }}</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="hgi-stroke hgi-note-01 text-[10px] text-slate-400 mt-0.5"></i>
                        <span class="text-[10px] font-medium text-slate-500 line-clamp-1 leading-relaxed">{{ $apt->reason ?: 'No reason specified.' }}</span>
                    </div>
                </div>

                @if($apt->status === 'confirmed')
                    <div class="w-full mt-2 bg-green-50 text-green-600 py-2 rounded-lg text-[9px] font-black uppercase tracking-[0.2em] border border-green-100 flex items-center justify-center space-x-2">
                        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                        <span>Arrived — Checked In</span>
                    </div>
                @else
                    <form action="{{ route('staff.appointments.confirm', $apt) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-50 text-indigo-600 py-2 rounded-lg text-[9px] font-black uppercase tracking-[0.2em] border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all active:scale-95 flex items-center justify-center space-x-2">
                            <i class="hgi-stroke hgi-qr-code-01"></i>
                            <span>Confirm Arrival</span>
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="col-span-full bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-16 text-center">
                <i class="hgi-stroke hgi-calendar-02 text-4xl text-slate-200 mb-4 block"></i>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">No appointments scheduled for today match your search.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let _qrInstance = null;

/**
 * Called by Alpine's openScanner() via $nextTick — the #qr-reader div
 * is already visible in the DOM at this point, so html5-qrcode can mount.
 */
function startQrCamera() {
    const el = document.getElementById('qr-reader');
    if (!el || _qrInstance) return;

    // Clear any leftover html from a previous session
    el.innerHTML = '';

    _qrInstance = new Html5Qrcode('qr-reader');

    _qrInstance.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: { width: 220, height: 220 } },
        (decodedText) => {
            // QR decoded — stop camera and submit
            stopQrCamera();
            document.getElementById('qr-token-input').value = decodedText;
            document.getElementById('scan-form').submit();
        },
        () => { /* ignore per-frame errors */ }
    ).catch((err) => {
        // Show a friendly error inside the reader box
        if (el) {
            el.innerHTML =
                '<div class="flex flex-col items-center justify-center gap-2 py-8 text-slate-400">' +
                '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.82V15a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>' +
                '<p class="text-[10px] font-bold uppercase tracking-widest text-center px-4">Camera unavailable.<br>Use the manual field below.</p>' +
                '</div>';
        }
        _qrInstance = null;
    });
}

/**
 * Called by Alpine's closeScanner() before hiding the modal.
 */
function stopQrCamera() {
    if (_qrInstance) {
        _qrInstance.stop().catch(() => {});
        _qrInstance = null;
    }
    const el = document.getElementById('qr-reader');
    if (el) el.innerHTML = '';
}
</script>
@endpush
