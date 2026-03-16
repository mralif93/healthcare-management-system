@extends('layouts.staff')

@section('title', 'Dashboard')
@section('page_title', 'Clinic Operations')

@section('content')
<div class="space-y-6">
    
    <!-- Compact Action Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Live System Feed</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('staff.patients.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-indigo-700 transition-all active:scale-95">
                Quick Register
            </a>
            <a href="{{ route('staff.appointments.create') }}" class="bg-white text-indigo-600 border border-indigo-200 px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-indigo-50 transition-all">
                New Booking
            </a>
        </div>
    </div>

    <!-- Compact Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-indigo-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 shrink-0">
                <i class="hgi-stroke hgi-calendar-01 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Today's Appts</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['today_appointments'] }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-indigo-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600 shrink-0">
                <i class="hgi-stroke hgi-checkmark-circle-02 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Checked In</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['checked_in'] }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-indigo-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 shrink-0">
                <i class="hgi-stroke hgi-time-02 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pending</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['pending_appointments'] }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-indigo-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                <i class="hgi-stroke hgi-user-add-01 text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">New Patients</p>
                <p class="text-xl font-bold text-slate-900 leading-none mt-1">{{ $stats['new_patients'] }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Upcoming Queue -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Active Patient Queue</h3>
                <a href="{{ route('staff.checkin') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-widest underline">Manage All Arrival</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @forelse($upcoming as $apt)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i') }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded bg-indigo-50 flex items-center justify-center text-indigo-400 text-[10px] font-bold uppercase">
                                        {{ substr($apt->patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $apt->patient->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-medium">ID: {{ $apt->patient->patient_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">Dr. {{ $apt->doctor->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($apt->status === 'pending')
                                    <a href="{{ route('staff.checkin', ['search' => $apt->appointment_id]) }}" class="inline-flex px-3 py-1 bg-green-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-green-700 transition-all">Check-in</a>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-400 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200">Arrived</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs italic">No upcoming patients in queue.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Available Doctors -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">In Clinic Now</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($doctors as $doctor)
                <div class="px-6 py-4 flex items-center justify-between group">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-[10px]">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-2 h-2 rounded-full bg-green-500 border-2 border-white"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 leading-none">{{ $doctor->name }}</p>
                            <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $doctor->specialization }}</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.doctor-schedules', ['doctor_id' => $doctor->id]) }}" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                        <i class="hgi-stroke hgi-calendar-01 text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
