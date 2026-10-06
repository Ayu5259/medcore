<?php

namespace App\Policies;

use App\Models\DoctorSchedule;
use App\Models\User;

class DoctorSchedulePolicy
{
    /**
     * Determine whether the user can view schedules.
     */
    public function viewAny(User $user): bool
    {
        return $user->doctor !== null
            || $user->patient !== null;
    }

    /**
     * Determine whether the user can view a schedule.
     */
    public function view(User $user, DoctorSchedule $doctorSchedule): bool
    {
        // Doctor can view their own schedule.
        if ($user->doctor) {
            return $doctorSchedule->doctor_id === $user->doctor->id;
        }

        // Patient can view doctors' schedules.
        if ($user->patient) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create a schedule.
     */
    public function create(User $user): bool
    {
        return $user->doctor !== null;
    }

    /**
     * Determine whether the user can update a schedule.
     */
    public function update(User $user, DoctorSchedule $doctorSchedule): bool
    {
        return $user->doctor !== null
            && $doctorSchedule->doctor_id === $user->doctor->id;
    }

    /**
     * Determine whether the user can delete a schedule.
     */
    public function delete(User $user, DoctorSchedule $doctorSchedule): bool
    {
        return $user->doctor !== null
            && $doctorSchedule->doctor_id === $user->doctor->id;
    }
}
