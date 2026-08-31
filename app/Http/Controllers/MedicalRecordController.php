<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Gate;

class MedicalRecordController extends Controller
{
    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        Gate::authorize('view', $medicalRecord);

        $medicalRecord->load([
            'patient',
            'entries.doctor',
            'entries.appointment',
        ]);

        return view('medical_records.show', compact('medicalRecord'));
    }
}
