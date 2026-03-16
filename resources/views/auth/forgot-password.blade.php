@extends('layouts.public')

@section('title', 'Forgot Password | ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center animate__animated animate__fadeInDown">
        <!-- Branding -->
        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 bg-brand-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-brand-200">
                <i class="hgi-stroke hgi-hospital-01 text-3xl"></i>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
            Reset Password
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-medium">
            Enter your email to receive a recovery link
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md animate__animated animate__fadeInUp">
        <div class="bg-white py-10 px-6 shadow-xl shadow-slate-100 border border-slate-100 sm:rounded-2xl sm:px-10">

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-100 flex items-center space-x-3 text-green-700">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-xl"></i>
                    <p class="text-sm font-bold">{{ session('status') }}</p>
                </div>
            @endif

            <form class="space-y-5" action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="hgi-stroke hgi-mail-01 text-lg"></i>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address"
                            class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 placeholder:text-slate-400 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs font-bold text-red-500 flex items-center space-x-1">
                            <i class="hgi-stroke hgi-alert-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-xl shadow-md text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all active:scale-95 uppercase tracking-widest">
                        Send Reset Link
                    </button>
                </div>
            </form>

            <!-- Secondary Action -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-brand-600 transition-colors flex items-center space-x-2 group">
                    <i class="hgi-stroke hgi-arrow-left-01 group-hover:-translate-x-1 transition-transform"></i>
                    <span>Back to Login</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
