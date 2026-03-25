@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('page_title', 'Audit Logs')

@section('content')
<div class="space-y-5">

    <!-- Hero -->
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-600 to-brand-800 rounded-2xl p-6 text-white shadow-xl shadow-brand-900/20">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-1/3 w-64 h-28 bg-brand-500/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-brand-200 text-[10px] font-black uppercase tracking-[0.2em] mb-1">System Security</p>
                <h2 class="text-xl font-bold">Audit Logs</h2>
                <p class="text-brand-200 text-sm mt-1 font-medium">Complete record of all user actions and system events.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 flex-shrink-0">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                    <p class="text-xl font-bold">{{ number_format($stats['total']) }}</p>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-brand-200 mt-0.5">Total Logs</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                    <p class="text-xl font-bold">{{ $stats['today'] }}</p>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-brand-200 mt-0.5">Today</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                    <p class="text-xl font-bold">{{ $stats['logins'] }}</p>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-brand-200 mt-0.5">Logins</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-center">
                    <p class="text-xl font-bold">{{ $stats['changes'] }}</p>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-brand-200 mt-0.5">Changes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-filter text-brand-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Filter Logs</h3>
        </div>
        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Search -->
                <div class="lg:col-span-2 flex items-center bg-slate-50 border border-slate-200 rounded-xl focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm ml-3 flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search description, IP, user…"
                           class="flex-1 bg-transparent px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none">
                    @if(request('search'))
                        <a href="{{ route('admin.audit-logs.index', array_except(request()->query(), ['search','page'])) }}"
                           class="mr-2 text-slate-400 hover:text-slate-600 transition-colors text-xs font-semibold">✕</a>
                    @endif
                </div>
                <!-- Action -->
                <select name="action" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
                <!-- User -->
                <select name="user_id" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                <!-- Submit -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 flex items-center justify-center space-x-2 bg-brand-600 text-white rounded-xl px-4 py-2.5 text-sm font-semibold hover:bg-brand-700 transition-all active:scale-95">
                        <i class="hgi-stroke hgi-search-01 text-sm"></i>
                        <span>Search</span>
                    </button>
                    @if(request()->hasAny(['search','action','user_id','date_from','date_to']))
                        <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 transition-all" title="Clear filters">
                            <i class="hgi-stroke hgi-cancel-01 text-sm"></i>
                        </a>
                    @endif
                </div>
            </div>
            <!-- Date range -->
            <div class="mt-3 flex flex-wrap gap-3 items-center">
                <div class="flex items-center space-x-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <p class="text-xs text-slate-400 ml-auto">{{ $logs->total() }} result(s) found</p>
            </div>
        </form>
    </div>

    <!-- Log Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="hgi-stroke hgi-activity-01 text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Activity Log</h3>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">Timestamp</th>
                        <th class="px-4 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">User</th>
                        <th class="px-4 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">Action</th>
                        <th class="px-4 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">Description</th>
                        <th class="px-4 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">Model</th>
                        <th class="px-4 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">IP Address</th>
                        <th class="px-4 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-[0.15em]">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    @php
                        $color = $log->action_badge_color;
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="px-6 py-3.5">
                            <p class="text-xs font-semibold text-slate-900 leading-none">{{ $log->created_at->format('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $log->created_at->format('h:i:s A') }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-lg bg-brand-50 flex items-center justify-center text-brand-700 text-xs font-bold flex-shrink-0">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900 leading-none">{{ $log->user->name ?? 'System' }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5 capitalize">{{ $log->user->role ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                                bg-{{ $color }}-50 text-{{ $color }}-700">
                                <i class="hgi-stroke {{ $log->action_icon }} text-xs"></i>
                                <span>{{ ucfirst($log->action) }}</span>
                            </span>
                        </td>
                        <td class="px-4 py-3.5 max-w-xs">
                            <p class="text-xs text-slate-700 font-medium leading-snug line-clamp-2">{{ $log->description }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            @if($log->auditable_type)
                                <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-lg">
                                    {{ $log->model_label }}
                                    @if($log->auditable_id) #{{ $log->auditable_id }} @endif
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="text-xs font-mono text-slate-500">{{ $log->ip_address ?? '—' }}</p>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <a href="{{ route('admin.audit-logs.show', $log->id) }}"
                               class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-brand-600 flex items-center justify-center text-slate-400 group-hover:text-white transition-all mx-auto">
                                <i class="hgi-stroke hgi-arrow-right-01 text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i class="hgi-stroke hgi-activity-01 text-4xl text-slate-200 block mb-3"></i>
                            <p class="text-sm text-slate-400 font-medium">No audit logs found.</p>
                            @if(request()->hasAny(['search','action','user_id','date_from','date_to']))
                                <a href="{{ route('admin.audit-logs.index') }}" class="mt-2 inline-block text-xs text-brand-600 font-semibold hover:underline">Clear filters</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
