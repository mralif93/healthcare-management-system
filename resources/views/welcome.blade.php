@extends('layouts.public')

@section('title', 'Welcome to ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-white">
    <!-- Simple Navbar -->
    <nav class="border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <i class="hgi-stroke hgi-hospital-01 text-blue-600 text-2xl"></i>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">{{ config('app.name') }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-1/2">
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
                        Complete Healthcare <br>
                        <span class="text-blue-600">Management System</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                        A simplified portal for clinical excellence. Manage patients, track appointments, and handle consultations with ease and security.
                    </p>
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-md hover:bg-blue-700 transition">
                            Login to Portal
                        </a>
                        <a href="#features" class="px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-lg font-bold hover:bg-gray-50 transition">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="mt-12 lg:mt-0 lg:w-1/2 flex justify-center">
                    <div class="bg-white p-2 rounded-2xl shadow-xl border border-gray-100">
                        <div class="bg-gray-50 rounded-xl w-full h-64 sm:h-80 flex items-center justify-center p-8">
                            <i class="hgi-stroke hgi-analytics-up text-8xl text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Simple Features Grid -->
    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">System Features</h2>
                <div class="mt-2 h-1 w-20 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Admin Module -->
                <div class="p-8 border border-gray-100 rounded-2xl hover:border-blue-100 hover:bg-blue-50/30 transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="hgi-stroke hgi-manager text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Admin Panel</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Manage users, doctors, and system settings from a centralized administrative dashboard.</p>
                </div>

                <!-- Staff Module -->
                <div class="p-8 border border-gray-100 rounded-2xl hover:border-blue-100 hover:bg-blue-50/30 transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="hgi-stroke hgi-user-add-01 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Staff Operations</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Efficiently register patients and manage the daily appointment queue in real-time.</p>
                </div>

                <!-- Doctor Module -->
                <div class="p-8 border border-gray-100 rounded-2xl hover:border-blue-100 hover:bg-blue-50/30 transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="hgi-stroke hgi-doctor-01 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Doctor Workspace</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Digital consultation records, patient medical history, and personalized schedules.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple CTA -->
    <section class="py-16 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white">Ready to streamline your clinic?</h2>
            <p class="mt-4 text-gray-400">Access your professional workspace today.</p>
            <div class="mt-8">
                <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                    Go to Login Portal
                </a>
            </div>
        </div>
    </section>

    <!-- Basic Footer -->
    <footer class="py-8 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-2 grayscale opacity-50">
                <i class="hgi-stroke hgi-hospital-01 text-gray-900"></i>
                <span class="text-sm font-bold text-gray-900">{{ config('app.name') }}</span>
            </div>
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Clinical Portal. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection
