<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Admin users can perform all payment actions.
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
     * Determine whether the user can view any payments.
     */
    public function viewAny(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return in_array($role, ['doctor', 'patient'], true);
    }

    /**
     * Determine whether the user can view a payment.
     */
    public function view(User $user, Payment $payment): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'patient') {
            return $payment->patient_id === $user->patient?->id;
        }

        if ($role === 'doctor') {
            return $payment->appointment?->doctor_id ===
                $user->doctor?->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create a payment.
     */
    public function create(User $user): bool
    {
        $role = strtolower(trim($user->role?->name ?? ''));

        return $role === 'patient';
    }

    /**
     * Determine whether the user can update a payment.
     */
    public function update(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete a payment.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore a payment.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete a payment.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return false;
    }
}
