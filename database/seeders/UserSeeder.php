<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'staff_id' => 'ADM001',
            'role' => 'admin',
            'phone' => '0123456789',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Create Doctor
        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'doctor@example.com',
            'staff_id' => 'DOC001',
            'role' => 'doctor',
            'specialization' => 'Cardiology',
            'phone' => '0123456788',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Create Staff
        User::create([
            'name' => 'Nurse Jane Smith',
            'email' => 'staff@example.com',
            'staff_id' => 'STF001',
            'role' => 'staff',
            'phone' => '0123456787',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);
    }
}