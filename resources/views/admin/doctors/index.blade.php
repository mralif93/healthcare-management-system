@extends('layouts.admin')

@section('title', 'Doctor Management')
@section('page_title', 'Doctor Registry')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">Doctors Management</h1>
                <p class="text-sm text-white/70 mt-1">Medical staff accounts & specialization</p>
            </div>
            <a href="{{ route('admin.doctors.create') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2 shrink-0">
                <i class="hgi-stroke hgi-user-add-01"></i>
                <span>Add New Doctor</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('admin.doctors.index') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, or specialization..."
                           class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400">
                </div>
                <select name="status" class="bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-600 outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all flex items-center space-x-2 active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-search-01 text-sm"></i>
                    <span>Search</span>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.doctors.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">× Clear</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Staff ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Doctor Details</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Specialization</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($doctors as $doctor)
                    <tr class="hover:bg-slate-50/50 transition-colors group text-xs">
                        <td class="px-6 py-4 font-black text-brand-600 uppercase tracking-tighter">{{ $doctor->staff_id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $doctor->name }}</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">{{ $doctor->email }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">{{ $doctor->specialization ?: '—' }}</td>
                        <td class="px-6 py-4 font-medium text-slate-500">{{ $doctor->phone ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-0.5 {{ $doctor->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} border rounded text-[10px] font-black uppercase">
                                {{ $doctor->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.doctors.show', $doctor) }}" class="w-8 h-8 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="View Details">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Doctor">
                                    <i class="hgi-stroke hgi-pencil-edit-02 text-xs"></i>
                                </a>
                                <form id="del-doctor-{{ $doctor->id }}" action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button"
                                        onclick="openConfirmModal('delete', 'Delete Doctor Account', 'Are you sure you want to permanently delete this doctor account? This action cannot be undone.', 'del-doctor-{{ $doctor->id }}')"
                                        class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Delete">
                                    <i class="hgi-stroke hgi-delete-02 text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-20 text-center text-slate-400 text-xs italic">No doctors registered in the system.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $doctors->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

