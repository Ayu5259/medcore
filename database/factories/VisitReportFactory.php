<?php

namespace Database\Factories;

use App\Models\VisitReport;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;

/**
 * @extends Factory<VisitReport>
 */
class VisitReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'appointment_id' => Appointment::inRandomOrder()->first()->id,

            'diagnosis' => fake()->sentence(),

            'symptoms' => fake()->paragraph(),

            'notes' => fake()->optional()->paragraph(),

            'blood_pressure' => fake()->numberBetween(90, 140)
                . '/'
                . fake()->numberBetween(60, 90),

            'temperature' => fake()->randomFloat(1, 36, 40),

            'heart_rate' => fake()->numberBetween(60, 120),
        ];
    }
}
