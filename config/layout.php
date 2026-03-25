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
            // Overview
            ['group' => 'Overview', 'name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'admin.dashboard'],
            // User Management
            ['group' => 'Users Management', 'name' => 'Users', 'icon' => 'hgi-manager', 'route' => 'admin.users.index'],
            ['group' => 'Users Management', 'name' => 'Patients', 'icon' => 'hgi-user-group', 'route' => 'admin.patients.index'],
            ['group' => 'Users Management', 'name' => 'Doctors', 'icon' => 'hgi-user-multiple', 'route' => 'admin.doctors.index'],
            // Appointments
            ['group' => 'Appointments', 'name' => 'Appointments', 'icon' => 'hgi-calendar-01', 'route' => 'admin.appointments.index'],
            // System
            ['group' => 'System', 'name' => 'Settings',   'icon' => 'hgi-settings-01',  'route' => 'admin.settings'],
            ['group' => 'System', 'name' => 'Audit Logs', 'icon' => 'hgi-activity-01',  'route' => 'admin.audit-logs.index'],
        ],
        'doctor' => [
            // Overview
            ['group' => 'Overview', 'name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'doctor.dashboard'],
            // Patients
            ['group' => 'Patients', 'name' => 'Patients', 'icon' => 'hgi-user-group', 'route' => 'doctor.patients.index'],
            // Consultations
            ['group' => 'Consultations', 'name' => 'All Records', 'icon' => 'hgi-stethoscope', 'route' => 'doctor.consultations.index'],
            // Schedule
            ['group' => 'Schedule', 'name' => 'My Schedule', 'icon' => 'hgi-calendar-01', 'route' => 'doctor.schedule'],
        ],
        'staff' => [
            // Overview
            ['group' => 'Overview', 'name' => 'Dashboard', 'icon' => 'hgi-home-01', 'route' => 'staff.dashboard'],
            // Patient Management
            ['group' => 'Patients', 'name' => 'Patients', 'icon' => 'hgi-user-group', 'route' => 'staff.patients.index'],
            // Appointments
            ['group' => 'Appointments', 'name' => 'Appointments', 'icon' => 'hgi-calendar-01', 'route' => 'staff.appointments.index'],
            ['group' => 'Appointments', 'name' => 'Check-in', 'icon' => 'hgi-qr-code-01', 'route' => 'staff.checkin'],
            // Schedules
            ['group' => 'Schedules', 'name' => 'Doctor Schedules', 'icon' => 'hgi-doctor-01', 'route' => 'staff.doctor-schedules'],
        ],
    ],
];
