@extends('layouts.public')

@section('title', 'Login | ' . config('app.name'))

@section('content')
<div class="min-h-screen min-h-[100dvh] flex">

    <!-- Left Branding Panel -->
    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 flex-col justify-between p-12 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-600/5 rounded-full blur-2xl">
            </div>
        </div>

        <!-- Logo area -->
        <div class="relative animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-900/50">
                    <i class="hgi-stroke hgi-hospital-01 text-xl"></i>
                </div>
                <span class="text-white text-lg font-bold tracking-tight">{{ config('app.name') }}</span>
            </div>
        </div>

        <!-- Center content -->
        <div class="relative animate__animated animate__fadeInUp space-y-6">
            <div class="space-y-3">
                <span
                    class="inline-flex items-center space-x-2 px-3 py-1.5 bg-blue-600/20 border border-blue-500/30 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span class="text-blue-300 text-xs font-semibold tracking-widest uppercase">Secure Access
                        Portal</span>
                </span>
                <h1 class="text-4xl font-bold text-white leading-tight">
                    Your Clinical<br />
                    <span class="text-blue-400">Workspace</span>
                </h1>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Manage patients, appointments, and medical records from one unified healthcare platform.
                </p>
            </div>

            <!-- Feature list -->
            <div class="space-y-3 pt-2">
                @foreach([['hgi-user-group', 'Patient Management', 'Full patient registry & medical history'],
                ['hgi-calendar-01', 'Appointment Scheduling', 'Smart booking with QR check-in'], ['hgi-clipboard',
                'Clinical Records', 'Digital consultation notes & prescriptions']] as [$icon, $title, $desc])
                <div class="flex items-start space-x-3">
                    <div
                        class="w-8 h-8 rounded-xl bg-blue-600/20 flex items-center justify-center text-blue-400 flex-shrink-0 mt-0.5">
                        <i class="hgi-stroke {{ $icon }} text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $title }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        <div class="relative">
            <p class="text-slate-600 text-xs">© {{ date('Y') }} {{ config('app.name', 'Clinic OS') }}. All rights
                reserved.</p>
        </div>
    </div>

    <!-- Right Login Panel -->
    <div class="flex-1 flex flex-col justify-center items-center bg-white px-6 py-12 sm:px-12">
        <div class="w-full max-w-md animate__animated animate__fadeInUp animate__faster">

            <!-- Mobile logo (hidden on lg+) -->
            <div class="lg:hidden flex items-center justify-center space-x-3 mb-10">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <i class="hgi-stroke hgi-hospital-01 text-xl"></i>
                </div>
                <span class="text-slate-900 text-lg font-bold tracking-tight">{{ config('app.name', 'Clinic OS')
                    }}</span>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome back</h2>
                <p class="text-sm text-slate-500 mt-1.5 font-medium">Sign in to your personnel account to continue</p>
            </div>

            @if($errors->any())
            @if(session('lockout'))
            {{-- Lockout-specific banner --}}
            <div class="mb-6 rounded-xl border border-red-200 overflow-hidden animate__animated animate__headShake">
                <div class="flex items-center gap-3 bg-red-600 px-4 py-2.5">
                    <i class="hgi-stroke hgi-lock-01 text-white text-base flex-shrink-0"></i>
                    <p class="text-xs font-black text-white uppercase tracking-widest">Account Locked</p>
                </div>
                <div class="bg-red-50 px-4 py-3">
                    @foreach($errors->all() as $error)
                    <p class="text-sm font-medium text-red-700">{{ $error }}</p>
                    @endforeach
                    <p class="text-[10px] font-medium text-red-400 mt-1">Contact your administrator for an early unlock.
                    </p>
                </div>
            </div>
            @else
            <div
                class="mb-6 flex items-start space-x-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 animate__animated animate__headShake">
                <i class="hgi-stroke hgi-alert-circle text-lg flex-shrink-0 mt-0.5"></i>
                <div>
                    @foreach($errors->all() as $error)
                    <p class="text-sm font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Staff ID -->
                <div class="space-y-1.5">
                    <label for="staff_id" class="text-xs font-semibold text-slate-700">Personnel ID</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="hgi-stroke hgi-user text-slate-400 text-base"></i>
                        </div>
                        <input id="staff_id" name="staff_id" type="text" value="{{ old('staff_id') }}" required
                            autofocus placeholder="e.g. ADM-001" autocomplete="off"
                            class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 placeholder:text-slate-400 text-sm font-medium text-slate-900 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-semibold text-slate-700">Password</label>
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-medium text-blue-600 hover:text-blue-700 transition-colors">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="hgi-stroke hgi-lock-password text-slate-400 text-base"></i>
                        </div>
                        <input id="password" name="password" type="password" required placeholder="••••••••"
                            class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 placeholder:text-slate-400 text-sm font-medium text-slate-900 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center space-x-2.5">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 rounded appearance-none border border-slate-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all cursor-pointer">
                    <label for="remember_me" class="text-sm text-slate-600 font-medium select-none">Keep me signed
                        in</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full flex items-center justify-center space-x-2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="hgi-stroke hgi-login-01 text-base"></i>
                    <span>Sign In</span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="/"
                    class="inline-flex items-center space-x-2 text-sm text-slate-400 hover:text-blue-600 transition-colors group">
                    <i
                        class="hgi-stroke hgi-arrow-left-01 text-sm group-hover:-translate-x-0.5 transition-transform"></i>
                    <span class="font-medium">Back to Homepage</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection