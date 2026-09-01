<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use App\Models\VisitReport;

class VisitReportPolicy
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
     * Determine whether the user may create a visit report
     * for the given appointment.
     */
    public function create(User $user, Appointment $appointment): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role !== 'doctor') {
            return false;
        }

        return $user->doctor?->id === $appointment->doctor_id;
    }

    /**
     * Determine whether the user may view the visit report.
     */
    public function view(User $user, VisitReport $visitReport): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'patient') {
            return $user->patient?->id ===
                $visitReport->appointment?->patient_id;
        }

        if ($role === 'doctor') {
            return $user->doctor?->id ===
                $visitReport->appointment?->doctor_id;
        }

        return false;
    }

    /**
     * Determine whether the user may update the visit report.
     */
    public function update(User $user, VisitReport $visitReport): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role !== 'doctor') {
            return false;
        }

        return $user->doctor?->id ===
            $visitReport->appointment?->doctor_id;
    }
}
