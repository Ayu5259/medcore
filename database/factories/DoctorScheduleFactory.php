<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorScheduleFactory extends Factory
{
    protected $model = DoctorSchedule::class;

    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::inRandomOrder()->first()->id,

            'day_of_week' => fake()->randomElement([
                'شنبه',
                'یکشنبه',
                'دوشنبه',
                'سه‌شنبه',
                'چهارشنبه',
                'پنجشنبه',
                'جمعه',
            ]),

            'start_time' => '08:00',

            'end_time' => '12:00',
        ];
    }
}
