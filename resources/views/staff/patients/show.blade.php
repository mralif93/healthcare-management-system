@extends('layouts.staff')

@section('title', 'Patient Details')
@section('page_title', 'Clinical Record')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-20">
    <!-- Header Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <i class="hgi-stroke hgi-user text-3xl font-black"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $patient->name }}</h2>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ $patient->patient_id }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ ucfirst($patient->gender) }} • {{ $patient->age }} Years</span>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('staff.appointments.create', ['patient_id' => $patient->id]) }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
                <i class="hgi-stroke hgi-calendar-add-01"></i>
                <span>Book Appointment</span>
            </a>
            <a href="{{ route('staff.patients.index') }}" class="bg-slate-100 text-slate-500 px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Return to Registry
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Patient Contact</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Phone</p>
                        <p class="text-xs font-bold text-slate-700">{{ $patient->phone }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $patient->email ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Address</p>
                        <p class="text-xs font-bold text-slate-700 leading-relaxed">{{ $patient->address ?: 'No registered address.' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Metadata</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-[9px] font-black text-slate-400 uppercase">Blood Group</span>
                        <span class="text-[9px] font-black text-red-600 bg-red-50 px-2 rounded">{{ $patient->blood_group ?: '??' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[9px] font-black text-slate-400 uppercase">Registration</span>
                        <span class="text-[9px] font-bold text-slate-600">{{ $patient->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Medical Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden border-l-4 border-l-orange-500">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2 text-orange-600">
                    <i class="hgi-stroke hgi-alert-circle text-sm"></i>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em]">Allergy Alert</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium text-slate-600 leading-relaxed bg-orange-50/30 p-4 rounded-lg italic">
                        {{ $patient->allergies ?: 'No known clinical allergies reported.' }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2 text-indigo-600">
                    <i class="hgi-stroke hgi-file-attachment-01 text-sm"></i>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em]">Clinical History Summary</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg">
                        {{ $patient->medical_history ?: 'No medical history recorded in the operational vault.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
