<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Admin users can perform all appointment actions.
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
     * Determine whether the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        $role = $this->roleName($user);

        return in_array(
            $role,
            ['doctor', 'nurse', 'patient'],
            true
        );
    }


    /**
     * Determine whether the user can view a specific appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        $role = $this->roleName($user);

        if ($role === null) {
            return false;
        }

        if ($role === 'doctor') {
            if (!$user->doctor) {
                return false;
            }

            return $user->doctor->id === $appointment->doctor_id;
        }

        if ($role === 'patient') {
            if (!$user->patient) {
                return false;
            }

            return $user->patient->id === $appointment->patient_id;
        }

        return false;
    }


    /**
     * Determine whether the user can enter the appointment creation flow.
     */
    public function create(User $user): bool
    {
        $role = $this->roleName($user);

        return in_array(
            $role,
            ['doctor', 'patient'],
            true
        );
    }


    /**
     * Determine whether the user can create an appointment
     * for the given patient.
     */
    public function createForPatient(User $user, Patient $patient): bool
    {
        $role = $this->roleName($user);

        // A Patient can create appointments only for themselves.
        if ($role === 'patient') {
            if (!$user->patient) {
                return false;
            }

            return $user->patient->id === $patient->id;
        }

        // A Doctor can create appointments for patients
        // with whom they have an existing appointment.
        if ($role === 'doctor') {
            if (!$user->doctor) {
                return false;
            }

            return $user->doctor->appointments()
                ->where('patient_id', $patient->id)
                ->exists();
        }

        return false;
    }


    /**
     * Determine whether the user can update a specific appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        $role = $this->roleName($user);

        if ($role === null) {
            return false;
        }

        if ($role === 'doctor') {
            if (!$user->doctor) {
                return false;
            }

            return $user->doctor->id === $appointment->doctor_id;
        }

        if ($role === 'patient') {
            if (!$user->patient) {
                return false;
            }

            return $user->patient->id === $appointment->patient_id;
        }

        return false;
    }


    /**
     * Determine whether the user can cancel a specific appointment.
     */
    public function cancel(User $user, Appointment $appointment): bool
    {
        $role = $this->roleName($user);

        if ($role === null) {
            return false;
        }

        if ($appointment->status === 'cancelled') {
            return false;
        }

        if ($appointment->status === 'completed') {
            return false;
        }

        if ($role === 'doctor') {
            if (!$user->doctor) {
                return false;
            }

            return $user->doctor->id === $appointment->doctor_id;
        }

        if ($role === 'patient') {
            if (!$user->patient) {
                return false;
            }

            return $user->patient->id === $appointment->patient_id;
        }

        return false;
    }


    /**
     * Get the normalized role name of the given user.
     */
    private function roleName(User $user): ?string
    {
        if (!$user->role) {
            return null;
        }

        return strtolower($user->role->name);
    }
}
