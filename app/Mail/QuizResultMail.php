<?php

namespace App\Mail;

use App\Models\User;
use App\Models\QuizAttempt;
use App\Models\Course;
use App\Services\CertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class QuizResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;
    public $attempt;
    public $questions;
    private $certificateService;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Course $course, QuizAttempt $attempt, $questions)
    {
        $this->user = $user;
        $this->course = $course;
        $this->attempt = $attempt;
        $this->questions = $questions;
        $this->certificateService = app(CertificateService::class);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->attempt->passed ? 'Passed 🎉' : 'Completed';
        return new Envelope(
            subject: "Your Quiz Results: {$this->course->title} ({$status})",
        );
    }

    /**
     * Get the message content.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quiz-results',
            with: [
                'user' => $this->user,
                'course' => $this->course,
                'attempt' => $this->attempt,
                'questions' => $this->questions,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        if ($this->attempt->passed) {
            try {
                // Generate or get existing certificate
                $certificatePath = $this->certificateService->getOrGenerateCertificate($this->attempt);
                
                if ($certificatePath && Storage::disk('public')->exists($certificatePath)) {
                    $filename = 'Certificate_' . str_replace(' ', '_', $this->course->title) . '.pdf';
                    
                    return [
                        Attachment::fromStorage('public/' . $certificatePath)
                            ->as($filename)
                            ->withMime('application/pdf'),
                    ];
                }
            } catch (\Exception $e) {
                // Log error but don't fail the email
                \Log::error('Certificate generation failed: ' . $e->getMessage());
            }
        }
        
        return [];
    }
}