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

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm md:max-w-md overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">QR Check-in</p>
                        <h2 class="text-sm font-black text-white">Scan Patient QR Code</h2>
                    </div>
                    {{-- Larger tap target for tablets --}}
                    <button @click="closeScanner()" class="text-indigo-200 hover:text-white transition-colors p-2 -mr-1 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Camera reader — html5-qrcode mounts here. Taller on tablets. --}}
                    <div id="qr-reader" class="w-full rounded-xl overflow-hidden border border-slate-200 bg-slate-50 min-h-[240px] md:min-h-[340px]"></div>

                    {{-- Status / hint shown while camera loads --}}
                    <p id="qr-status" class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center hidden">
                        Waiting for camera…
                    </p>

                    {{-- Hidden form auto-submitted after a successful scan --}}
                    <form action="{{ route('staff.checkin.scan') }}" method="POST" id="scan-form">
                        @csrf
                        <input type="hidden" name="qr_token" id="qr-token-input">
                    </form>

                    <div class="border-t border-slate-100 pt-4 space-y-2">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            QR can't scan? Enter Appointment ID
                        </p>
                        <p class="text-[9px] text-slate-400 text-center">
                            Found on the patient's ticket, e.g. <span class="font-black text-indigo-500">APT-00004</span>
                        </p>
                        <form action="{{ route('staff.checkin.scan') }}" method="POST" class="flex gap-2 pt-1">
                            @csrf
                            <input type="text"
                                   name="appointment_id"
                                   placeholder="APT-00001"
                                   autocomplete="off"
                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs font-medium uppercase tracking-widest focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none transition-all">
                            <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all active:scale-95">
                                Verify
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- Hero Section --}}
    <div class="bg-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Staff Operations</p>
                <h1 class="text-2xl font-black tracking-tight">Patient Check-in</h1>
                <p class="text-sm text-white/70 mt-1">Daily arrival verification &amp; QR scan</p>
            </div>
            <button @click="openScanner()" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zM6 20h4"/></svg>
                Scan QR Code
            </button>
        </div>
    </div>

    {{-- Search & Scan controls --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="hgi-stroke hgi-search-01 text-indigo-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Patient Registry Search</h3>
            </div>
            <button @click="openScanner()"
                    class="shrink-0 flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all active:scale-95">
                <i class="hgi-stroke hgi-qr-code-01 text-xs"></i>
                <span>Scan QR Code</span>
            </button>
        </div>

        {{-- Search Body --}}
        <div class="p-5">
            <form action="{{ route('staff.checkin') }}" method="GET">
                <div class="flex items-center gap-3">
                    {{-- Input --}}
                    <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all">
                        <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by patient name or ID (e.g. PAT-001)…"
                               autocomplete="off"
                               spellcheck="false"
                               class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400 text-slate-900">
                    </div>
                    {{-- Verify Button --}}
                    <button type="submit"
                            class="shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all active:scale-95 flex items-center space-x-2">
                        <i class="hgi-stroke hgi-checkmark-circle-02 text-sm"></i>
                        <span>Verify</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('staff.checkin') }}"
                           class="shrink-0 text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors">× Clear</a>
                    @endif
                </div>

                {{-- Helper Row --}}
                <div class="flex items-center justify-between mt-3 px-1">
                    <p class="text-[9px] font-medium text-slate-400 flex items-center space-x-1">
                        <i class="hgi-stroke hgi-information-circle text-[10px]"></i>
                        <span>Search by full name, partial name, or patient ID</span>
                    </p>
                    @if(request('search'))
                        <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">
                            Results for "{{ request('search') }}"
                        </span>
                    @else
                        <span class="text-[9px] font-medium text-slate-400">Showing today's full schedule</span>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($appointments as $apt)
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group {{ $apt->status === 'confirmed' ? 'border-green-200' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">{{ $apt->appointment_id }}</span>
                        <h4 class="text-sm font-black text-slate-900 leading-none group-hover:text-indigo-600 transition-colors">{{ $apt->patient->name }}</h4>
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

/* ─── helpers ─────────────────────────────────────────────────── */
function showCameraError(el, msg) {
    msg = msg || 'Camera unavailable.<br>Use the manual field below.';
    if (!el) return;
    el.innerHTML =
        '<div class="flex flex-col items-center justify-center gap-3 py-10 text-slate-400">' +
        '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.82V15a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>' +
        '</svg>' +
        '<p class="text-[10px] font-bold uppercase tracking-widest text-center px-6 leading-relaxed">' + msg + '</p>' +
        '</div>';
}

function getScanBoxSize(el) {
    // Fill 80 % of the reader width, clamped between 200 px and 340 px
    const w = el ? el.offsetWidth : 280;
    return Math.min(Math.max(Math.round(w * 0.80), 200), 340);
}

function onQrSuccess(decodedText) {
    stopQrCamera();
    document.getElementById('qr-token-input').value = decodedText;
    document.getElementById('scan-form').submit();
}

/* ─── launch scanner with a given camera constraint / ID ───────── */
function launchWith(cameraIdOrConstraint, config) {
    const el = document.getElementById('qr-reader');
    el.innerHTML = '';                             // clear previous mount
    _qrInstance  = new Html5Qrcode('qr-reader');
    return _qrInstance.start(cameraIdOrConstraint, config, onQrSuccess, function() {});
}

/* ─── main entry point ─────────────────────────────────────────── */
function startQrCamera() {
    const el = document.getElementById('qr-reader');
    if (!el || _qrInstance) return;
    el.innerHTML = '';

    const size   = getScanBoxSize(el);
    const config = { fps: 15, qrbox: { width: size, height: size } };

    // Strategy:
    // 1. Try facingMode { ideal:'environment' }  → rear cam on tablet/phone, webcam on desktop
    // 2. If that fails, enumerate cameras and try each one
    // 3. Show a helpful error if nothing works

    launchWith({ facingMode: { ideal: 'environment' } }, config)
        .catch(function(err1) {
            // Permission denied — no point retrying
            if (/permission|denied/i.test(String(err1))) {
                _qrInstance = null;
                showCameraError(el, 'Camera permission denied.<br>Allow camera access in your browser settings.');
                return;
            }

            // facingMode failed — enumerate cameras as fallback
            _qrInstance = null;
            Html5Qrcode.getCameras()
                .then(function(cameras) {
                    if (!cameras || cameras.length === 0) {
                        showCameraError(el, 'No camera detected.<br>Use the manual field below.');
                        return;
                    }

                    // Prefer a labelled rear/back camera, else last camera (rear on most tablets),
                    // else first camera (front / webcam on desktops)
                    const rear = cameras.find(function(c) {
                        return /back|rear|environment/i.test(c.label);
                    });
                    const chosen = rear || cameras[cameras.length - 1];

                    return launchWith(chosen.id, config);
                })
                .catch(function(err2) {
                    _qrInstance = null;
                    const msg = /permission|denied/i.test(String(err2))
                        ? 'Camera permission denied.<br>Allow camera access in your browser settings.'
                        : 'Camera unavailable.<br>Use the manual field below.';
                    showCameraError(el, msg);
                });
        });
}

/* ─── stop & clean up ──────────────────────────────────────────── */
function stopQrCamera() {
    if (_qrInstance) {
        _qrInstance.stop().catch(function() {});
        _qrInstance = null;
    }
    const el = document.getElementById('qr-reader');
    if (el) el.innerHTML = '';
}
</script>
@endpush
