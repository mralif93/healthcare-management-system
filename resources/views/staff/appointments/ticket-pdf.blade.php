<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Ticket — {{ $appointment->appointment_id }}</title>
    <style>
        @page { size: A5 portrait; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 148mm; background: #ffffff; color: #0f172a; font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }

        /* ── Page wrapper table (fills full A5 height) ── */
        .page { width: 148mm; border-collapse: collapse; }
        .page > tr > td { padding: 0; }

        /* ── Header ── */
        .header { background-color: #4f46e5; padding: 20px 24px; }
        .header table { width: 100%; border-collapse: collapse; }
        .header-left  { vertical-align: middle; }
        .header-right { vertical-align: middle; text-align: right; }
        .clinic-label  { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 3px; color: #a5b4fc; display: block; margin-bottom: 4px; }
        .ticket-title  { font-size: 16px; font-weight: bold; color: #fff; display: block; }
        .status-lbl    { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #a5b4fc; display: block; margin-bottom: 4px; }
        .badge { font-size: 8px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; padding: 3px 9px; border-radius: 5px; display: inline-block; }
        .badge-pending   { background-color: #fff3e0; color: #f97316; border: 1px solid #fed7aa; }
        .badge-confirmed { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-completed { background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-default   { background-color: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; }

        /* ── QR Section ── */
        .qr-section  { background-color: #f8fafc; padding: 24px; text-align: center; border-bottom: 1px dashed #cbd5e1; }
        .qr-wrapper  { display: inline-block; padding: 10px; background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; }
        .qr-wrapper img { display: block; }

        /* ── Scan Hint ── */
        .scan-hint { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 3px; color: #94a3b8; text-align: center; padding: 10px 24px 6px; }

        /* ── ID Box ── */
        .id-box { background-color: #eef2ff; border: 1px solid #e0e7ff; border-radius: 10px; padding: 10px 16px; text-align: center; margin: 10px 24px; }
        .id-box-label { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #818cf8; display: block; margin-bottom: 2px; }
        .id-box-value { font-size: 20px; font-weight: bold; color: #3730a3; letter-spacing: -0.5px; display: block; }

        /* ── Details ── */
        .details { padding: 8px 24px 56px; }
        .detail-row { margin-bottom: 14px; }
        .det-table  { width: 100%; border-collapse: collapse; }
        .icon-cell  { width: 30px; vertical-align: top; padding-top: 1px; }
        /* Icon badge — circle, icon centered via line-height trick */
        .icon-badge {
            width: 45px; height: 45px;
            border-radius: 10px;
            background-color: #eef2ff;
            text-align: center;
            line-height: 20px;
            display: block;
            border: 1px solid #e0e7ff;
        }
        .icon-badge img { vertical-align: middle; margin-right: 20px; margin-top: 10px; }
        .content-cell { vertical-align: top; padding-left: 8px; }
        .det-label  { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; display: block; margin-bottom: 2px; }
        .det-value  { font-size: 12px; font-weight: bold; color: #0f172a; line-height: 1.3; display: block; }
        .det-sub    { font-size: 8.5px; font-weight: bold; color: #94a3b8; text-transform: uppercase; display: block; margin-top: 1px; }
        .det-time   { font-size: 9px; font-weight: bold; color: #6366f1; text-transform: uppercase; letter-spacing: 1px; display: block; margin-top: 1px; }
        .det-reason { font-size: 10px; color: #475569; line-height: 1.4; display: block; margin-top: 1px; }

        /* ── Footer — pinned to bottom of A5 page ── */
        .footer { position: fixed; bottom: 0; left: 0; right: 0; background-color: #f8fafc; border-top: 1px dashed #cbd5e1; padding: 12px 24px; text-align: center; }
        .footer-text { font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 2.5px; color: #94a3b8; }
    </style>
</head>
<body>

{{-- Pre-encode SVG icons as base64 data URIs — the only reliable way to embed icons in DomPDF --}}
@php
    // Patient — person inside circle (account_circle style)
    $svgPerson   = 'data:image/svg+xml;base64,' . base64_encode('<svg width="5" height="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#6366f1" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 2 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>');
    // Doctor — medical cross in shield
    $svgDoctor   = 'data:image/svg+xml;base64,' . base64_encode('<svg width="5" height="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#6366f1" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm1 14h-2v-4H7v-2h4V5h2v4h4v2h-4v4z"/></svg>');
    // Date & Time — calendar with clock
    $svgCalendar = 'data:image/svg+xml;base64,' . base64_encode('<svg width="5" height="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#6366f1" d="M17 12h-4v4h4v-4zM16 1v2H8V1H6v2H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>');
    // Reason — clipboard with lines
    $svgFile     = 'data:image/svg+xml;base64,' . base64_encode('<svg width="5" height="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#6366f1" d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0a1 1 0 0 1 0 2 1 1 0 0 1 0-2zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>');
@endphp

{{-- Full-page wrapper table so footer sits at bottom --}}
<table class="page">
    <tr><td>
        {{-- Header --}}
        <div class="header">
            <table><tr>
                <td class="header-left">
                    <span class="clinic-label">Healthcare Management</span>
                    <span class="ticket-title">Appointment Ticket</span>
                </td>
                <td class="header-right">
                    <span class="status-lbl">Status</span>
                    <span class="badge badge-{{ in_array($appointment->status, ['pending','confirmed','completed']) ? $appointment->status : 'default' }}">
                        {{ $appointment->status }}
                    </span>
                </td>
            </tr></table>
        </div>

        {{-- QR Code --}}
        <div class="qr-section">
            <div class="qr-wrapper">
                <img src="{{ $qrDataUri }}" width="160" height="160" alt="QR Code">
            </div>
        </div>

        {{-- Scan hint --}}
        <div class="scan-hint">Scan this QR at reception</div>

        {{-- Appointment ID --}}
        <div class="id-box">
            <span class="id-box-label">Appointment ID</span>
            <span class="id-box-value">{{ $appointment->appointment_id }}</span>
        </div>

        {{-- Details --}}
        <div class="details">

            {{-- Patient --}}
            <div class="detail-row">
                <table class="det-table"><tr>
                    <td class="icon-cell">
                        <span class="icon-badge"><img src="{{ $svgPerson }}" width="5" height="5"></span>
                    </td>
                    <td class="content-cell">
                        <span class="det-label">Patient</span>
                        <span class="det-value">{{ $appointment->patient->name }}</span>
                        <span class="det-sub">{{ $appointment->patient->patient_id }}</span>
                    </td>
                </tr></table>
            </div>

            {{-- Doctor --}}
            <div class="detail-row">
                <table class="det-table"><tr>
                    <td class="icon-cell">
                        <span class="icon-badge"><img src="{{ $svgDoctor }}" width="5" height="5"></span>
                    </td>
                    <td class="content-cell">
                        <span class="det-label">Doctor</span>
                        <span class="det-value" style="font-style:italic;">{{ str_starts_with($appointment->doctor->name, 'Dr.') ? $appointment->doctor->name : 'Dr. ' . $appointment->doctor->name }}</span>
                    </td>
                </tr></table>
            </div>

            {{-- Date & Time --}}
            <div class="detail-row">
                <table class="det-table"><tr>
                    <td class="icon-cell">
                        <span class="icon-badge"><img src="{{ $svgCalendar }}" width="5" height="5"></span>
                    </td>
                    <td class="content-cell">
                        <span class="det-label">Date &amp; Time</span>
                        <span class="det-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</span>
                        <span class="det-time">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                    </td>
                </tr></table>
            </div>

            @if($appointment->reason)
            {{-- Reason --}}
            <div class="detail-row">
                <table class="det-table"><tr>
                    <td class="icon-cell">
                        <span class="icon-badge"><img src="{{ $svgFile }}" width="5" height="5"></span>
                    </td>
                    <td class="content-cell">
                        <span class="det-label">Reason</span>
                        <span class="det-reason">{{ $appointment->reason }}</span>
                    </td>
                </tr></table>
            </div>
            @endif

        </div>
    </td></tr>

</table>

{{-- Footer pinned to bottom of the A5 page --}}
<div class="footer">
    <span class="footer-text">Please arrive 15 minutes before your appointment time.</span>
</div>

</body>
</html>

