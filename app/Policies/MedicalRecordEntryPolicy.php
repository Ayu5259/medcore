<?php

namespace App\Policies;

use App\Models\MedicalRecordEntry;
use App\Models\User;

class MedicalRecordEntryPolicy
{
    /**
     * Admin bypasses all policy checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'admin') {
            return true;
        }

        return null;
    }

    /**
     * General listing is not allowed.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Patients can view their own history.
     *
     * Doctors can view the complete medical history
     * of a patient if they have an appointment with that patient.
     */
    public function view(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'patient') {
            return $user->patient?->id ===
                $medicalRecordEntry->medicalRecord?->patient_id;
        }

        if ($role === 'doctor') {
            $medicalRecord = $medicalRecordEntry->medicalRecord;

            if (!$medicalRecord) {
                return false;
            }

            return $medicalRecord->appointments()
                ->where('doctor_id', $user->doctor?->id)
                ->exists();
        }

        return false;
    }

    /**
     * Only doctors can create medical record entries.
     *
     * The controller validates that the appointment,
     * doctor and medical record are correctly related.
     */
    public function create(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return $role === 'doctor';
    }

    /**
     * Doctors can update only entries created by themselves.
     */
    public function update(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role !== 'doctor') {
            return false;
        }

        return $medicalRecordEntry->doctor_id ===
            $user->doctor?->id;
    }

    /**
     * Medical history cannot be deleted.
     */
    public function delete(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        return false;
    }

    /**
     * Soft delete is not used for MedicalRecordEntry.
     */
    public function restore(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        return false;
    }

    /**
     * Permanent deletion is not allowed.
     */
    public function forceDelete(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        return false;
    }
}
