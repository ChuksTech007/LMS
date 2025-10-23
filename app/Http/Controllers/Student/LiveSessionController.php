<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LiveSessionController extends Controller
{
    /**
     * Handles the student's click to join the class via Jitsi Meet.
     */
    public function join(LiveSession $liveSession)
    {
        $user = auth()->user();
        $course = $liveSession->course;
        
        // 1. Enrollment Check: Ensure the student is enrolled in the course.
        if (!$course->students()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You must be enrolled in this course to join the live session.');
        }

        // 2. Time Check: Available from 10 minutes before start up to the end time.
        $isAvailable = $liveSession->start_time->subMinutes(10)->isPast() && 
                       $liveSession->start_time->addMinutes($liveSession->duration_minutes)->isFuture();

        if (!$isAvailable) {
            return redirect()->back()->with('error', 'This live session is either not yet started or has already ended.');
        }

        // 3. Generate the Jitsi Join URL
        try {
            // Use the stored unique ID from the database to ensure all users join the same room.
            $roomName = $this->generateJitsiRoomName($liveSession);
            
            // Student joins MUTED (passing true for $startMuted)
            $joinUrl = $this->generateJitsiUrl(
                $roomName, 
                $user->name, 
                $user->email, 
                true // Student joins muted
            );
            
            if ($joinUrl) {
                return redirect()->away($joinUrl); // Redirect to the external Jitsi link
            }
        } catch (\Exception $e) {
            // Jitsi URL generation is usually safe, but good to keep a catch block.
            Log::error('Student failed to generate Jitsi join URL.', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'A connection error occurred. Please try again.');
        }

        return redirect()->back()->with('error', 'Could not generate Jitsi Meet join link.');
    }

    /**
     * Generates a unique room name for Jitsi based on the LiveSession model.
     * @param LiveSession $liveSession
     * @return string
     */
    protected function generateJitsiRoomName(LiveSession $liveSession): string
    {
        // Use the stored unique ID from the database, which was set in the Instructor's store method.
        // This ensures the student and instructor land in the same meeting room.
        return $liveSession->bbb_meeting_id;
    }

    /**
     * Constructs the full Jitsi Meet URL with user details and configuration.
     * @param string $roomName
     * @param string $userName
     * @param string $userEmail
     * @param bool $startMuted Default is TRUE (muted) for safety.
     * @return string
     */
    protected function generateJitsiUrl(string $roomName, string $userName, string $userEmail, bool $startMuted = true): string
    {
        // Get the base URL from config (defined in .env as MEET_SERVER_URL)
        $baseUrl = config('app.meet_server_url', 'https://meet.jit.si/');
        
        // Configuration parameters for Jitsi
        $params = [
            'config.startWithAudioMuted' => $startMuted ? 'true' : 'false',
            'userInfo.displayName' => $userName,
            'userInfo.email' => $userEmail,
        ];

        return rtrim($baseUrl, '/') . '/' . $roomName . '?' . http_build_query($params);
    }
}
