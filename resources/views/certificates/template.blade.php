<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }

        .certificate-container {
            width: 90%;
            height: 90%;
            margin: 5% auto;
            background: white;
            border: 20px solid #047857;
            border-image: linear-gradient(45deg, #047857, #10b981) 1;
            padding: 60px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .certificate-inner {
            width: 100%;
            height: 100%;
            border: 3px solid #d1d5db;
            padding: 40px;
            position: relative;
            background: linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);
        }

        /* Decorative corners */
        .corner {
            position: absolute;
            width: 80px;
            height: 80px;
            border-color: #10b981;
        }

        .corner-tl {
            top: 20px;
            left: 20px;
            border-top: 4px solid #10b981;
            border-left: 4px solid #10b981;
        }

        .corner-tr {
            top: 20px;
            right: 20px;
            border-top: 4px solid #10b981;
            border-right: 4px solid #10b981;
        }

        .corner-bl {
            bottom: 20px;
            left: 20px;
            border-bottom: 4px solid #10b981;
            border-left: 4px solid #10b981;
        }

        .corner-br {
            bottom: 20px;
            right: 20px;
            border-bottom: 4px solid #10b981;
            border-right: 4px solid #10b981;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #047857;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Title */
        .title {
            text-align: center;
            margin: 50px 0 30px;
        }

        .title h1 {
            font-size: 56px;
            color: #047857;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .title-underline {
            width: 300px;
            height: 4px;
            background: linear-gradient(to right, #047857, #10b981, #047857);
            margin: 20px auto;
        }

        /* Content */
        .content {
            text-align: center;
            padding: 0 60px;
        }

        .content p {
            font-size: 18px;
            color: #4b5563;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .recipient-name {
            font-size: 48px;
            color: #065f46;
            font-weight: bold;
            margin: 30px 0;
            padding: 20px 0;
            border-top: 2px solid #d1d5db;
            border-bottom: 2px solid #d1d5db;
            font-family: 'Brush Script MT', cursive;
        }

        .course-name {
            font-size: 32px;
            color: #10b981;
            font-weight: bold;
            margin: 30px 0;
            font-style: italic;
        }

        .achievement-box {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 2px solid #10b981;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
        }

        .achievement-box p {
            font-size: 16px;
            color: #065f46;
            margin: 5px 0;
        }

        .score-badge {
            display: inline-block;
            background: #047857;
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            padding: 0 100px;
        }

        .signature-block {
            text-align: center;
            width: 250px;
        }

        .signature-line {
            border-top: 2px solid #4b5563;
            margin-bottom: 10px;
        }

        .signature-label {
            font-size: 14px;
            color: #6b7280;
        }

        .signature-name {
            font-size: 16px;
            color: #1f2937;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Certificate ID */
        .certificate-id {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: #9ca3af;
            letter-spacing: 1px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 180px;
            color: rgba(16, 185, 129, 0.03);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-inner">
            <!-- Decorative corners -->
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>

            <!-- Watermark -->
            <div class="watermark">★</div>

            <!-- Header -->
            <div class="header">
                <div class="logo">FUTO SKILLUP</div>
                <div class="subtitle">Learning Management System</div>
            </div>

            <!-- Title -->
            <div class="title">
                <h1>Certificate of Completion</h1>
                <div class="title-underline"></div>
            </div>

            <!-- Content -->
            <div class="content">
                <p style="font-size: 16px;">This certifies that</p>

                <div class="recipient-name">{{ $user->name }}</div>

                <p>has successfully completed the course requirements and demonstrated</p>
                <p>exceptional understanding by passing the final examination for</p>

                <div class="course-name">"{{ $course->title }}"</div>

                <div class="achievement-box">
                    <p><strong>Final Exam Score:</strong></p>
                    <div class="score-badge">{{ $score }}%</div>
                    <p style="margin-top: 10px;">Completed on {{ $completionDate }}</p>
                </div>

                <p style="font-size: 14px; margin-top: 30px;">
                    This certificate acknowledges dedication, commitment, and successful mastery
                    of the course material. The recipient has demonstrated proficiency and earned
                    this recognition of achievement.
                </p>
            </div>

            <!-- Footer with signatures -->
            <div class="footer">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Platform Administrator</div>
                    <div class="signature-name">FUTO SkillUp Team</div>
                </div>

                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Course Instructor</div>
                    <div class="signature-name">{{ $instructorName }}</div>
                </div>
            </div>

            <!-- Certificate ID -->
            <div class="certificate-id">
                Certificate ID: {{ $certificateId }} | Verify at: {{ url('/') }}
            </div>
        </div>
    </div>
</body>
</html>