<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Download certificate for a quiz attempt.
     */
    public function download(QuizAttempt $attempt)
    {
        // Authorization: Ensure the user owns this attempt
        // if ($attempt->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized access to certificate.');
        // }

        // Ensure the attempt is completed and passed
        if (!$attempt->passed) {
            return redirect()->back()->with('error', 'Certificate is only available for passed attempts.');
        }

        // Generate or get existing certificate
        $certificatePath = $this->certificateService->getOrGenerateCertificate($attempt);

        if (!$certificatePath || !Storage::disk('public')->exists($certificatePath)) {
            return redirect()->back()->with('error', 'Certificate could not be generated. Please contact support.');
        }

        // Download the certificate
        $filename = 'Certificate_' . str_replace(' ', '_', $attempt->quiz->course->title) . '.pdf';
        
        return Storage::disk('public')->download($certificatePath, $filename);
    }

    /**
     * View certificate in browser.
     */
    public function view(QuizAttempt $attempt)
    {
        // Authorization
        // if ($attempt->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized access to certificate.');
        // }

        // Ensure passed
        if (!$attempt->passed) {
            return redirect()->back()->with('error', 'Certificate is only available for passed attempts.');
        }

        // Generate or get existing certificate
        $certificatePath = $this->certificateService->getOrGenerateCertificate($attempt);

        if (!$certificatePath || !Storage::disk('public')->exists($certificatePath)) {
            return redirect()->back()->with('error', 'Certificate could not be generated.');
        }

        // Return PDF response to view in browser
        return response()->file(Storage::disk('public')->path($certificatePath));
    }
}