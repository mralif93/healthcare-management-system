@extends('layouts.admin')

@section('title', 'Patient Details')
@section('page_title', 'Patient Profile')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-20">
    <!-- Header Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600 shadow-inner">
                <i class="hgi-stroke hgi-user text-3xl font-black"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $patient->name }}</h2>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="text-[10px] font-black text-brand-600 uppercase tracking-widest">{{ $patient->patient_id }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><span class="capitalize">{{ $patient->gender }}</span> • {{ $patient->age }} Years Old</span>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.patients.edit', $patient) }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
                <i class="hgi-stroke hgi-pencil-edit-02"></i>
                <span>Edit Profile</span>
            </a>
            <a href="{{ route('admin.patients.index') }}" class="bg-slate-100 text-slate-500 px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Registry
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact & Basic Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Contact Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="hgi-stroke hgi-mail-01 text-brand-500 mt-0.5"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase">Email Address</p>
                            <p class="text-xs font-bold text-slate-700 truncate">{{ $patient->email ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="hgi-stroke hgi-phone text-brand-500 mt-0.5"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase">Phone Number</p>
                            <p class="text-xs font-bold text-slate-700">{{ $patient->phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="hgi-stroke hgi-location-01 text-brand-500 mt-0.5"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase">Address</p>
                            <p class="text-xs font-bold text-slate-700 leading-relaxed">{{ $patient->address ?: 'No address on file.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Medical Summary</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Blood Group</span>
                        <span class="px-2 py-0.5 bg-red-50 text-red-600 rounded text-[10px] font-black border border-red-100 uppercase">{{ $patient->blood_group ?: 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Status</span>
                        <span class="px-2 py-0.5 {{ $patient->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} rounded text-[10px] font-black uppercase tracking-widest">{{ $patient->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical History & Background -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2 text-orange-600">
                    <i class="hgi-stroke hgi-alert-circle text-sm font-black"></i>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em]">Allergies & Contraindications</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                        {{ $patient->allergies ?: 'No known allergies reported for this patient.' }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2 text-blue-600">
                    <i class="hgi-stroke hgi-file-attachment-01 text-sm font-black"></i>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em]">Medical History</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                        {{ $patient->medical_history ?: 'No past medical history recorded.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
