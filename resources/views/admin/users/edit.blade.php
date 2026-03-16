@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Update Personnel Record')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Modify Account: {{ $user->name }}</h3>
            <span class="px-2 py-1 bg-brand-50 text-brand-600 rounded text-[10px] font-black uppercase tracking-widest">{{ $user->role }}</span>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    @error('email') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-1.5">
                    <label for="role" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Access Role</label>
                    <select name="role" id="role" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="doctor" {{ old('role', $user->role) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label for="status" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                    <select name="status" id="status" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Staff ID -->
                <div class="space-y-1.5">
                    <label for="staff_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Personnel ID (Optional)</label>
                    <input type="text" name="staff_id" id="staff_id" value="{{ old('staff_id', $user->staff_id) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Specialization -->
                <div class="space-y-1.5">
                    <label for="specialization" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Specialization</label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $user->specialization) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Security Update (Optional)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="px-8 py-2.5 bg-brand-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Synchronize Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
