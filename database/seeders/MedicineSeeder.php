<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $medicines = [
            [
                'name' => 'Acetaminophen',
                'generic_name' => 'Paracetamol',
                'manufacturer' => 'Teva',
                'dosage_form' => 'Tablet',
                'description' => 'Pain reliever and fever reducer',
            ],
            [
                'name' => 'Ibuprofen',
                'generic_name' => 'Ibuprofen',
                'manufacturer' => 'Abbott',
                'dosage_form' => 'Capsule',
                'description' => 'Anti-inflammatory medicine',
            ],
            [
                'name' => 'Amoxicillin',
                'generic_name' => 'Amoxicillin',
                'manufacturer' => 'Pfizer',
                'dosage_form' => 'Capsule',
                'description' => 'Antibiotic',
            ],
            [
                'name' => 'Azithromycin',
                'generic_name' => 'Azithromycin',
                'manufacturer' => 'Pfizer',
                'dosage_form' => 'Tablet',
                'description' => 'Macrolide antibiotic',
            ],
            [
                'name' => 'Metformin',
                'generic_name' => 'Metformin',
                'manufacturer' => 'Merck',
                'dosage_form' => 'Tablet',
                'description' => 'Diabetes medication',
            ],
            [
                'name' => 'Cetirizine',
                'generic_name' => 'Cetirizine',
                'manufacturer' => 'Johnson & Johnson',
                'dosage_form' => 'Tablet',
                'description' => 'Antihistamine',
            ],
            [
                'name' => 'Vitamin D3',
                'generic_name' => 'Cholecalciferol',
                'manufacturer' => 'Nature Made',
                'dosage_form' => 'Capsule',
                'description' => 'Vitamin supplement',
            ],
            [
                'name' => 'Omeprazole',
                'generic_name' => 'Omeprazole',
                'manufacturer' => 'AstraZeneca',
                'dosage_form' => 'Capsule',
                'description' => 'Reduces stomach acid',
            ],

        ];
        Medicine::insert($medicines);
    }
}
