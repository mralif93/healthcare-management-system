<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Ticket — {{ $appointment->appointment_id }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-100 min-h-screen flex items-center justify-center p-8 print:bg-white print:p-0 print:block">

    {{-- Screen-only controls --}}
    <div class="print:hidden fixed top-4 right-4 flex gap-3 z-50">
        <button onclick="window.print()" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg hover:bg-indigo-700 transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Ticket
        </button>
        <a href="{{ route('staff.appointments.index') }}" class="bg-white text-slate-600 border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
            ← Back
        </a>
    </div>

    {{-- Ticket Card --}}
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden print:shadow-none print:rounded-none print:max-w-full">

        {{-- Header stripe --}}
        <div class="bg-indigo-600 px-6 py-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-indigo-200 mb-1">Healthcare Management</p>
                    <h1 class="text-lg font-black leading-none">Appointment Ticket</h1>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-indigo-200">Status</p>
                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg mt-1 inline-block
                        @if($appointment->status === 'confirmed') bg-green-400/20 text-green-200 border border-green-300/30
                        @elseif($appointment->status === 'pending') bg-orange-400/20 text-orange-200 border border-orange-300/30
                        @elseif($appointment->status === 'completed') bg-blue-400/20 text-blue-200 border border-blue-300/30
                        @else bg-white/10 text-white/70 border border-white/20 @endif">
                        {{ $appointment->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- QR Code --}}
        <div class="flex justify-center py-6 bg-slate-50 border-b border-dashed border-slate-200">
            <div class="p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
                {!! $qrSvg !!}
            </div>
        </div>

        {{-- Token hint --}}
        <div class="px-6 pt-3 pb-1 text-center">
            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em]">Scan this QR at reception</p>
        </div>

        {{-- Details --}}
        <div class="px-6 pb-6 space-y-4 mt-3">

            <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 text-center">
                <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-0.5">Appointment ID</p>
                <p class="text-xl font-black text-indigo-700 tracking-tighter">{{ $appointment->appointment_id }}</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Patient</p>
                        <p class="text-sm font-black text-slate-900 leading-tight">{{ $appointment->patient->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $appointment->patient->patient_id }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Doctor</p>
                        <p class="text-sm font-bold text-slate-900 italic leading-tight">Dr. {{ $appointment->doctor->name }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Date & Time</p>
                        <p class="text-sm font-black text-slate-900 leading-tight">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        </p>
                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        </p>
                    </div>
                </div>

                @if($appointment->reason)
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Reason</p>
                        <p class="text-[10px] font-medium text-slate-600 leading-relaxed">{{ $appointment->reason }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-slate-50 border-t border-dashed border-slate-200 px-6 py-3 text-center">
            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em]">Please arrive 15 minutes before your appointment time.</p>
        </div>
    </div>

    <style>
        @media print {
            body { margin: 0; }
            .print\:hidden { display: none !important; }
        }
    </style>
</body>
</html>

