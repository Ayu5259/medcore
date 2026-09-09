<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;

class PrescriptionPolicy
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
     * Determine whether the user can view the prescription.
     */
    public function view(
        User $user,
        Prescription $prescription
    ): bool {
        $role = strtolower(trim($user->role?->name ?? ''));

        $appointment = $prescription->appointment;

        if (!$appointment) {
            return false;
        }

        if ($role === 'doctor') {
            return $appointment->doctor_id === $user->doctor?->id;
        }

        if ($role === 'patient') {
            return $appointment->patient_id === $user->patient?->id;
        }

        return false;
    }

    /**
     * Only the doctor of the appointment can create a prescription.
     */
    public function create(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return $role === 'doctor';
    }

    /**
     * Only the doctor who created the prescription
     * can update it.
     */
    public function update(
        User $user,
        Prescription $prescription
    ): bool {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role !== 'doctor') {
            return false;
        }

        return $prescription->appointment?->doctor_id ===
            $user->doctor?->id;
    }

    /**
     * Prescriptions cannot be deleted.
     */
    public function delete(
        User $user,
        Prescription $prescription
    ): bool {
        return false;
    }

    public function restore(
        User $user,
        Prescription $prescription
    ): bool {
        return false;
    }

    public function forceDelete(
        User $user,
        Prescription $prescription
    ): bool {
        return false;
    }
}
