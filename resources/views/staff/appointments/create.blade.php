@extends('layouts.staff')

@section('title', 'Book Appointment')
@section('page_title', 'Appointment Intake')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Staff Operations</p>
                <h1 class="text-2xl font-black tracking-tight">Book Appointment</h1>
                <p class="text-sm text-white/70 mt-1">New clinical session reservation</p>
            </div>
            <a href="{{ route('staff.appointments.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shrink-0">
                Schedule
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-3">
            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="hgi-stroke hgi-calendar-add-01 text-indigo-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Reservation Details</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Fill in patient, doctor, date and time to book a session</p>
            </div>
        </div>

        <form action="{{ route('staff.appointments.store') }}" method="POST">
            @csrf

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Patient -->
                    <div class="space-y-1.5">
                        <label for="patient_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-user text-slate-400"></i> Patient <span class="text-red-400">*</span>
                        </label>
                        <select name="patient_id" id="patient_id" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm">
                            <option value="">-- Choose from Registry --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ (old('patient_id', request('patient_id')) == $patient->id) ? 'selected' : '' }}>{{ $patient->name }} ({{ $patient->patient_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor -->
                    <div class="space-y-1.5">
                        <label for="doctor_id" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-doctor-01 text-slate-400"></i> Specialist <span class="text-red-400">*</span>
                        </label>
                        <select name="doctor_id" id="doctor_id" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm">
                            <option value="">-- Select Available Doctor --</option>
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
                        <input type="date" name="appointment_date" id="appointment_date" value="{{ date('Y-m-d') }}" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Time -->
                    <div class="space-y-1.5">
                        <label for="appointment_time" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-clock-01 text-slate-400"></i> Slot Time <span class="text-red-400">*</span>
                        </label>
                        <input type="time" name="appointment_time" id="appointment_time" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <!-- Reason -->
                <div class="space-y-1.5">
                    <label for="reason" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <i class="hgi-stroke hgi-note-01 text-slate-400"></i> Complaint / Reason
                    </label>
                    <textarea name="reason" id="reason" rows="3" placeholder="Primary symptoms or purpose of visit..."
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm"></textarea>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('staff.appointments.index') }}" class="flex items-center space-x-2 px-5 py-2.5 border border-slate-200 text-slate-500 rounded-xl text-sm font-semibold hover:bg-white hover:border-slate-300 transition-all">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>Back to Schedule</span>
                </a>
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-100/50 hover:bg-indigo-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Confirm Booking</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
