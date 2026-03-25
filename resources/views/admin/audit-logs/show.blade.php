@extends('layouts.admin')

@section('title', 'Audit Log #' . $auditLog->id)
@section('page_title', 'Audit Log Detail')

@section('content')
@php $color = $auditLog->action_badge_color; @endphp
<div class="space-y-5">

    <!-- Hero -->
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-600 to-brand-800 rounded-2xl p-6 text-white shadow-xl shadow-brand-900/20">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
        </div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-brand-200 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Audit Log #{{ $auditLog->id }}</p>
                <h2 class="text-xl font-bold">Event Detail</h2>
                <p class="text-brand-200 text-sm mt-1 font-medium">{{ $auditLog->created_at->format('l, d F Y \a\t h:i:s A') }}</p>
            </div>
            <a href="{{ route('admin.audit-logs.index') }}"
               class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-white/20 transition-all active:scale-95 flex-shrink-0">
                <i class="hgi-stroke hgi-arrow-left-01 text-base"></i>
                <span>Back to Logs</span>
            </a>
        </div>
    </div>

    <!-- Stats Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Action</p>
            <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-{{ $color }}-50 text-{{ $color }}-700">
                <i class="hgi-stroke {{ $auditLog->action_icon }} text-xs"></i>
                <span>{{ ucfirst($auditLog->action) }}</span>
            </span>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">User</p>
            <p class="text-sm font-bold text-slate-900">{{ $auditLog->user->name ?? 'System' }}</p>
            <p class="text-[10px] text-slate-400 capitalize">{{ $auditLog->user->role ?? '—' }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Model</p>
            <p class="text-sm font-bold text-slate-900">{{ $auditLog->model_label }}</p>
            <p class="text-[10px] text-slate-400">ID: {{ $auditLog->auditable_id ?? '—' }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">IP Address</p>
            <p class="text-sm font-bold text-slate-900 font-mono">{{ $auditLog->ip_address ?? '—' }}</p>
            <p class="text-[10px] text-slate-400">{{ $auditLog->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <!-- Main Detail -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Event Info -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-information-circle text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Event Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Description</p>
                    <p class="text-sm text-slate-700 font-medium leading-relaxed">{{ $auditLog->description }}</p>
                </div>
                <div class="h-px bg-slate-100"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Timestamp</p>
                        <p class="text-sm text-slate-700 font-medium">{{ $auditLog->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $auditLog->created_at->format('h:i:s A') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Model Type</p>
                        <p class="text-sm text-slate-700 font-medium font-mono text-xs">{{ $auditLog->auditable_type ?? '—' }}</p>
                    </div>
                </div>
                <div class="h-px bg-slate-100"></div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">User Agent</p>
                    <p class="text-xs text-slate-500 leading-relaxed break-all">{{ $auditLog->user_agent ?? '—' }}</p>
                </div>
            </div>
        </div>

        <!-- Old Values -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-file-02 text-amber-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Previous Values</h3>
            </div>
            <div class="p-6">
                @if($auditLog->old_values)
                    <div class="space-y-2">
                        @foreach($auditLog->old_values as $key => $value)
                        <div class="flex items-start justify-between gap-3 py-2 border-b border-slate-50 last:border-0">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex-shrink-0 w-28">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="text-xs text-slate-700 font-medium text-right break-all">{{ is_array($value) ? json_encode($value) : ($value ?? '—') }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center">
                        <i class="hgi-stroke hgi-file-02 text-3xl text-slate-200 block mb-2"></i>
                        <p class="text-xs text-slate-400">No previous values recorded.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- New Values -->
    @if($auditLog->new_values)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-file-edit text-emerald-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">New / Current Values</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-3">
                @foreach($auditLog->new_values as $key => $value)
                <div class="flex items-start justify-between gap-2 py-2 border-b border-slate-50">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex-shrink-0">{{ str_replace('_', ' ', $key) }}</p>
                    <p class="text-xs text-slate-700 font-medium text-right break-all">{{ is_array($value) ? json_encode($value) : ($value ?? '—') }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

