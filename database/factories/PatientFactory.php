<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->patient(),

            'blood_type' => fake()->randomElement([
                'A+',
                'A-',
                'B+',
                'B-',
                'AB+',
                'AB-',
                'O+',
                'O-',
            ]),

            'height' => fake()->numberBetween(140, 210),

            'weight' => fake()->numberBetween(40, 150),

            'emergency_contact_name' => fake()->name(),

            'emergency_contact' => fake()->numerify('09#########'),

            'insurance_number' => fake()
                ->unique()
                ->numberBetween(100000, 999999),
        ];
    }
}
