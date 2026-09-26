<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of medical records.
     */
    public function index()
    {
        Gate::authorize('viewAny', MedicalRecord::class);

        $user = Auth::user();
        $query = MedicalRecord::with([
            'patient.user',
        ]);


        $role = strtolower(trim($user->role?->name ?? ''));


        if ($role === 'patient') {

            $patient = $user->patient;

            if (!$patient) {
                abort(403);
            }

            $query->where(
                'patient_id',
                $patient->id
            );
        } elseif ($role === 'doctor') {

            $doctor = $user->doctor;

            if (!$doctor) {
                abort(403);
            }

            $query->whereHas(
                'appointments',
                function ($q) use ($doctor) {

                    $q->where(
                        'doctor_id',
                        $doctor->id
                    );
                }
            );
        }


        $medicalRecords = $query
            ->latest()
            ->get();


        return view(
            'medical_records.index',
            compact('medicalRecords')
        );
    }
    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        Gate::authorize('view', $medicalRecord);

        $medicalRecord->load([
            'patient.user',
            'entries.doctor.user',
            'entries.appointment',
        ]);

        return view(
            'medical_records.show',
            compact('medicalRecord')
        );
    }
}
