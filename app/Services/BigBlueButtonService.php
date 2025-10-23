<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BigBlueButtonService
{
    protected $baseUrl;
    protected $secret;

    public function __construct()
    {
        // Get the credentials from the config file (Step 1.3)
        $this->baseUrl = trim(config('services.bbb.url'), '/');
        $this->secret = config('services.bbb.secret');

        if (!$this->baseUrl || !$this->secret) {
            // Throw an error if credentials aren't set—we can't proceed otherwise!
            throw new \Exception("BigBlueButton credentials missing. Check your .env and config/services.php.");
        }
    }

    // Helper to create the secure URL with the checksum
    protected function generateApiUrl(string $action, string $queryString): string
    {
        // Security: The checksum prevents unauthorized API calls
        $checksum = sha1($action . $queryString . $this->secret);

        return "{$this->baseUrl}/{$action}?{$queryString}&checksum={$checksum}";
    }

    // Creates the meeting on the BBB server (used by the Instructor)
    public function createMeeting(string $meetingId, string $name, int $durationMinutes): bool
    {
        $queryString = http_build_query([
            'meetingID' => $meetingId,
            'name' => $name,
            'attendeePW' => 'ap', // Attendee password (used by students)
            'moderatorPW' => 'mp', // Moderator password (used by instructor)
            'duration' => $durationMinutes,
            'record' => 'true', 
            'autoStartRecording' => 'true',
            'muteOnStart' => 'true',
            'logoutURL' => route('student.dashboard'), // Where to redirect after class ends
        ]);

        $url = $this->generateApiUrl('create', $queryString);

        try {
            $response = simplexml_load_file($url);

            return (string)$response->returncode === 'SUCCESS';
        } catch (\Exception $e) {
            Log::error('BBB API call failed (createMeeting): ' . $e->getMessage());
            return false;
        }
    }

    // Generates the join link for a user (used by both Student and Instructor)
    public function getJoinUrl(string $meetingId, string $userName, string $userId, bool $isModerator): ?string
    {
        $password = $isModerator ? 'mp' : 'ap'; 

        $queryString = http_build_query([
            'meetingID' => $meetingId,
            'fullName' => $userName,
            'password' => $password,
            'userID' => $userId,
            'role' => $isModerator ? 'MODERATOR' : 'VIEWER',
        ]);
        
        $checksum = sha1('join' . $queryString . $this->secret);
        return "{$this->baseUrl}/join?{$queryString}&checksum={$checksum}";
    }
}