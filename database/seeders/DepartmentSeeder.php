<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Cardiology'
        ]);

        Department::create([
            'name' => 'Neurology'
        ]);

        Department::create([
            'name' => 'Orthopedics'
        ]);

        Department::create([
            'name' => 'Internal Medicine'
        ]);

        Department::create([
            'name' => 'Pediatrics'
        ]);
    }
}
