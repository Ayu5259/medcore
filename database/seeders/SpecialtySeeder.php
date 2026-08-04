<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Specialty::create([
            'name' => 'Cardiology'
        ]);

        Specialty::create([
            'name' => 'Neurology'
        ]);

        Specialty::create([
            'name' => 'Orthopedics'
        ]);

        Specialty::create([
            'name' => 'Pediatrics'
        ]);

        Specialty::create([
            'name' => 'General Surgery'
        ]);
    }
}
