<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MedicalRecord;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = Patient::inRandomOrder()->first();

        return [
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'patient_id' => $patient->id,
            'medical_record_id' => $patient->medicalRecord->id,
            'appointment_date' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'appointment_start_time' => '09:00',
            'appointment_end_time' => '09:30',
            'reason' => fake()->sentence(3),
            'room_number' => fake()->numberBetween(101, 120),
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'cancelled',
                'completed',
            ]),
            'visit_type' => fake()->randomElement([
                'InPerson',
                'Online',
                'Emergency',
                'FollowUp',
            ]),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
