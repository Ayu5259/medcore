<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VisitReport;

class VisitReportPolicy
{
    /**
     * Admin bypasses all policy checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        $role = $this->roleName($user);

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
     * Users can view reports related to their own appointment.
     */
    public function view(User $user, VisitReport $visitReport): bool
    {
        $role = $this->roleName($user);

        if ($role === null || !$visitReport->appointment) {
            return false;
        }

        // Doctor can view reports of their own appointments.
        if ($role === 'doctor') {
            return $user->doctor?->id ===
                $visitReport->appointment->doctor_id;
        }

        // Patient can view reports of their own appointments.
        if ($role === 'patient') {
            return $user->patient?->id ===
                $visitReport->appointment->patient_id;
        }

        return false;
    }

    /**
     * Only doctors can create visit reports.
     *
     * The appointment ownership must be checked separately.
     */
    public function create(User $user): bool
    {
        return $this->roleName($user) === 'doctor';
    }

    /**
     * Doctors can update only reports belonging
     * to their own appointments.
     */
    public function update(User $user, VisitReport $visitReport): bool
    {
        $role = $this->roleName($user);

        if ($role !== 'doctor' || !$visitReport->appointment) {
            return false;
        }

        return $user->doctor?->id ===
            $visitReport->appointment->doctor_id;
    }

    /**
     * Visit reports cannot be deleted.
     */
    public function delete(User $user, VisitReport $visitReport): bool
    {
        return false;
    }

    /**
     * Restore is not allowed.
     */
    public function restore(User $user, VisitReport $visitReport): bool
    {
        return false;
    }

    /**
     * Permanent deletion is not allowed.
     */
    public function forceDelete(User $user, VisitReport $visitReport): bool
    {
        return false;
    }

    /**
     * Get the normalized role name.
     */
    private function roleName(User $user): ?string
    {
        if (!$user->role) {
            return null;
        }

        return strtolower(trim($user->role->name));
    }
}
