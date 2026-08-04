<?php

namespace Database\Factories;

use App\Models\Nurse;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseFactory extends Factory
{
    protected $model = Nurse::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->nurse(),

            'department_id' => Department::inRandomOrder()->first()->id,

            'employee_number' => fake()
                ->unique()
                ->bothify('EMP-#####'),

            'years_of_experience' => fake()
                ->numberBetween(1, 30),

            'nursing_license_number' => fake()
                ->unique()
                ->bothify('NUR-######'),

            'employment_date' => fake()->date(),

            'shift' => fake()->randomElement([
                'صبح',
                'عصر',
                'شب',
                'لانگ',
            ]),
        ];
    }
}
