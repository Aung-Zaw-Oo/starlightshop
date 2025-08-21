<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #E5E5E5;
            padding: 20px;
            color: #333;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .header {
            background: #14213D;
            color: #FCA311;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .content {
            padding: 25px 30px;
            color: #333;
            line-height: 1.6;
        }

        .reset-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #14213D;
            color: #FCA311;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
        }

        .expiry-text {
            margin-top: 15px;
        }

        .info-box {
            background: #F9F9F9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #14213D;
            margin-top: 15px;
            font-style: italic;
        }

        .footer {
            background: #FCA311;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #14213D;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        
        <!-- Header -->
        <div class="header">
            🔑 Password Reset Request
        </div>
        
        <!-- Content -->
        <div class="content">
            <p>Hello, Customer</p>
            <p>We received a request to reset your password. Click the button below to reset it:</p>

            <!-- Reset Button -->
            <a href="{{ url('customer/reset-password/'.$token.'?email='.$email) }}" class="reset-button">
               Reset Password
            </a>            

            <p class="expiry-text">This link will expire in 60 minutes.</p>

            <!-- Info Box -->
            <div class="info-box">
                If you did not request a password reset, please ignore this email.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            StarLight Store ✨ | Your satisfaction is our priority
        </div>

    </div>
</body>
</html>