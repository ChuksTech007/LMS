@component('mail::message')

Congratulations, {{ $user->name }}!
We are thrilled to inform you that you have successfully completed and passed the final examination for the course: {{ $course->title }}.

Your certificate is attached to this email. You have earned this achievement through hard work and dedication.

<div style="text-align: center; border: 3px solid #10b981; padding: 40px; border-radius: 10px; background-color: #f7fdfc;">
<h2 style="color: #065f46; font-size: 28px; margin-bottom: 5px;">CERTIFICATE OF COMPLETION</h2>
<p style="color: #6b7280; font-size: 16px; margin-bottom: 30px;">This certifies that</p>
<h1 style="color: #047857; font-size: 48px; font-weight: bold; margin-bottom: 20px; font-family: serif;">{{ $user->name }}</h1>
<p style="color: #6b7280; font-size: 18px; margin-bottom: 5px;">has successfully completed the course requirements and passed the final exam in</p>
<h3 style="color: #10b981; font-size: 32px; font-weight: bold; border-bottom: 2px solid #10b981; display: inline-block; padding-bottom: 5px;">{{ $course->title }}</h3>
<p style="color: #6b7280; font-size: 14px; margin-top: 30px;">Issued on: {{ \Carbon\Carbon::now()->format('F jS, Y') }}</p>

<div style="margin-top: 40px; display: flex; justify-content: space-around; width: 80%; margin-left: auto; margin-right: auto;">
    <div style="text-align: center;">
        <div style="height: 1px; width: 150px; background-color: #6b7280; margin-bottom: 5px;"></div>
        <p style="font-size: 14px; color: #6b7280;">FUTO Skillup Administration</p>
    </div>
    <div style="text-align: center;">
        <div style="height: 1px; width: 150px; background-color: #6b7280; margin-bottom: 5px;"></div>
        <p style="font-size: 14px; color: #6b7280;">Instructor Signature</p>
    </div>
</div>

</div>

Start another course today and continue your journey!

@component('mail::button', ['url' => url('/student/dashboard')])
Go to Dashboard
@endcomponent

Thanks,




{{ config('app.name') }} Team
@endcomponent