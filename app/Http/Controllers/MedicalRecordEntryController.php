<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecordEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MedicalRecordEntryController extends Controller
{
    /**
     * Display a specific medical record entry.
     */
    public function show(MedicalRecordEntry $medicalRecordEntry)
    {
        Gate::authorize('view', $medicalRecordEntry);

        $medicalRecordEntry->load([
            'doctor.user',
            'appointment',
            'medicalRecord.patient',
        ]);

        return view(
            'medical_record_entries.show',
            compact('medicalRecordEntry')
        );
    }

    /**
     * Show the form for creating a new medical record entry.
     */
    public function create()
    {
        Gate::authorize('create', MedicalRecordEntry::class);

        $doctor = Auth::user()?->doctor;

        if (!$doctor) {
            abort(403);
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDoesntHave('medicalRecordEntry')
            ->with('patient')
            ->get();

        return view(
            'medical_record_entries.create',
            compact('appointments')
        );
    }

    /**
     * Store a newly created medical record entry.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', MedicalRecordEntry::class);

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'diagnosis'      => ['required', 'string'],
            'treatment'      => ['nullable', 'string'],
            'notes'          => ['nullable', 'string'],
        ]);

        $doctor = Auth::user()?->doctor;

        if (!$doctor) {
            abort(403);
        }

        /*
         * The appointment must belong to the authenticated doctor.
         */
        $appointment = Appointment::where('id', $validated['appointment_id'])
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        /*
         * The appointment must have a medical record.
         */
        $medicalRecord = $appointment->medicalRecord;

        if (!$medicalRecord) {
            abort(404, 'Medical record not found.');
        }

        /*
         * The medical record must belong to the same patient
         * as the appointment.
         */
        if ($medicalRecord->patient_id !== $appointment->patient_id) {
            abort(403, 'Medical record does not belong to this patient.');
        }

        /*
         * Prevent creating multiple entries for the same appointment.
         */
        if (
            MedicalRecordEntry::where(
                'appointment_id',
                $appointment->id
            )->exists()
        ) {
            abort(
                409,
                'A medical record entry already exists for this appointment.'
            );
        }

        $medicalRecordEntry = MedicalRecordEntry::create([
            'medical_record_id' => $medicalRecord->id,
            'appointment_id'    => $appointment->id,
            'doctor_id'        => $doctor->id,
            'diagnosis'        => $validated['diagnosis'],
            'treatment'        => $validated['treatment'] ?? null,
            'notes'            => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'medical-record-entries.show',
                $medicalRecordEntry
            )
            ->with(
                'success',
                'Medical record entry created successfully.'
            );
    }

    /**
     * Show the form for editing a medical record entry.
     */
    public function edit(MedicalRecordEntry $medicalRecordEntry)
    {
        Gate::authorize('update', $medicalRecordEntry);

        return view(
            'medical_record_entries.edit',
            compact('medicalRecordEntry')
        );
    }

    /**
     * Update a medical record entry.
     */
    public function update(
        Request $request,
        MedicalRecordEntry $medicalRecordEntry
    ) {
        Gate::authorize('update', $medicalRecordEntry);

        $validated = $request->validate([
            'diagnosis' => ['required', 'string'],
            'treatment' => ['nullable', 'string'],
            'notes'     => ['nullable', 'string'],
        ]);

        $medicalRecordEntry->update([
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'] ?? null,
            'notes'     => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'medical-record-entries.show',
                $medicalRecordEntry
            )
            ->with(
                'success',
                'Medical record entry updated successfully.'
            );
    }
}
