<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => 'APT-' . fake()->unique()->numerify('#####'),
            'patient_id' => Patient::factory(),
            'doctor_id' => User::factory()->state(['role' => 'doctor']),
            'appointment_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'appointment_time' => fake()->time('H:i'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'notes' => fake()->paragraph(),
        ];
    }
}
