<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $appointment = Appointment::inRandomOrder()->first();

        return [
            'patient_id' => $appointment->patient_id,

            'appointment_id' => $appointment->id,

            'amount' => fake()->numberBetween(100000, 1000000),

            'method' => fake()->randomElement([
                'cash',
                'card',
                'insurance',
                'credit',
            ]),

            'status' => fake()->randomElement([
                'pending',
                'paid',
                'failed',
                'refunded',
            ]),

            'paid_at' => fake()->optional()->dateTime(),

            'transaction_code' => fake()->optional()->numerify('##########'),

            'payment_gateway' => fake()->optional()->randomElement([
                'Mellat',
                'Saman',
                'ZarinPal',
            ]),
        ];
    }
}
