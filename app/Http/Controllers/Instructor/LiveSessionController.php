<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LiveSessionController extends Controller
{
    /**
     * NOTE: Removed dependency on BigBlueButtonService since Jitsi is URL-based.
     */
    public function __construct()
    {
        // No dependency injection needed for Jitsi
    }

    // Shows a list of all scheduled live sessions
    public function index()
    {
        $courses = auth()->user()->courses()->with('liveSessions')->get();
        return view('pages.instructor.live_sessions.index', compact('courses'));
    }

    // Shows the form to create a new session for a specific course
    public function create(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        return view('pages.instructor.live_sessions.create_edit', compact('course'));
    }

    // Saves the new session. No external API call is needed for Jitsi.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:10|max:180',
            'start_time' => 'required|date',
        ]);

        $course = Course::findOrFail($validatedData['course_id']);
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // --- TIMEZONE DEBUG LOGGING ---
        Log::debug('TIMEZONE DEBUG (STORE) START');
        Log::debug('1. PHP Default Timezone:', ['php_default' => date_default_timezone_get()]);
        Log::debug('2. Laravel APP_TIMEZONE:', ['config_app' => config('app.timezone')]);
        Log::debug('3. User Input Time:', ['input_time' => $validatedData['start_time']]);
        
        // Carbon now automatically uses the APP_TIMEZONE (e.g., Africa/Lagos) 
        // to interpret the input time.
        $startTime = Carbon::parse($validatedData['start_time']);

        Log::debug('4. Parsed Carbon Object (Local Time):', [
            'local_time' => $startTime->toDateTimeString(),
            'local_timezone' => $startTime->getTimezone()->getName()
        ]);
        // --- END TIMEZONE DEBUG LOGGING ---
        
        // Check if the scheduled time is in the future in the configured application timezone.
        if ($startTime->lessThan(Carbon::now())) {
            Log::warning('Session creation failed: Time is in the past.', [
                'input' => $validatedData['start_time'],
                'now' => Carbon::now()->toDateTimeString()
            ]);
            return redirect()->back()->withInput()->withErrors(['start_time' => 'The scheduled start time must be in the future.']);
        }

        // Use the parsed time for saving. Laravel handles the UTC conversion on save.
        $finalStartTime = $startTime->toDateTimeString();

        Log::debug('5. Final Time Saved to Database (UTC):', ['saved_utc_time' => $startTime->copy()->setTimezone('UTC')->toDateTimeString()]);
        Log::debug('TIMEZONE DEBUG (STORE) END');
        
        // 1. Generate a unique, random ID for the Jitsi Room Name (e.g., course-6-session-LYvjD6AQ)
        $meetingId = 'course-' . $course->id . '-session-' . Str::random(8);

        // 2. Save the session details in our database
        LiveSession::create([
            'course_id' => $course->id,
            'title' => $validatedData['title'],
            'start_time' => $finalStartTime, 
            'duration_minutes' => $validatedData['duration_minutes'],
            'bbb_meeting_id' => $meetingId, // Repurposing this field for the Jitsi Room Name (unique ID)
        ]);

        return redirect()->route('instructor.live-sessions.index')
            ->with('success', 'Live session scheduled successfully! 📺');
    }

    /**
     * Redirects the instructor into the Jitsi Meet room as the moderator.
     */
    public function join(LiveSession $liveSession)
    {
        if ($liveSession->course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized to join as moderator.');
        }

        $user = auth()->user();

        try {
            // This is the crucial step: Use the stored unique ID to ensure the URL path is identical
            $roomName = $this->generateJitsiRoomName($liveSession);

            // Instructor joins UNMUTED (passing false for $startMuted) and with '(Instructor)' in the display name
            $joinUrl = $this->generateJitsiUrl(
                $roomName, 
                $user->name . ' (Instructor)', 
                $user->email, 
                false // Instructor joins unmuted
            );

            if ($joinUrl) {
                return redirect()->away($joinUrl); // Redirect to the external Jitsi link
            }
        } catch (\Exception $e) {
            Log::error('Instructor failed to generate Jitsi join URL.', ['error' => $e->getMessage()]);
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
        // Use the stored unique ID from the database. This guarantees a common room for all users.
        return $liveSession->bbb_meeting_id;
    }

    /**
     * Constructs the full Jitsi Meet URL with user details and configuration.
     * @param string $roomName
     * @param string $userName
     * @param string $userEmail
     * @param bool $startMuted Default is TRUE (muted) for safety if not explicitly set.
     * @return string
     */
    protected function generateJitsiUrl(string $roomName, string $userName, string $userEmail, bool $startMuted = true): string
    {
        // Get the base URL from config (defined in .env as MEET_SERVER_URL)
        $baseUrl = config('app.meet_server_url', 'https://meet.jit.si/');
        
        // Configuration parameters for Jitsi
        $params = [
            // This parameter is the only difference between the student (true) and instructor (false) URLs
            'config.startWithAudioMuted' => $startMuted ? 'true' : 'false',
            'userInfo.displayName' => $userName,
            'userInfo.email' => $userEmail,
        ];

        return rtrim($baseUrl, '/') . '/' . $roomName . '?' . http_build_query($params);
    }
    
    /**
     * Show the form for editing the specified live session.
     */
    public function edit(LiveSession $liveSession)
    {
        $course = $liveSession->course;
        
        // Authorization: Ensure the instructor owns the course
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Pass the session and its course to the create_edit form
        return view('pages.instructor.live_sessions.create_edit', [
            'course' => $course,
            'liveSession' => $liveSession,
        ]);
    }

    /**
     * Update the specified live session in storage.
     */
    public function update(Request $request, LiveSession $liveSession)
    {
        $course = $liveSession->course;
        
        // Authorization
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:10|max:180',
            'start_time' => 'required|date', 
        ]);

        try {
            // --- TIMEZONE DEBUG LOGGING ---
            Log::debug('TIMEZONE DEBUG (UPDATE) START');
            Log::debug('1. PHP Default Timezone:', ['php_default' => date_default_timezone_get()]);
            Log::debug('2. Laravel APP_TIMEZONE:', ['config_app' => config('app.timezone')]);
            Log::debug('3. User Input Time:', ['input_time' => $validatedData['start_time']]);
            
            $startTime = Carbon::parse($validatedData['start_time']);

            Log::debug('4. Parsed Carbon Object (Local Time):', [
                'local_time' => $startTime->toDateTimeString(),
                'local_timezone' => $startTime->getTimezone()->getName()
            ]);
            // --- END TIMEZONE DEBUG LOGGING ---

            // Check if the scheduled time is in the future.
            if ($startTime->lessThan(Carbon::now())) {
                 Log::warning('Session update failed: Time is in the past.', [
                    'input' => $validatedData['start_time'],
                    'now' => Carbon::now()->toDateTimeString()
                ]);
                return redirect()->back()->withInput()->withErrors(['start_time' => 'The scheduled start time must be in the future.']);
            }

            // Laravel handles the UTC conversion on save.
            $validatedData['start_time'] = $startTime->toDateTimeString();
            
            Log::debug('5. Final Time Saved to Database (UTC):', ['saved_utc_time' => $startTime->copy()->setTimezone('UTC')->toDateTimeString()]);
            Log::debug('TIMEZONE DEBUG (UPDATE) END');


            // No external API call needed for Jitsi
            $liveSession->update($validatedData);

            return redirect()->route('instructor.live-sessions.index')
                ->with('success', 'Live session updated successfully! ✅');
        } catch (\Exception $e) {
            Log::error('Error updating live session.', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'A server error occurred while updating the session.');
        }
    }

    /**
     * Remove the specified live session from storage.
     */
    public function destroy(LiveSession $liveSession)
    {
        $course = $liveSession->course;

        // Authorization
        if ($course->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // No external API call needed for Jitsi
            $liveSession->delete();

            return redirect()->route('instructor.live-sessions.index')
                ->with('success', 'Live session successfully cancelled.');
        } catch (\Exception $e) {
            Log::error('Error deleting live session.', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'A server error occurred while cancelling the session.');
        }
    }
}