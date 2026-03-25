<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Ticket — {{ $appointment->appointment_id }}</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- HugeIcons -->
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-slate-900">

    {{-- Header --}}
    <div class="bg-indigo-600 px-6 py-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-[0.3em] mb-1">Healthcare Management</p>
                <h1 class="text-lg font-black text-white leading-none">Appointment Ticket</h1>
            </div>
            <div class="text-right">
                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest mb-1">Status</p>
                <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg inline-block
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
    <div class="bg-slate-50 py-6 flex justify-center border-b border-dashed border-slate-200">
        <div class="p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
            {!! $qrSvg !!}
        </div>
    </div>

    {{-- Scan hint --}}
    <div class="pt-3 pb-1 text-center">
        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em]">Scan this QR at reception</p>
    </div>

    {{-- Appointment ID --}}
    <div class="mx-6 mt-3 mb-2 bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 text-center">
        <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-0.5">Appointment ID</p>
        <p class="text-xl font-black text-indigo-700 tracking-tighter">{{ $appointment->appointment_id }}</p>
    </div>

    {{-- Details --}}
    <div class="px-6 pt-3 pb-20 space-y-4">

        {{-- Patient --}}
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0 mt-0.5">
                <i class="hgi-stroke hgi-user text-sm text-indigo-500"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Patient</p>
                <p class="text-sm font-black text-slate-900 leading-tight">{{ $appointment->patient->name }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $appointment->patient->patient_id }}</p>
            </div>
        </div>

        {{-- Doctor --}}
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0 mt-0.5">
                <i class="hgi-stroke hgi-stethoscope text-sm text-indigo-500"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Doctor</p>
                <p class="text-sm font-bold text-slate-900 italic leading-tight">
                    {{ str_starts_with($appointment->doctor->name, 'Dr.') ? $appointment->doctor->name : 'Dr. ' . $appointment->doctor->name }}
                </p>
            </div>
        </div>

        {{-- Date & Time --}}
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0 mt-0.5">
                <i class="hgi-stroke hgi-calendar-01 text-sm text-indigo-500"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Date &amp; Time</p>
                <p class="text-sm font-black text-slate-900 leading-tight">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                </p>
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                </p>
            </div>
        </div>

        @if($appointment->reason)
        {{-- Reason --}}
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0 mt-0.5">
                <i class="hgi-stroke hgi-file-02 text-sm text-indigo-500"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Reason</p>
                <p class="text-[10px] font-medium text-slate-600 leading-relaxed">{{ $appointment->reason }}</p>
            </div>
        </div>
        @endif

    </div>

    {{-- Footer — fixed to bottom of the viewport --}}
    <div class="fixed bottom-0 left-0 right-0 bg-slate-50 border-t border-dashed border-slate-200 px-6 py-3 text-center">
        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em]">Please arrive 15 minutes before your appointment time.</p>
    </div>

</body>
</html>

