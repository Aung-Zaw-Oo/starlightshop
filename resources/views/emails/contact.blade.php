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
        }
        .container {
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
            color: #333333;
            line-height: 1.6;
        }
        .content p {
            margin: 10px 0;
        }
        .label {
            font-weight: 600;
            color: #14213D;
        }
        .footer {
            background: #FCA311;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #14213D;
            font-weight: 600;
        }
        .message-box {
            background: #F9F9F9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #14213D;
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fa-solid fa-message"></i>
            <span>📩 New Contact Message</span>
        </div>
        <div class="content">
            <p><span class="label">Name:</span> {{ $data['first-name'] }} {{ $data['last-name'] }}</p>
            <p><span class="label">Email:</span> {{ $data['email'] }}</p>
            <p><span class="label">Phone:</span> {{ $data['phone'] ?? 'N/A' }}</p>

            <div class="message-box">
                {{ $data['message'] }}
            </div>
        </div>
        <div class="footer">
            StarLight Store ✨ | Your satisfaction is our priority
        </div>
    </div>
</body>
</html>
