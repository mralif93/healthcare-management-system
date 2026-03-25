@extends('layouts.admin')

@section('title', 'Schedule Appointment')
@section('page_title', 'New Booking')

@section('content')
<div class="space-y-6 animate__animated animate__fadeInUp animate__faster">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Create New Appointment</h1>
                <p class="text-sm text-white/70 mt-1">Assign patient to a doctor &amp; book a clinical slot</p>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2 shrink-0">
                <i class="hgi-stroke hgi-arrow-left-01"></i><span>All Appointments</span>
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-xl shadow-lg flex items-start space-x-3 animate__animated animate__fadeInDown animate__faster">
        <i class="hgi-stroke hgi-alert-circle text-lg shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $error)<li class="text-[10px] font-black uppercase tracking-widest">{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-3">
            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-calendar-add-01 text-brand-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Reservation Details</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Assign a patient to a doctor and set the appointment slot</p>
            </div>
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Patient -->
                    <div class="space-y-1.5">
                        <label for="patient_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Patient <span class="text-red-400">*</span>
                        </label>
                        <select name="patient_id" id="patient_id" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->patient_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor -->
                    <div class="space-y-1.5">
                        <label for="doctor_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-doctor-01 text-slate-400"></i> Doctor <span class="text-red-400">*</span>
                        </label>
                        <select name="doctor_id" id="doctor_id" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="space-y-1.5">
                        <label for="appointment_date" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-calendar-03 text-slate-400"></i> Appointment Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="appointment_date" id="appointment_date" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Time -->
                    <div class="space-y-1.5">
                        <label for="appointment_time" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-clock-01 text-slate-400"></i> Slot Time <span class="text-red-400">*</span>
                        </label>
                        <input type="time" name="appointment_time" id="appointment_time" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-toggle-on text-slate-400"></i> Initial Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                </div>

                <!-- Reason -->
                <div class="space-y-1.5">
                    <label for="reason" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <i class="hgi-stroke hgi-note-01 text-slate-400"></i> Clinical Reason
                    </label>
                    <textarea name="reason" id="reason" rows="3" placeholder="Brief reason for the visit..."
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm"></textarea>
                </div>

                <!-- Notes -->
                <div class="space-y-1.5">
                    <label for="notes" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <i class="hgi-stroke hgi-bubble-chat-edit text-slate-400"></i> Internal Notes <span class="text-[10px] text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="2"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm"></textarea>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.appointments.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-white hover:border-slate-300 transition-all">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>Back to Schedule</span>
                </a>
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-100/50 hover:bg-brand-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Confirm Booking</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
