<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [

            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'national_code' => fake()->unique()->numerify('##########'),

            'gender' => fake()->randomElement([
                'Male',
                'Female',
                'NonBinary',
            ]),

            'birth_date' => fake()->date(),

            'phone' => fake()->numerify('09#########'),

            'country' => 'Iran',
            'province' => fake()->state(),
            'city' => fake()->city(),
            'street' => fake()->streetName(),

            'alley' => fake()->optional()->word(),
            'plaque' => fake()->optional()->numberBetween(1, 100),
            'unit' => fake()->optional()->numberBetween(1, 20),

            'postal_code' => fake()->optional()->numerify('##########'),

            'email' => fake()->unique()->safeEmail(),

            'password' => Hash::make('password'),

            'remember_token' => Str::random(10),

            'is_active' => true,
        ];
    }
    public function doctor(): static
    {
        return $this->state([
            'role_id' => Role::where('name', 'Doctor')->first()->id
        ]);
    }


    public function patient(): static
    {
        return $this->state([
            'role_id' => 3,
        ]);
    }


    public function nurse(): static
    {
        return $this->state([
            'role_id' => 4,
        ]);
    }
}
