<?php

namespace Database\Factories;

use App\Models\PrescriptionItem;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionItemFactory extends Factory
{
    protected $model = PrescriptionItem::class;

    public function definition(): array
    {
        return [
            'prescription_id' => Prescription::inRandomOrder()->first()->id,

            'medicine_id' => Medicine::inRandomOrder()->first()->id,

            'dosage' => fake()->randomElement([
                '1 tablet',
                '2 tablets',
                '5 ml',
                '10 drops',
            ]),

            'duration' => fake()->randomElement([
                '3 days',
                '5 days',
                '1 week',
                '2 weeks',
            ]),

            'frequency' => fake()->randomElement([
                'Once daily',
                'Twice daily',
                'Every 8 hours',
                'Before sleep',
            ]),

            'instructions' => fake()->optional()->sentence(),
        ];
    }
}
