<?php

namespace App\Policies;

use App\Models\MedicalRecordEntry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicalRecordEntryPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'admin') {
            return true;
        }

        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
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
            return $medicalRecordEntry->medicalRecord
                ->appointments()
                ->where('doctor_id', $user->doctor?->id)
                ->exists();
        }

        return false;
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return $role === 'doctor';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role !== 'doctor') {
            return false;
        }

        return $medicalRecordEntry->doctor_id === $user->doctor?->id;
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        MedicalRecordEntry $medicalRecordEntry
    ): bool {
        return false;
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MedicalRecordEntry $medicalRecordEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedicalRecordEntry $medicalRecordEntry): bool
    {
        return false;
    }
}
