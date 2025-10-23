<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine if the user can view the payment.
     */
    public function view(User $user, Payment $payment): bool
    {
        // User can view their own payment
        // Admin can view all payments
        // Instructor can view payments for their courses
        return $user->id === $payment->user_id 
            || $user->role->value === 'admin'
            || ($user->role->value === 'instructor' && $payment->course->user_id === $user->id);
    }

    /**
     * Determine if the user can verify payments.
     */
    public function verify(User $user, Payment $payment): bool
    {
        // Admin can verify all payments
        // Instructor can verify payments for their own courses
        return $user->role->value === 'admin'
            || ($user->role->value === 'instructor' && $payment->course->user_id === $user->id);
    }
}