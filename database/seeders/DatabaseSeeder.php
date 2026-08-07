<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            SpecialtySeeder::class,
            MedicineSeeder::class,
        ]);

        Doctor::factory(10)->create();
        Patient::factory(20)->create();
        MedicalRecord::factory(20)->create();
        Nurse::factory(10)->create();
        DoctorSchedule::factory(30)->create();
        Appointment::factory(50)->create();
        Payment::factory(50)->create();

        Appointment::all()->each(function ($appointment) {

            Prescription::factory()->create([
                'appointment_id' => $appointment->id
            ]);
        });
        Prescription::all()->each(function ($prescription) {

            PrescriptionItem::factory(3)->create([
                'prescription_id' => $prescription->id
            ]);
        });
    }
}
