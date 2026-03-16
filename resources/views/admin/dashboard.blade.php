@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    
    <!-- Compact Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Patients -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-brand-50 rounded-lg flex items-center justify-center text-brand-600 shrink-0">
                <i class="hgi-stroke hgi-user-group text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Patients</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ number_format($stats['total_patients']) }}</p>
            </div>
        </div>

        <!-- Medical Staff -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 shrink-0">
                <i class="hgi-stroke hgi-doctor-01 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Medical Staff</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['total_doctors'] }}</p>
            </div>
        </div>

        <!-- Today's Activity -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 shrink-0">
                <i class="hgi-stroke hgi-calendar-01 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Today's Appts</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['appointments_today'] }}</p>
            </div>
        </div>

        <!-- Operational Staff -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 shrink-0">
                <i class="hgi-stroke hgi-manager text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Op. Staff</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['total_staff'] }}</p>
            </div>
        </div>
    </div>

    <!-- Data Tables Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Appointments Table -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Recent Activity</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-[10px] font-bold text-brand-600 hover:text-brand-700 uppercase tracking-widest">Manage All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recent_appointments as $apt)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] font-bold uppercase">
                                        {{ substr($apt->patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $apt->patient->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-medium">ID: {{ $apt->patient->patient_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-medium text-slate-600">Dr. {{ $apt->doctor->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest border
                                    @if($apt->status === 'confirmed') bg-green-50 text-green-600 border-green-100
                                    @elseif($apt->status === 'pending') bg-orange-50 text-orange-600 border-orange-100
                                    @else bg-blue-50 text-brand-600 border-blue-100 @endif">
                                    {{ $apt->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400 text-xs italic">No recent appointments.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Panel: New Registrations -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">New Registrations</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recent_patients as $patient)
                <div class="px-6 py-4 flex items-center justify-between group">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center text-brand-600 font-bold text-[10px]">
                            {{ substr($patient->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 leading-none">{{ $patient->name }}</p>
                            <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $patient->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.patients.show', $patient->id) }}" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 group-hover:bg-brand-600 group-hover:text-white transition-all">
                        <i class="hgi-stroke hgi-arrow-right-01 text-xs"></i>
                    </a>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-slate-400 text-xs italic">No new registrations.</div>
                @endforelse
            </div>
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                <a href="{{ route('admin.patients.index') }}" class="block text-center text-[10px] font-bold text-slate-500 hover:text-slate-900 uppercase tracking-widest transition-colors">
                    Access Registry
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
