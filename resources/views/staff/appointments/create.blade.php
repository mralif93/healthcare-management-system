@extends('layouts.staff')

@section('title', 'Book Appointment')
@section('page_title', 'Appointment Intake')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Reservation Details</h3>
        </div>

        <form action="{{ route('staff.appointments.store') }}" method="POST" class="p-8 space-y-6 text-xs">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient -->
                <div class="space-y-1.5">
                    <label for="patient_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Patient</label>
                    <select name="patient_id" id="patient_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="">-- Choose from Registry --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->patient_id }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor -->
                <div class="space-y-1.5">
                    <label for="doctor_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Assign Specialist</label>
                    <select name="doctor_id" id="doctor_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="">-- Select Available Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div class="space-y-1.5">
                    <label for="appointment_date" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" value="{{ date('Y-m-d') }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Time -->
                <div class="space-y-1.5">
                    <label for="appointment_time" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Slot Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="reason" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Complaint / Reason</label>
                <textarea name="reason" id="reason" rows="3" placeholder="Primary symptoms or purpose of visit..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all"></textarea>
            </div>

            <div class="pt-6 flex justify-end space-x-3">
                <a href="{{ route('staff.appointments.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="px-10 py-2.5 bg-brand-600 text-white rounded-lg font-bold uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Initialize Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
