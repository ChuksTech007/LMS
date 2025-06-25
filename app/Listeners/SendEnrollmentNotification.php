<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use App\Notifications\NewStudentEnrolled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEnrollmentNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StudentEnrolled $event): void
    {
        // Get the instructor of the course
        $instructor = $event->course->instructor;

        // Send the notification to the instructor
        $instructor->notify(new NewStudentEnrolled($event->course, $event->student));
    }
}
