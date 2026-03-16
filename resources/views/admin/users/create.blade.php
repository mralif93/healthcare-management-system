@extends('layouts.admin')

@section('title', 'Add User')
@section('page_title', 'Register New Personnel')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest italic">Account Details</h3>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                    @error('email') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-1.5" x-data="{ role: '{{ old('role') }}' }">
                    <label for="role" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Access Role</label>
                    <select name="role" id="role" x-model="role" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="staff">Staff</option>
                    </select>
                    @error('role') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label for="status" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                    <select name="status" id="status" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Staff ID -->
                <div class="space-y-1.5">
                    <label for="staff_id" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Personnel ID (Optional)</label>
                    <input type="text" name="staff_id" id="staff_id" value="{{ old('staff_id') }}" placeholder="e.g. DOC-001"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Specialization -->
                <div class="space-y-1.5" id="specialization_container">
                    <label for="specialization" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Specialization</label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" placeholder="For Doctors only"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Secure Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:ring-4 focus:ring-brand-500/5 focus:border-brand-500 outline-none transition-all">
                </div>
            </div>

            <div class="pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-500 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="px-8 py-2.5 bg-brand-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all active:scale-95">
                    Register User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
