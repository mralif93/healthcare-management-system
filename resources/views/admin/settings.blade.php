@extends('layouts.admin')

@section('title', 'System Settings')
@section('page_title', 'Core Configuration')

@section('content')
<div class="mx-auto space-y-6">
    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3 animate__animated animate__fadeInDown animate__faster">
        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
        <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ tab: 'general' }">
        <div class="border-b border-slate-100 bg-slate-50/50 flex overflow-x-auto">
            <button @click="tab = 'general'" :class="tab === 'general' ? 'border-brand-600 text-brand-600 bg-white' : 'border-transparent text-slate-400 hover:text-slate-600'" 
                class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] border-b-2 transition-all outline-none">
                General Identity
            </button>
            <button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'border-brand-600 text-brand-600 bg-white' : 'border-transparent text-slate-400 hover:text-slate-600'" 
                class="px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] border-b-2 transition-all outline-none">
                Clinical Schedule
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <!-- General Settings -->
            <div x-show="tab === 'general'" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($settings['general'] ?? [] as $setting)
                    <div class="space-y-1.5">
                        <label for="{{ $setting->key }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ $setting->label }}</label>
                        @if($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="3"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">{{ $setting->value }}</textarea>
                        @else
                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Schedule Settings -->
            <div x-show="tab === 'schedule'" class="space-y-6" [x-cloak]:hidden x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($settings['schedule'] ?? [] as $setting)
                    <div class="space-y-1.5">
                        <label for="{{ $setting->key }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ $setting->label }}</label>
                        <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-8 border-t border-slate-50 flex justify-end">
                <button type="submit" class="px-10 py-3 bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-[0.3em] shadow-xl shadow-slate-200 hover:bg-brand-600 hover:-translate-y-0.5 transition-all active:scale-95">
                    Save Configuration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
