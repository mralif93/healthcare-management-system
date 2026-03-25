@extends('layouts.admin')

@section('title', 'Doctor Details')
@section('page_title', 'Doctor Profile')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 shrink-0">
                    <i class="hgi-stroke hgi-stethoscope text-3xl text-white"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Doctor Profile</p>
                    <h1 class="text-2xl font-black tracking-tight">{{ $doctor->name }}</h1>
                    <p class="text-sm text-white/70 mt-1">
                        {{ $doctor->staff_id }} &bull; {{ $doctor->specialization ?: 'General Practice' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-pencil-edit-02"></i>
                    <span>Edit Profile</span>
                </a>
                <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Registry
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Staff ID</p>
            <p class="text-sm font-black text-brand-600 uppercase">{{ $doctor->staff_id }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Specialization</p>
            <p class="text-sm font-black text-slate-900">{{ $doctor->specialization ?: '—' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Total Consultations</p>
            <p class="text-sm font-black text-emerald-600">{{ $doctor->doctorConsultations->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</p>
            <span class="inline-flex px-2 py-0.5 {{ $doctor->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} border rounded text-[10px] font-black uppercase">{{ $doctor->status }}</span>
        </div>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $doctor->email }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-call text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Phone Number</p>
                        <p class="text-xs font-bold text-slate-700">{{ $doctor->phone ?: 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-calendar-03 text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Account Created</p>
                        <p class="text-xs font-bold text-slate-700">{{ $doctor->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Consultations -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-file-attachment text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Recent Consultations</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($doctor->doctorConsultations->sortByDesc('created_at')->take(5) as $c)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-800">{{ $c->patient->name ?? 'Unknown Patient' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $c->created_at->format('d M Y') }}</p>
                    </div>
                    <span class="text-[9px] font-bold px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded uppercase">{{ $c->status ?? 'done' }}</span>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-slate-400 text-xs italic">No consultations recorded yet.</div>
                @endforelse
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
                <p class="text-xs font-bold text-slate-700">Delete this doctor account</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">This action is permanent and cannot be undone.</p>
            </div>
            <form id="del-doctor-{{ $doctor->id }}" action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="openConfirmModal('delete', 'Delete Doctor Account', 'Are you sure you want to permanently delete this doctor account? This cannot be undone.', 'del-doctor-{{ $doctor->id }}')"
                    class="shrink-0 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
                Delete Account
            </button>
        </div>
    </div>
</div>
@endsection

