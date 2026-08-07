<?php

namespace Database\Factories;

use App\Models\Prescription;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),

        ];
    }
}
