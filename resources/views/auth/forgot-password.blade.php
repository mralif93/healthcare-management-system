@extends('layouts.public')

@section('title', 'Forgot Password | ' . config('app.name'))

@section('content')
<div class="min-h-screen min-h-[100dvh] flex">

    <!-- Left Branding Panel -->
    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 flex-col justify-between p-12 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-600/5 rounded-full blur-2xl"></div>
        </div>

        <!-- Logo area -->
        <div class="relative animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-900/50">
                    <i class="hgi-stroke hgi-hospital-01 text-xl"></i>
                </div>
                <span class="text-white text-lg font-bold tracking-tight">{{ config('app.name') }}</span>
            </div>
        </div>

        <!-- Center content -->
        <div class="relative animate__animated animate__fadeInUp space-y-6">
            <div class="space-y-3">
                <span class="inline-flex items-center space-x-2 px-3 py-1.5 bg-blue-600/20 border border-blue-500/30 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span class="text-blue-300 text-xs font-semibold tracking-widest uppercase">Account Recovery</span>
                </span>
                <h1 class="text-4xl font-bold text-white leading-tight">
                    Reset Your<br/>
                    <span class="text-blue-400">Password</span>
                </h1>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Enter your registered email address and we'll send you a secure link to reset your password.
                </p>
            </div>

            <!-- Steps -->
            <div class="space-y-3 pt-2">
                @foreach([['hgi-mail-01', 'Enter Your Email', 'Provide the email linked to your account'], ['hgi-sent', 'Check Your Inbox', 'We\'ll send a secure recovery link'], ['hgi-lock-password', 'Create New Password', 'Follow the link to set a new password']] as [$icon, $title, $desc])
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-600/20 flex items-center justify-center text-blue-400 flex-shrink-0 mt-0.5">
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
            <p class="text-slate-600 text-xs">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="flex-1 flex flex-col justify-center items-center bg-white px-6 py-12 sm:px-12">
        <div class="w-full max-w-md animate__animated animate__fadeInUp animate__faster">

            <!-- Mobile logo (hidden on lg+) -->
            <div class="lg:hidden flex items-center justify-center space-x-3 mb-10">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <i class="hgi-stroke hgi-hospital-01 text-xl"></i>
                </div>
                <span class="text-slate-900 text-lg font-bold tracking-tight">{{ config('app.name') }}</span>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Forgot your password?</h2>
                <p class="text-sm text-slate-500 mt-1.5 font-medium">Enter your email address and we'll send you a recovery link</p>
            </div>

            @if (session('status'))
                <div class="mb-6 flex items-start space-x-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 animate__animated animate__fadeInDown">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-lg flex-shrink-0 mt-0.5"></i>
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 flex items-start space-x-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 animate__animated animate__headShake">
                    <i class="hgi-stroke hgi-alert-circle text-lg flex-shrink-0 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p class="text-sm font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form class="space-y-5" action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="hgi-stroke hgi-mail-01 text-slate-400 text-base"></i>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                               placeholder="Enter your email address"
                               autocomplete="email"
                               class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 placeholder:text-slate-400 text-sm font-medium text-slate-900 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full flex items-center justify-center space-x-2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-lg shadow-blue-600/30 transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="hgi-stroke hgi-sent text-base"></i>
                    <span>Send Reset Link</span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 text-sm text-slate-400 hover:text-blue-600 transition-colors group">
                    <i class="hgi-stroke hgi-arrow-left-01 text-sm group-hover:-translate-x-0.5 transition-transform"></i>
                    <span class="font-medium">Back to Login</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
