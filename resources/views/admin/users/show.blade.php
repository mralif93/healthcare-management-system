@extends('layouts.admin')

@section('title', 'Personnel Profile')
@section('page_title', 'Personnel Intelligence')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Hero Section -->
    <div
        class="bg-brand-600 rounded-2xl p-8 text-white shadow-xl shadow-brand-100 relative overflow-hidden animate__animated animate__fadeInUp animate__faster">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div
                    class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 shrink-0">
                    <i
                        class="hgi-stroke {{ $user->role === 'doctor' ? 'hgi-doctor-01' : 'hgi-manager' }} text-3xl text-white"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-white/60 mb-1">Personnel Profile</p>
                    <h1 class="text-2xl font-black tracking-tight">{{ $user->name }}</h1>
                    <div class="flex items-center space-x-3 mt-2">
                        <span class="text-[9px] font-black text-white/70 uppercase tracking-widest">{{ $user->staff_id
                            ?: 'ID PENDING' }}</span>
                        <span
                            class="px-2 py-0.5 bg-white/20 border border-white/30 rounded text-[9px] font-black text-white uppercase tracking-widest">{{
                            $user->role }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="px-5 py-2.5 bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-sm text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center space-x-2">
                    <i class="hgi-stroke hgi-pencil-edit-02"></i>
                    <span>Modify Profile</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white/80 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Directory
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Staff ID</p>
            <p class="text-sm font-black text-brand-600 uppercase">{{ $user->staff_id ?: 'Pending' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Role</p>
            <p class="text-sm font-black text-slate-900 capitalize">{{ $user->role }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Account Status</p>
            <span
                class="inline-flex px-2 py-0.5 {{ $user->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} border rounded text-[10px] font-black uppercase">{{
                $user->status }}</span>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Member Since</p>
            <p class="text-sm font-black text-slate-900">{{ $user->created_at->format('M Y') }}</p>
            <p class="text-[9px] font-bold text-slate-400 mt-0.5">{{ $user->email_verified_at ? 'Email Verified' :
                'Unverified' }}</p>
        </div>
    </div>

    <!-- 3-Column Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-mail-01 text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Contact Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-mail-01 text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Email Address</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-call text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Phone Number</p>
                        <p class="text-xs font-bold text-slate-700">{{ $user->phone ?: 'No number linked' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="hgi-stroke hgi-security-check text-brand-500 mt-0.5 text-sm shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Verification</p>
                        <p class="text-xs font-bold text-slate-700">{{ $user->email_verified_at ? 'Authorized —
                            '.$user->email_verified_at->format('M d, Y') : 'Pending Verification' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security & Status -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i class="hgi-stroke hgi-analytics-up text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">System Activity</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Account Status</span>
                    <span
                        class="px-2 py-0.5 {{ $user->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} border rounded text-[9px] font-black uppercase">{{
                        $user->status }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Registered</span>
                    <span class="text-[10px] font-bold text-slate-700">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Last Updated</span>
                    <span class="text-[10px] font-bold text-slate-700">{{ $user->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="mt-4 bg-slate-50 rounded-lg p-4 border border-slate-100 text-center">
                    <p class="text-[9px] font-medium text-slate-400">Access the Audit Logs module for full session
                        history.</p>
                </div>
            </div>
        </div>

        <!-- Role Intelligence -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
                <i
                    class="hgi-stroke hgi-{{ $user->role === 'doctor' ? 'stethoscope' : 'manager' }} text-brand-600 text-sm"></i>
                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Role Intelligence</h3>
            </div>
            <div class="p-6">
                @if($user->role === 'doctor')
                <div class="mb-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Specialization</p>
                    <p class="text-sm font-black text-slate-900">{{ $user->specialization ?: 'General Practitioner' }}
                    </p>
                </div>
                <p
                    class="text-xs font-medium text-slate-500 leading-relaxed bg-emerald-50/40 p-4 rounded-lg border border-emerald-100/60">
                    Authorized to conduct consultations, issue digital prescriptions, and manage patient medical
                    records.
                </p>
                @else
                <div class="mb-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Access Level</p>
                    <p class="text-sm font-black text-slate-900 capitalize">{{ $user->role }}</p>
                </div>
                <p
                    class="text-xs font-medium text-slate-500 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                    Authorized for patient management, appointment scheduling, and check-in operations.
                </p>
                @endif
            </div>
        </div>
    </div>
    <!-- Security Controls -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-2">
            <i class="hgi-stroke hgi-shield-key text-brand-600 text-sm"></i>
            <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Security Controls</h3>
        </div>
        <div class="p-6 space-y-5">

            @php
            $pwdChangedAt = $user->password_changed_at;
            $expiresAt = $pwdChangedAt ? $pwdChangedAt->copy()->addMonths(6) : null;
            $daysRemaining = $expiresAt ? (int) now()->diffInDays($expiresAt, false) : null;
            $isExpired = $daysRemaining !== null && $daysRemaining < 0; @endphp {{-- ── Last Password Changed Info Bar
                ── --}} <div
                class="bg-slate-50 rounded-xl border border-slate-100 p-4 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex items-center gap-3 flex-1">
                    <div
                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                        {{ $isExpired ? 'bg-red-50 border border-red-100' : ($pwdChangedAt ? 'bg-green-50 border border-green-100' : 'bg-slate-100 border border-slate-200') }}">
                        <i
                            class="hgi-stroke hgi-lock-password text-sm
                            {{ $isExpired ? 'text-red-500' : ($pwdChangedAt ? 'text-green-600' : 'text-slate-400') }}"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Last Password
                            Changed</p>
                        @if($pwdChangedAt)
                        <p class="text-xs font-bold text-slate-800">{{ $pwdChangedAt->format('d M Y, g:i A') }}</p>
                        <p
                            class="text-[10px] font-medium mt-0.5
                                {{ $isExpired ? 'text-red-500' : ($daysRemaining <= 30 ? 'text-amber-500' : 'text-slate-400') }}">
                            @if($isExpired)
                            <i class="hgi-stroke hgi-alert-02 mr-0.5"></i> Expired {{ abs($daysRemaining) }} day{{
                            abs($daysRemaining) !== 1 ? 's' : '' }} ago
                            @else
                            Expires in {{ $daysRemaining }} day{{ $daysRemaining !== 1 ? 's' : '' }} ({{
                            $expiresAt->format('d M Y') }})
                            @endif
                        </p>
                        @else
                        <p class="text-xs font-bold text-slate-500">Never recorded</p>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">Timer starts after first self-service
                            change</p>
                        @endif
                    </div>
                </div>
                @if($user->password_expiry_exempt)
                <span
                    class="shrink-0 px-3 py-1 bg-blue-50 border border-blue-100 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest">
                    Expiry Exempt
                </span>
                @endif
        </div>

        <div class="border-t border-slate-100"></div>

        {{-- ── Force Password Change Toggle ── --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">Force Password Change</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                    @if($user->must_change_password)
                    <span class="text-amber-600 font-bold">Active</span> — User will be prompted to change password on
                    next login.
                    @else
                    <span class="text-green-600 font-bold">Inactive</span> — User is not required to change password.
                    @endif
                </p>
            </div>
            <form id="toggle-pwd-{{ $user->id }}" action="{{ route('admin.users.toggle-password-change', $user) }}"
                method="POST" class="hidden">@csrf</form>
            <button onclick="openConfirmModal(
                        'warning',
                        '{{ $user->must_change_password ? 'Disable Force Password Change' : 'Enable Force Password Change' }}',
                        '{{ $user->must_change_password ? 'This will allow the user to log in without changing their password.' : 'The user will be required to change their password on next login.' }}',
                        'toggle-pwd-{{ $user->id }}'
                    )"
                class="shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors
                        {{ $user->must_change_password ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200' }}">
                {{ $user->must_change_password ? 'Disable Requirement' : 'Enable Requirement' }}
            </button>
        </div>

        <div class="border-t border-slate-100"></div>

        {{-- ── 6-Month Periodic Expiry Exempt Toggle ── --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">6-Month Periodic Expiry</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                    @if($user->password_expiry_exempt)
                    <span class="text-blue-600 font-bold">Exempt</span> — Admin override active. User will not be forced
                    to change password after 6 months.
                    @else
                    <span class="text-green-600 font-bold">Enforced</span> — User's password will automatically expire
                    every 6 months.
                    @endif
                </p>
            </div>
            <form id="toggle-expiry-{{ $user->id }}" action="{{ route('admin.users.toggle-expiry-exempt', $user) }}"
                method="POST" class="hidden">@csrf</form>
            <button onclick="openConfirmModal(
                        'warning',
                        '{{ $user->password_expiry_exempt ? 'Re-enable Periodic Expiry' : 'Exempt from Periodic Expiry' }}',
                        '{{ $user->password_expiry_exempt ? 'The user will again be required to change their password every 6 months.' : 'This user will be exempted from the automatic 6-month password expiry policy.' }}',
                        'toggle-expiry-{{ $user->id }}'
                    )"
                class="shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors
                        {{ $user->password_expiry_exempt ? 'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200' }}">
                {{ $user->password_expiry_exempt ? 'Re-enable Expiry' : 'Set as Exempt' }}
            </button>
        </div>

        <div class="border-t border-slate-100"></div>

        {{-- ── Account Lockout Status ── --}}
        @php
        $isLocked = $user->isLockedOut();
        $lockedUntil = $user->locked_until;
        @endphp
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">Account Lockout</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                    @if($isLocked)
                    <span class="text-red-600 font-bold">Locked</span> — Account is temporarily locked until
                    <span class="font-semibold text-slate-600">{{ $lockedUntil->format('g:i A, d M Y') }}</span>
                    ({{ $lockedUntil->diffForHumans() }}).
                    @else
                    <span class="text-green-600 font-bold">Active</span> — Account is not locked.
                    @if($user->login_attempts > 0)
                    <span class="text-amber-600 font-semibold">{{ $user->login_attempts }}/3 failed attempt(s)
                        recorded.</span>
                    @endif
                    @endif
                </p>
            </div>
            @if($isLocked)
            <form id="unlock-{{ $user->id }}" action="{{ route('admin.users.unlock-account', $user) }}" method="POST"
                class="hidden">@csrf</form>
            <button onclick="openConfirmModal(
                            'warning',
                            'Unlock Account',
                            'This will immediately unlock the account and reset the failed attempt counter.',
                            'unlock-{{ $user->id }}'
                        )"
                class="shrink-0 px-5 py-2.5 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
                Unlock Account
            </button>
            @else
            <span
                class="shrink-0 px-3 py-1 bg-green-50 border border-green-100 text-green-600 rounded-lg text-[9px] font-black uppercase tracking-widest">
                Not Locked
            </span>
            @endif
        </div>

        <div class="border-t border-slate-100"></div>

        {{-- ── Reset to Default Password ── --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-700">Reset to Default Password</p>
                <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                    Resets the user's password to <span class="font-mono font-bold text-slate-600">Password@123</span>
                    and forces a change on next login. The 6-month timer will also restart.
                </p>
            </div>
            <form id="reset-pwd-{{ $user->id }}" action="{{ route('admin.users.reset-password', $user) }}" method="POST"
                class="hidden">@csrf</form>
            <button onclick="openConfirmModal(
                        'delete',
                        'Reset Password to Default',
                        'This will reset the password to the default and require the user to change it on next login.',
                        'reset-pwd-{{ $user->id }}'
                    )"
                class="shrink-0 px-5 py-2.5 bg-orange-50 hover:bg-orange-100 border border-orange-200 text-orange-700 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
                Reset Password
            </button>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="bg-white rounded-xl border border-red-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-red-100 bg-red-50/50 flex items-center space-x-2">
        <i class="hgi-stroke hgi-delete-02 text-red-600 text-sm"></i>
        <h3 class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">Danger Zone</h3>
    </div>
    <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-xs font-bold text-slate-700">Delete this user account</p>
            <p class="text-[10px] font-medium text-slate-400 mt-0.5">This action is permanent and cannot be undone.
            </p>
        </div>
        <form id="del-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST">
            @csrf @method('DELETE')
        </form>
        <button
            onclick="openConfirmModal('delete', 'Delete User Account', 'Are you sure you want to permanently delete this user account? This cannot be undone.', 'del-user-{{ $user->id }}')"
            class="shrink-0 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">
            Delete Account
        </button>
    </div>
</div>
</div>
@endsection