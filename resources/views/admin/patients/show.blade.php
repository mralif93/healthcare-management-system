@extends('layouts.admin')

@section('title', 'Patient Details')
@section('page_title', 'Patient Profile')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 shrink-0">
                    <i class="hgi-stroke hgi-user text-3xl text-white"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Patient Profile</p>
                    <h1 class="text-2xl font-black tracking-tight">{{ $patient->name }}</h1>
                    <p class="text-sm text-white/70 mt-1">
                        {{ $patient->patient_id }} &bull; <span class="capitalize">{{ $patient->gender }}</span> &bull; {{ $patient->age }} Yrs
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('admin.patients.edit', $patient) }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-pencil-edit-02"></i>
                    <span>Edit Profile</span>
                </a>
                <a href="{{ route('admin.patients.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Registry
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Patient ID</p>
            <p class="text-sm font-black text-brand-600 uppercase">{{ $patient->patient_id }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Gender / Age</p>
            <p class="text-sm font-black text-slate-900 capitalize">{{ $patient->gender }}, {{ $patient->age }} yrs</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Blood Group</p>
            <p class="text-sm font-black text-red-600">{{ $patient->blood_group ?: 'Unknown' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</p>
            <span class="inline-flex px-2 py-0.5 {{ $patient->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} border rounded text-[10px] font-black uppercase">{{ $patient->status }}</span>
        </div>
    </div>

    <!-- 3-Column Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-contact text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Contact Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-mail-01 text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Email Address</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $patient->email ?: 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-call text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Phone Number</p>
                        <p class="text-xs font-bold text-slate-700">{{ $patient->phone }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-location-01 text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Address</p>
                        <p class="text-xs font-bold text-slate-700 leading-relaxed">{{ $patient->address ?: 'No address on file.' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-calendar-03 text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Registered</p>
                        <p class="text-xs font-bold text-slate-700">{{ $patient->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Allergies -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-alert-circle text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Allergies & Contraindications</h3>
            </div>
            <div class="p-6">
                <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100 min-h-[120px]">
                    {{ $patient->allergies ?: 'No known allergies reported for this patient.' }}
                </p>
            </div>
        </div>

        <!-- Medical History -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-file-attachment text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Medical History</h3>
            </div>
            <div class="p-6">
                <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100 min-h-[120px]">
                    {{ $patient->medical_history ?: 'No past medical history recorded.' }}
                </p>
            </div>
        </div>
    </div>
    <!-- Danger Zone -->
    <div class="bg-white rounded-xl border border-red-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 bg-red-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-delete-02 text-red-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">Danger Zone</h3>
        </div>
        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">Delete this patient record</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">This action is permanent and cannot be undone.</p>
            </div>
            <form id="del-patient-{{ $patient->id }}" action="{{ route('admin.patients.destroy', $patient) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="openConfirmModal('delete', 'Delete Patient', 'Are you sure you want to permanently delete this patient record? This cannot be undone.', 'del-patient-{{ $patient->id }}')"
                    class="shrink-0 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
                Delete Record
            </button>
        </div>
    </div>
</div>
@endsection
