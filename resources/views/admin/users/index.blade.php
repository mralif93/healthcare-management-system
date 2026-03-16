@extends('layouts.admin')

@section('title', 'User Management')
@section('page_title', 'Personnel Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">System Users</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-md hover:bg-brand-700 transition-all active:scale-95 flex items-center space-x-2">
            <i class="hgi-stroke hgi-user-add-01"></i>
            <span>Add Personnel</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-600 flex items-center space-x-3 animate-in fade-in slide-in-from-top-2 duration-300">
        <i class="hgi-stroke hgi-checkmark-circle-02"></i>
        <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap gap-4 items-center">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex-1 min-w-[300px] flex gap-2">
                <div class="relative flex-1">
                    <i class="hgi-stroke hgi-search-01 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, or ID..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs font-medium focus:ring-2 focus:ring-brand-500/10 focus:border-brand-500 outline-none transition-all">
                </div>
                <select name="role" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-600 outline-none focus:ring-2 focus:ring-brand-500/10">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Filter</button>
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
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Archive this personnel?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Archive Account">
                                        <i class="hgi-stroke hgi-delete-02 text-xs"></i>
                                    </button>
                                </form>
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
