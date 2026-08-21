<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Perform authorization checks before the requested policy method.
     *
     * Admin users are allowed to perform all appointment actions.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Allow Admin users to bypass the individual policy checks.
        if ($role === 'admin') {
            // Grant authorization to the Admin.
            return true;
        }

        // Return null so Laravel continues to the requested policy method.
        return null;
    }


    /**
     * Determine whether the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Allow Doctors, Nurses, and Patients to access appointment lists.
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
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Deny access when the user has no valid role.
        if ($role === null) {
            // Stop the authorization check immediately.
            return false;
        }

        // Check whether the authenticated user is a Doctor.
        if ($role === 'doctor') {

            // Make sure the Doctor profile exists.
            if (!$user->doctor) {
                // Deny access when the Doctor profile does not exist.
                return false;
            }

            // Allow the Doctor to view only their own appointments.
            return $user->doctor->id === $appointment->doctor_id;
        }

        // Check whether the authenticated user is a Patient.
        if ($role === 'patient') {

            // Make sure the Patient profile exists.
            if (!$user->patient) {
                // Deny access when the Patient profile does not exist.
                return false;
            }

            // Allow the Patient to view only their own appointments.
            return $user->patient->id === $appointment->patient_id;
        }

        // Nurses are not authorized to view individual appointments for now.
        return false;
    }


    /**
     * Determine whether the user can create an appointment.
     */
    public function create(User $user): bool
    {
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Allow Admin, Doctor, and Patient users to create appointments.
        return in_array(
            $role,
            ['doctor', 'patient'],
            true
        );
    }


    /**
     * Determine whether the user can update a specific appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Deny access when the user has no valid role.
        if ($role === null) {
            // Stop the authorization check immediately.
            return false;
        }

        // Check whether the authenticated user is a Doctor.
        if ($role === 'doctor') {

            // Make sure the Doctor profile exists.
            if (!$user->doctor) {
                // Deny access when the Doctor profile does not exist.
                return false;
            }

            // Allow the Doctor to update only their own appointments.
            return $user->doctor->id === $appointment->doctor_id;
        }

        // Check whether the authenticated user is a Patient.
        if ($role === 'patient') {

            // Make sure the Patient profile exists.
            if (!$user->patient) {
                // Deny access when the Patient profile does not exist.
                return false;
            }

            // Allow the Patient to update only their own appointments.
            return $user->patient->id === $appointment->patient_id;
        }

        // Nurses are not authorized to update appointments for now.
        return false;
    }


    /**
     * Determine whether the user can cancel a specific appointment.
     */
    public function cancel(User $user, Appointment $appointment): bool
    {
        // Get the normalized role name of the authenticated user.
        $role = $this->roleName($user);

        // Deny access when the user has no valid role.
        if ($role === null) {
            // Stop the authorization check immediately.
            return false;
        }

        // Prevent an appointment from being cancelled more than once.
        if ($appointment->status === 'cancelled') {
            // The appointment is already cancelled.
            return false;
        }

        // Prevent completed appointments from being cancelled.
        if ($appointment->status === 'completed') {
            // Completed appointments must remain in the medical history.
            return false;
        }

        // Check whether the authenticated user is a Doctor.
        if ($role === 'doctor') {

            // Make sure the Doctor profile exists.
            if (!$user->doctor) {
                // Deny access when the Doctor profile does not exist.
                return false;
            }

            // Allow the Doctor to cancel only their own appointments.
            return $user->doctor->id === $appointment->doctor_id;
        }

        // Check whether the authenticated user is a Patient.
        if ($role === 'patient') {

            // Make sure the Patient profile exists.
            if (!$user->patient) {
                // Deny access when the Patient profile does not exist.
                return false;
            }

            // Allow the Patient to cancel only their own appointments.
            return $user->patient->id === $appointment->patient_id;
        }

        // Nurses are not authorized to cancel appointments for now.
        return false;
    }


    /**
     * Get the normalized role name of the given user.
     */
    private function roleName(User $user): ?string
    {
        // Check whether the user has a role assigned.
        if (!$user->role) {
            // Return null when no role is assigned.
            return null;
        }

        // Return the role name in lowercase for consistent comparisons.
        return strtolower($user->role->name);
    }
}
