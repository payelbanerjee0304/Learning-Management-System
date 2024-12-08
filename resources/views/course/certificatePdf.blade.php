<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Achievement</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            height: 100vh;
            overflow: hidden;
        }
        .certificate {
            width: 94%;
            padding-top: calc(85% * 1.414);
            background-color: #fff;
            border: 25px solid #d4af37;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .certificate-content {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Logo container for centering */
        .footer {
            display: flex;
            flex-direction: column; /* Stack logo and signature vertically */
            align-items: center; /* Center align both elements */
            gap: 20px;
        }

        /* Center the logo */
        .logo {
            max-width: 120px;
        }
        
        .certificate-header {
            background-color: #800000;
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 40%, 0% 70%);
            position: relative;
        }
        .title {
            font-size: 48px;
            text-align: center;
            margin-top: 80px;
            font-family: 'Georgia', serif;
            font-weight: bold;
        }
        .subtitle {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin: 10px 0;
        }
        .content {
            text-align: center;
            font-size: 16px;
            color: #666;
            margin: 30px 0;
            padding: 0 40px;
        }
        .recipient-name {
            text-align: center;
            font-size: 36px;
            font-family: 'Brush Script MT', cursive;
            margin-top: 20px;
            color: #000;
        }
        .line {
            width: 80%;
            height: 1px;
            background-color: #000;
            margin: 10px auto;
        }
        .signature {
            text-align: center;
            font-size: 18px;
            color: #888;
        }
        .signature-line {
            width: 200px;
            height: 1px;
            background-color: #d4af37;
            margin: 10px auto 0;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-content">
            <div class="certificate-header">Certificate of Completion</div>
            <div class="title">Congratulations</div>
            <div class="subtitle">ON YOUR ACCOMPLISHMENT!</div>
            <div class="content">This is to certify that</div>
            <div class="recipient-name">{{ $userName }}</div>
            <div class="line"></div>
            <div class="content">successfully completed of the Online Course <div class="title">{{ $courseName }}</div></div>

            <!-- Centered Footer with Logo and Signature -->
            <div class="footer">
                <div class="logo-container">
                    {{-- <img src="{{ $logoPath }}" alt="logo" class="logo"> --}}
                </div>
                <div class="signature">
                    Signature
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




<!-- <body>
    <div class="certificate-container">
        <div class="certificate-title">Certificate of Completion</div>
        <p>This certificate is awarded to</p>
        <h2>{{ $userName }}</h2>
        <p>for successfully completing the course</p>
        <h2>{{ $courseName }}</h2>
        <p class="certificate-body">Congratulations on your accomplishment!</p>
    </div>
</body>
</html> -->
