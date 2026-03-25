@extends('layouts.admin')

@section('title', 'System Settings')
@section('page_title', 'Core Configuration')

@section('content')
<div class="mx-auto space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div>
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
            <h1 class="text-2xl font-black tracking-tight">Core Configuration</h1>
            <p class="text-sm text-white/70 mt-1">System settings &amp; clinical schedule</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ tab: 'general' }">
        <!-- Tab Nav -->
        <div class="border-b border-slate-100 bg-slate-50/50 flex overflow-x-auto">
            <button @click="tab = 'general'" :class="tab === 'general' ? 'border-brand-600 text-brand-600 bg-white' : 'border-transparent text-slate-400 hover:text-slate-600'"
                class="flex items-center gap-2 px-8 py-4 text-xs font-semibold border-b-2 transition-all outline-none">
                <i class="hgi-stroke hgi-settings-02"></i> General Settings
            </button>
            <button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'border-brand-600 text-brand-600 bg-white' : 'border-transparent text-slate-400 hover:text-slate-600'"
                class="flex items-center gap-2 px-8 py-4 text-xs font-semibold border-b-2 transition-all outline-none">
                <i class="hgi-stroke hgi-calendar-03"></i> Operating Hours
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <!-- General Settings -->
            <div x-show="tab === 'general'" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($settings['general'] ?? [] as $setting)
                    <div class="space-y-1.5">
                        <label for="{{ $setting->key }}" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-edit-02 text-slate-400"></i> {{ $setting->label }}
                        </label>
                        @if($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">{{ $setting->value }}</textarea>
                        @else
                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Schedule Settings -->
            <div x-show="tab === 'schedule'" class="p-8 space-y-6" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($settings['schedule'] ?? [] as $setting)
                    <div class="space-y-1.5">
                        <label for="{{ $setting->key }}" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <i class="hgi-stroke hgi-clock-01 text-slate-400"></i> {{ $setting->label }}
                        </label>
                        <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all shadow-sm">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-5 bg-slate-50/70 border-t border-slate-100 flex justify-end">
                <button type="submit" class="flex items-center space-x-2 px-7 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-brand-100/50 hover:bg-brand-700 transition-all active:scale-95">
                    <i class="hgi-stroke hgi-checkmark-circle-02"></i>
                    <span>Save Configuration</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
