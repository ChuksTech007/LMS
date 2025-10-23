<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    /**
     * Generate a certificate PDF for a passed quiz attempt.
     */
    public function generateCertificate(User $user, Course $course, QuizAttempt $attempt): string
    {
        // Create a unique certificate ID
        $certificateId = 'CERT-' . strtoupper(substr(md5($user->id . $course->id . $attempt->id), 0, 10));
        
        // Prepare data for the certificate
        $data = [
            'user' => $user,
            'course' => $course,
            'attempt' => $attempt,
            'certificateId' => $certificateId,
            'completionDate' => $attempt->completed_at->format('F d, Y'),
            'instructorName' => $course->instructor->name ?? 'FUTO SkillUp',
            'score' => $attempt->percentage_score,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('certificates.template', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'serif'
            ]);

        // Save to storage
        $filename = 'certificates/' . $certificateId . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Get the full URL to a certificate.
     */
    public function getCertificateUrl(string $filename): string
    {
        return Storage::disk('public')->url($filename);
    }

    /**
     * Check if a certificate already exists for an attempt.
     */
    public function certificateExists(QuizAttempt $attempt): bool
    {
        return !empty($attempt->certificate_path) && 
               Storage::disk('public')->exists($attempt->certificate_path);
    }

    /**
     * Get or generate certificate for an attempt.
     */
    public function getOrGenerateCertificate(QuizAttempt $attempt): ?string
    {
        if (!$attempt->passed) {
            return null;
        }

        // If certificate already exists, return it
        if ($this->certificateExists($attempt)) {
            return $attempt->certificate_path;
        }

        // Generate new certificate
        $certificatePath = $this->generateCertificate(
            $attempt->user,
            $attempt->quiz->course,
            $attempt
        );

        // Save certificate path to attempt
        $attempt->update(['certificate_path' => $certificatePath]);

        return $certificatePath;
    }
}