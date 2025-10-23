@component('mail::message')
# Quiz Results for {{ $course->title }}

Hello {{ $user->name }},

Thank you for completing the final quiz for **{{ $course->title }}**. Here are your results:

@if ($attempt->passed)
**<span style="color: #10b981; font-size: 1.2em;">CONGRATULATIONS! You Passed! 🎉</span>**

<div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
<p style="font-size: 18px; color: #065f46; margin: 0;"><strong>🏆 Certificate of Completion Earned!</strong></p>
<p style="font-size: 14px; color: #047857; margin-top: 10px;">Your certificate is attached to this email as a PDF.</p>
</div>
@else
**<span style="color: #ef4444; font-size: 1.2em;">Quiz Completed. You did not pass this time. 😞</span>**

<div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 8px; padding: 20px; margin: 20px 0;">
<p style="font-size: 14px; color: #991b1b;">Don't worry! Review the course material and try again. You can do it!</p>
</div>
@endif

---

## Your Score Summary

| Metric | Value |
| :--- | :--- |
| **Your Score** | **{{ $attempt->percentage_score }}%** |
| Questions Correct | {{ $attempt->score }} out of {{ $attempt->total_questions }} |
| Passing Score | {{ $course->quiz->passing_score ?? 'N/A' }}% |
| Date Completed | {{ $attempt->completed_at->format('M d, Y H:i A') }} |

---

## Question Review (Corrections)

Below shows your answers and the correct answers for review.

@php
    $submissionData = $attempt->submission_data ?? [];
@endphp

@foreach ($questions as $index => $question)
@php
    $q_id = $question->id;
    $submission = $submissionData[$q_id] ?? ['submitted' => 'N/A', 'is_correct' => false];
    $isCorrect = $submission['is_correct'];
    $submittedAnswer = $submission['submitted'];

    // Map the 'Option X' key to the actual text from the options array
    $options = $question->options ?? [];
    $submittedText = 'Not Answered';
    $correctText = 'N/A';
    
    // Convert 'Option A' to text
    if ($submittedAnswer !== 'N/A') {
        $keyIndex = ord(substr($submittedAnswer, -1)) - ord('A');
        $submittedText = $options[$keyIndex] ?? $submittedAnswer;
    }
    
    $correctKeyIndex = ord(substr($question->correct_answer, -1)) - ord('A');
    $correctText = $options[$correctKeyIndex] ?? $question->correct_answer;
@endphp

### {{ $index + 1 }}. {{ $question->text }}

- **Your Answer:** {{ $submittedText }}
@if ($isCorrect)
- **Status:** <span style="color: #10b981; font-weight: bold;">Correct ✅</span>
@else
- **Status:** <span style="color: #ef4444; font-weight: bold;">Incorrect ❌</span>
- **Correct Answer:** {{ $correctText }}
@endif
@endforeach

---

@if ($attempt->passed)
## 🎓 Your Certificate

Your official **Certificate of Completion** is attached to this email as a PDF file. You can:

- **Download it** and print it for your records
- **Share it** on LinkedIn or your resume
- **Access it anytime** from your student dashboard

The certificate includes:
- Your name and achievement
- Course title and completion date
- Your final exam score ({{ $attempt->percentage_score }}%)
- Unique certificate ID for verification

@component('mail::button', ['url' => route('certificates.download', $attempt->id)])
Download Certificate Again
@endcomponent

@component('mail::button', ['url' => url('/my-dashboard')])
View Dashboard
@endcomponent

---

### Share Your Achievement! 🌟

We're proud of your accomplishment! Consider sharing your certificate on:
- LinkedIn
- Your professional portfolio
- Social media

@else
## Keep Going! 💪

You can review your learning materials and attempt the quiz again to achieve your certificate!

@component('mail::button', ['url' => route('courses.show', $course->slug)])
Review Course Material
@endcomponent

**Tips for Success:**
- Review the questions you got wrong (shown above)
- Revisit the course lessons
- Take notes on key concepts
- Try again when you're ready!

@endif

---

Thank you for being part of FUTO SkillUp. Keep learning and growing!

Best regards,

**{{ config('app.name') }} Team**
@endcomponent