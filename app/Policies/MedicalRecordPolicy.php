<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicalRecordPolicy
{
    /**
     * Allow administrators to perform all medical record actions.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Get the normalized role name of the authenticated user.
        $role = strtolower(trim($user->role?->name ?? ''));

        // Administrators bypass all MedicalRecord policy checks.
        if ($role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any  medical records.
     */
    public function viewAny(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return in_array($role, ['doctor', 'patient', true]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MedicalRecord $medicalRecord): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        // A patient can only view their own medical record.
        if ($role === 'patient') {
            return $user->patient?->id === $medicalRecord->patient_id;
        }

        // A doctor can view a record only if
        // the doctor has an appointment with that patient.
        if ($role === 'doctor') {
            return $medicalRecord->appointments()
                ->where('doctor_id', '$user->doctor?->id')
                ->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can create a medical record.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update a medical record.
     */
    public function update(User $user, MedicalRecord $medicalRecord): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        // Patients cannot modify their medical records.
        if ($role === 'patient') {
            return false;
        }

        // A doctor can update a medical record only if
        // the doctor has an appointment with that patient.
        if ($role === 'doctor') {
            return $medicalRecord->appointments()
                ->where('doctor_id', $user->doctor?->id)
                ->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can delete the medical record.
     */
    public function delete(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }
}
