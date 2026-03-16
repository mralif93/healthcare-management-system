<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => 'P-' . fake()->unique()->numerify('#####'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date('Y-m-d', '-10 years'),
            'gender' => fake()->randomElement(['male', 'female']),
            'blood_group' => fake()->randomElement(['A+', 'B+', 'O+', 'AB+']),
            'status' => 'active',
        ];
    }
}
