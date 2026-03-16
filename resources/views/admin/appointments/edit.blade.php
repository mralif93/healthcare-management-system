@extends('layouts.admin')

@section('title', 'Edit Appointment')
@section('page_title', 'Modify Booking')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Update Session: {{ $appointment->appointment_id }}</h3>
            <span class="px-2 py-1 bg-brand-50 text-brand-600 rounded text-[10px] font-black uppercase tracking-widest">{{ $appointment->status }}</span>
        </div>

        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient -->
                <div class="space-y-1.5">
                    <label for="patient_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Patient</label>
                    <select name="patient_id" id="patient_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor -->
                <div class="space-y-1.5">
                    <label for="doctor_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Doctor</label>
                    <select name="doctor_id" id="doctor_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div class="space-y-1.5">
                    <label for="appointment_date" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Clinical Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" value="{{ $appointment->appointment_date }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Time -->
                <div class="space-y-1.5">
                    <label for="appointment_time" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Slot Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label for="status" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Management Status</label>
                    <select name="status" id="status" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="reason" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Clinical Reason</label>
                <textarea name="reason" id="reason" rows="3"
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ $appointment->reason }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label for="notes" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Internal Notes</label>
                <textarea name="notes" id="notes" rows="2"
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ $appointment->notes }}</textarea>
            </div>

            <div class="pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.appointments.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="px-8 py-2.5 bg-brand-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Synchronize Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
