@extends('layouts.public')

@section('title', 'Forgot Password | ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Branding -->
        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="hgi-stroke hgi-hospital-01 text-2xl"></i>
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
            Reset Password
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Enter your email to receive a recovery link
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-xl shadow-slate-200 border border-gray-100 sm:rounded-2xl sm:px-10">
            
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-100 flex items-center space-x-3 text-green-800">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-xl"></i>
                    <p class="text-sm font-bold">{{ session('status') }}</p>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="hgi-stroke hgi-mail-01 text-lg"></i>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email"
                            class="appearance-none block w-full pl-11 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-red-600 flex items-center space-x-1">
                            <i class="hgi-stroke hgi-alert-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all active:scale-95">
                        Send Reset Link
                    </button>
                </div>
            </form>

            <!-- Secondary Action -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors flex items-center space-x-2 group">
                    <i class="hgi-stroke hgi-arrow-left-01 group-hover:-translate-x-1 transition-transform"></i>
                    <span>Back to Login</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
