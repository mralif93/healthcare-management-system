@extends('layouts.public')

@section('title', 'Login | ' . config('app.name'))

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
            Personnel Login
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Access your professional clinical workspace
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-xl shadow-slate-200 border border-gray-100 sm:rounded-2xl sm:px-10">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Staff ID -->
                <div>
                    <label for="staff_id" class="block text-sm font-bold text-gray-700 mb-1">
                        Personnel ID
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="hgi-stroke hgi-user text-lg"></i>
                        </div>
                        <input id="staff_id" name="staff_id" type="text" value="{{ old('staff_id') }}" required autofocus placeholder="Enter your ID"
                            class="appearance-none block w-full pl-11 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    </div>
                    @error('staff_id')
                        <p class="mt-2 text-xs font-bold text-red-600 flex items-center space-x-1">
                            <i class="hgi-stroke hgi-alert-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-bold text-gray-700">
                            Password
                        </label>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-bold text-blue-600 hover:text-blue-500">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="hgi-stroke hgi-lock-password text-lg"></i>
                        </div>
                        <input id="password" name="password" type="password" required placeholder="••••••••"
                            class="appearance-none block w-full pl-11 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600 font-medium">
                        Remember this session
                    </label>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all active:scale-95">
                        Initialize Session
                    </button>
                </div>
            </form>

            <!-- Secondary Action -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                <a href="/" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors flex items-center space-x-2">
                    <i class="hgi-stroke hgi-arrow-left-01"></i>
                    <span>Back to Homepage</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
