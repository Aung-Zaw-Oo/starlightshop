<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>
    <div class="container">
        <div class="box">
            <div class="logo">
                <img src="{{ asset('icons/logo.svg') }}" alt="Star Light Logo">
                <p class="title">STAR LIGHT</p>
            </div>
            <form action="{{ route('forgot.password') }}" method="POST">
                @csrf
                <p class="title">Forgot Password?</p>
                <p style="text-align: center; color: var(--text-grey); font-size: 0.9rem; margin-bottom: 10px;">
                    Don't worry! Enter your email address and we'll send you a password reset link.
                </p>

                @if (session('status'))
                    <div class="alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <label for="email">Your Email</label>

                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email address" autocomplete="email" required>
                </div>

                <button type="submit" class="btn btn-primary">SEND RESET LINK</button>
                
                <a href="{{ route('admin.login') }}" class="forgot" style="text-align: center;">
                    Remember your password? Back to Login
                </a>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
</body>
</html>