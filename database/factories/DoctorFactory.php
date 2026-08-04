<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Department;
use App\Models\Specialty;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->doctor(),
            'department_id' => Department::inRandomOrder()->first()->id,
            'specialty_id' => Specialty::inRandomOrder()->first()->id,
            'medical_license' => fake()->unique()->numberBetween(10000, 99999),
            'experience_year' => fake()->numberBetween(1, 30),
            'consultation_fee' => fake()->numberBetween(100000, 1000000),
        ];
    }
}
