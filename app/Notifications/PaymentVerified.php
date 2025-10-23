<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentVerified extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Payment Verified!',
            'message' => "Your payment for {$this->payment->course->title} has been verified. You can now access the course!",
            'payment_id' => $this->payment->id,
            'course_id' => $this->payment->course_id,
            'course_slug' => $this->payment->course->slug,
        ];
    }
}