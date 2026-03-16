<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Layout Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for managing your application's layout settings, including
    | branding, metadata, and role-based navigation.
    |
    */

    'app_name' => env('APP_NAME', 'Healthcare MS'),

    'branding' => [
        'logo_path' => '/assets/logo.png',
        'favicon' => '/favicon.ico',
        'theme_color' => '#3b82f6', // Primary Blue
    ],

    'meta' => [
        'description' => 'Robust Healthcare Management System for clinic efficiency.',
        'keywords' => 'healthcare, management, clinic, medical, qr-checkin',
        'author' => 'Healthcare Team',
    ],

    'navigation' => [
        'admin' => [
            ['name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'admin.dashboard'],
            ['name' => 'Patients', 'icon' => 'hgi-user-group', 'route' => 'admin.patients.index'],
            ['name' => 'Staff', 'icon' => 'hgi-manager', 'route' => 'admin.staff.index'],
            ['name' => 'Doctors', 'icon' => 'hgi-doctor-01', 'route' => 'admin.doctors.index'],
            ['name' => 'Appointments', 'icon' => 'hgi-calendar-01', 'route' => 'admin.appointments.index'],
            ['name' => 'Settings', 'icon' => 'hgi-settings-01', 'route' => 'admin.settings'],
        ],
        'doctor' => [
            ['name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'doctor.dashboard'],
            ['name' => 'My Patients', 'icon' => 'hgi-user-group', 'route' => 'doctor.patients.index'],
            ['name' => 'Consultations', 'icon' => 'hgi-stethoscope', 'route' => 'doctor.consultations.index'],
            ['name' => 'Schedule', 'icon' => 'hgi-calendar-01', 'route' => 'doctor.schedule'],
        ],
        'staff' => [
            ['name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'staff.dashboard'],
            ['name' => 'Registration', 'icon' => 'hgi-user-add-01', 'route' => 'staff.patients.create'],
            ['name' => 'Bookings', 'icon' => 'hgi-calendar-add-01', 'route' => 'staff.appointments.create'],
            ['name' => 'Check-in', 'icon' => 'hgi-qr-code-01', 'route' => 'staff.checkin'],
        ],
    ],
];
