<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

// Public ticket PDF — accessed via unguessable qr_token (UUID), no login required
Route::get('/ticket/{token}', [\App\Http\Controllers\StaffAppointmentController::class , 'publicTicketPdf'])
    ->name('appointments.public.ticket.pdf');

// Auth routes
Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class , 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class , 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class , 'sendResetLinkEmail'])->name('password.email');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class , 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\AdminProfileController::class , 'show'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\AdminProfileController::class , 'update'])->name('profile.update');

    Route::resource('users', \App\Http\Controllers\AdminUserController::class);
    Route::resource('patients', \App\Http\Controllers\AdminPatientController::class);
    Route::resource('appointments', \App\Http\Controllers\AdminAppointmentController::class);

    // Settings
    Route::get('settings', [\App\Http\Controllers\AdminSettingController::class , 'index'])->name('settings');
    Route::post('settings', [\App\Http\Controllers\AdminSettingController::class , 'update'])->name('settings.update');

    // Audit Logs
    Route::get('audit-logs', [\App\Http\Controllers\AdminAuditLogController::class , 'index'])->name('audit-logs.index');
    Route::get('audit-logs/{auditLog}', [\App\Http\Controllers\AdminAuditLogController::class , 'show'])->name('audit-logs.show');

    // Doctors
    Route::resource('doctors', \App\Http\Controllers\AdminDoctorController::class)->parameters(['doctors' => 'doctor']);
});

// Doctor routes
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/', [\App\Http\Controllers\DoctorController::class , 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\DoctorProfileController::class , 'show'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\DoctorProfileController::class , 'update'])->name('profile.update');

    // My Patients
    Route::get('patients', [\App\Http\Controllers\DoctorPatientController::class , 'index'])->name('patients.index');
    Route::get('patients/{patient}', [\App\Http\Controllers\DoctorPatientController::class , 'show'])->name('patients.show');

    // Consultations
    Route::get('consultations', [\App\Http\Controllers\DoctorConsultationController::class , 'index'])->name('consultations.index');
    Route::get('consultations/create/{appointment?}', [\App\Http\Controllers\DoctorConsultationController::class , 'create'])->name('consultations.create');
    Route::post('consultations', [\App\Http\Controllers\DoctorConsultationController::class , 'store'])->name('consultations.store');
    Route::get('consultations/{consultation}', [\App\Http\Controllers\DoctorConsultationController::class , 'show'])->name('consultations.show');

    // My Schedule
    Route::get('schedule', [\App\Http\Controllers\DoctorScheduleController::class , 'index'])->name('schedule');
});

// Shared notification routes (all authenticated roles)
Route::middleware(['auth'])->group(function () {
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class , 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class , 'markAllAsRead'])->name('notifications.readAll');

    // Force password change (all roles)
    Route::post('/password/change', [\App\Http\Controllers\PasswordChangeController::class , 'update'])->name('password.change');
});

// Admin-only password management for users
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\AdminUserController::class , 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-password-change', [\App\Http\Controllers\AdminUserController::class , 'togglePasswordChange'])->name('users.toggle-password-change');
    Route::post('users/{user}/toggle-expiry-exempt', [\App\Http\Controllers\AdminUserController::class , 'toggleExpiryExempt'])->name('users.toggle-expiry-exempt');
    Route::post('users/{user}/unlock-account', [\App\Http\Controllers\AdminUserController::class , 'unlockAccount'])->name('users.unlock-account');
});

// Staff routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/', [\App\Http\Controllers\StaffController::class , 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\StaffProfileController::class , 'show'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\StaffProfileController::class , 'update'])->name('profile.update');

    // Patient management for staff
    Route::get('patients', [\App\Http\Controllers\StaffPatientController::class , 'index'])->name('patients.index');
    Route::get('patients/create', [\App\Http\Controllers\StaffPatientController::class , 'create'])->name('patients.create');
    Route::post('patients', [\App\Http\Controllers\StaffPatientController::class , 'store'])->name('patients.store');
    Route::get('patients/{patient}', [\App\Http\Controllers\StaffPatientController::class , 'show'])->name('patients.show');

    // Appointment management for staff
    Route::get('appointments', [\App\Http\Controllers\StaffAppointmentController::class , 'index'])->name('appointments.index');
    Route::get('appointments/create', [\App\Http\Controllers\StaffAppointmentController::class , 'create'])->name('appointments.create');
    Route::post('appointments', [\App\Http\Controllers\StaffAppointmentController::class , 'store'])->name('appointments.store');

    // Check-in (as requested in navigation)
    Route::get('checkin', [\App\Http\Controllers\StaffAppointmentController::class , 'checkin'])->name('checkin');
    Route::post('appointments/{appointment}/confirm', [\App\Http\Controllers\StaffAppointmentController::class , 'confirmArrival'])->name('appointments.confirm');
    Route::get('appointments/{appointment}/ticket', [\App\Http\Controllers\StaffAppointmentController::class , 'ticket'])->name('appointments.ticket');
    Route::get('appointments/{appointment}/ticket/pdf', [\App\Http\Controllers\StaffAppointmentController::class , 'ticketPdf'])->name('appointments.ticket.pdf');
    Route::get('appointments/{appointment}/whatsapp', [\App\Http\Controllers\StaffAppointmentController::class , 'whatsapp'])->name('appointments.whatsapp');
    Route::post('checkin/scan', [\App\Http\Controllers\StaffAppointmentController::class , 'scanQr'])->name('checkin.scan');

    // Doctor Schedule with list of appointments (staff side)
    Route::get('doctor-schedules', [\App\Http\Controllers\StaffAppointmentController::class , 'doctorSchedules'])->name('doctor-schedules');
});