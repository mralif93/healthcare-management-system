@extends('layouts.admin')

@section('title', 'User Management')
@section('page_title', 'Personnel Management')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Administration Module</p>
                <h1 class="text-2xl font-black tracking-tight">User Management</h1>
                <p class="text-sm text-white/70 mt-1">System users &amp; access control</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2 shrink-0">
                <i class="hgi-stroke hgi-user-add-01"></i>
                <span>Create New User</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-3">
                <div class="flex-1 flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-3.5 focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all">
                    <i class="hgi-stroke hgi-search-01 text-slate-400 text-sm flex-shrink-0"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or staff ID..."
                           class="flex-1 py-2.5 text-xs font-medium outline-none bg-transparent placeholder:text-slate-400">
                </div>
                <select name="role" class="bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-600 outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all flex items-center space-x-2 active:scale-95 flex-shrink-0">
                    <i class="hgi-stroke hgi-search-01 text-sm"></i>
                    <span>Search</span>
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">× Clear</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Personnel Info</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Access Role</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Staff ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs uppercase group-hover:bg-brand-100 group-hover:text-brand-600 transition-all">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 leading-none">{{ $user->name }}</div>
                                    <div class="text-[10px] text-slate-400 mt-1">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-widest border
                                @if($user->role === 'admin') bg-purple-50 text-purple-600 border-purple-100 
                                @elseif($user->role === 'doctor') bg-blue-50 text-blue-600 border-blue-100 
                                @else bg-slate-50 text-slate-600 border-slate-100 @endif">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500">
                            {{ $user->staff_id ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center space-x-1.5 {{ $user->status === 'active' ? 'text-green-600' : 'text-red-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $user->status }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="w-8 h-8 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="View Intelligence">
                                    <i class="hgi-stroke hgi-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Personnel">
                                    <i class="hgi-stroke hgi-pencil-edit-02 text-xs"></i>
                                </a>
                                <form id="del-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button"
                                        onclick="openConfirmModal('delete', 'Archive Personnel Account', 'Are you sure you want to archive this account? This action cannot be undone.', 'del-user-{{ $user->id }}')"
                                        class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Archive Account">
                                    <i class="hgi-stroke hgi-delete-02 text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400 text-xs italic">No matching personnel found in the directory.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
