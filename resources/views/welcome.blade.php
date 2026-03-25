@extends('layouts.public')

@section('title', 'Welcome to ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-white">

    {{-- ===== NAVBAR ===== --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <i class="hgi-stroke hgi-hospital-01 text-white text-sm"></i>
                </div>
                <span class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ config('app.name') }}</span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}" class="bg-brand-600 text-white px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brand-700 transition-all shadow-md shadow-brand-100 active:scale-95">
                    Sign In
                </a>
            </div>
        </div>
    </nav>

    {{-- ===== HERO ===== --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-brand-950 to-slate-900 pt-24 pb-32">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-96 h-96 bg-brand-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-brand-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-5xl mx-auto px-6 lg:px-8 text-center animate__animated animate__fadeInUp">
            <span class="inline-flex items-center space-x-2 bg-brand-500/10 border border-brand-500/20 text-brand-300 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                <i class="hgi-stroke hgi-shield-01 text-xs"></i>
                <span>Secure Clinical Operations Portal</span>
            </span>
            <h1 class="text-5xl sm:text-6xl font-black text-white leading-[1.1] tracking-tight">
                Modern Healthcare<br>
                <span class="text-brand-400">Management System</span>
            </h1>
            <p class="mt-6 text-base text-slate-400 leading-relaxed max-w-2xl mx-auto font-medium">
                A unified platform for admins, clinical staff, and doctors to manage patients, appointments, and consultations — with precision and security.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 bg-brand-600 text-white rounded-xl font-black text-[10px] uppercase tracking-[0.25em] shadow-xl shadow-brand-900 hover:bg-brand-500 transition-all active:scale-95">
                    Login to Portal
                </a>
                <a href="#features" class="w-full sm:w-auto px-8 py-3 bg-white/5 border border-white/10 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    Explore Features
                </a>
            </div>
        </div>

        {{-- Floating stat badges --}}
        <div class="relative max-w-5xl mx-auto px-6 mt-16 grid grid-cols-3 gap-4 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center backdrop-blur">
                <p class="text-3xl font-black text-white">100%</p>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Digitized Records</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center backdrop-blur">
                <i class="hgi-stroke hgi-qr-code-01 text-3xl text-brand-400 mb-1 block"></i>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">QR Check-in</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center backdrop-blur">
                <p class="text-3xl font-black text-white">3</p>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Role-Based Portals</p>
            </div>
        </div>
    </header>

    {{-- ===== FEATURES ===== --}}
    <section id="features" class="py-24 bg-slate-50">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[10px] font-black text-brand-600 uppercase tracking-[0.3em]">Platform Modules</span>
                <h2 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">Built for Every Role</h2>
                <div class="mt-4 h-0.5 w-12 bg-brand-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-8 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-50 transition-all group">
                    <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-brand-600 group-hover:text-white transition-all">
                        <i class="hgi-stroke hgi-manager text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-brand-600 uppercase tracking-widest">Admin Portal</span>
                    <h3 class="text-base font-black text-slate-900 mt-1 mb-3">Central Command</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Oversee all users, manage doctor profiles, configure system settings, and track clinic-wide performance.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-8 hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-50 transition-all group">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="hgi-stroke hgi-user-add-01 text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">Staff Portal</span>
                    <h3 class="text-base font-black text-slate-900 mt-1 mb-3">Front-Desk Operations</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Register new patients, schedule appointments, manage daily check-ins, and coordinate with doctors in real-time.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-8 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-50 transition-all group">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <i class="hgi-stroke hgi-doctor-01 text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Doctor Portal</span>
                    <h3 class="text-base font-black text-slate-900 mt-1 mb-3">Clinical Workspace</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">View scheduled patients, start consultations, write prescriptions, and maintain complete clinical records.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== HOW IT WORKS ===== --}}
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[10px] font-black text-brand-600 uppercase tracking-[0.3em]">Workflow</span>
                <h2 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">Simple Clinical Flow</h2>
                <div class="mt-4 h-0.5 w-12 bg-brand-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['hgi-user-add-01', 'brand', '01', 'Patient Registered', 'Staff creates a patient file with bio-data and medical history.'],
                    ['hgi-calendar-01', 'indigo', '02', 'Appointment Booked', 'A time slot is assigned with the appropriate specialist.'],
                    ['hgi-qr-code-01', 'purple', '03', 'Check-In Confirmed', 'Patient arrives and staff confirms attendance at front desk.'],
                    ['hgi-file-attachment-01', 'emerald', '04', 'Consultation Logged', 'Doctor records symptoms, diagnosis, and prescription digitally.'],
                ] as $step)
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 bg-{{ $step[1] }}-50 text-{{ $step[1] }}-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                        <i class="hgi-stroke {{ $step[0] }} text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Step {{ $step[2] }}</span>
                    <h4 class="text-xs font-black text-slate-900 mb-2">{{ $step[3] }}</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed font-medium">{{ $step[4] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="py-20 bg-gradient-to-r from-brand-600 to-brand-800">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <i class="hgi-stroke hgi-hospital-01 text-5xl text-white/20 mb-6 block"></i>
            <h2 class="text-3xl font-black text-white tracking-tight">Ready to Streamline Your Clinic?</h2>
            <p class="mt-4 text-brand-200 font-medium text-sm">Access your role-based workspace and bring your clinical operations into the digital era.</p>
            <a href="{{ route('login') }}" class="mt-8 inline-flex items-center space-x-2 px-10 py-3.5 bg-white text-brand-700 rounded-xl font-black text-[10px] uppercase tracking-[0.25em] hover:bg-brand-50 transition-all shadow-xl shadow-brand-900/30 active:scale-95">
                <i class="hgi-stroke hgi-login-02 text-sm"></i>
                <span>Go to Login Portal</span>
            </a>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="py-10 bg-slate-950 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-2.5">
                <div class="w-7 h-7 bg-brand-600/20 rounded-lg flex items-center justify-center">
                    <i class="hgi-stroke hgi-hospital-01 text-brand-400 text-xs"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ config('app.name') }}</span>
            </div>
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">&copy; {{ date('Y') }} Clinical Portal. All rights reserved.</p>
        </div>
    </footer>

</div>
@endsection
