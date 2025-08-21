<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>
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
            <form action="{{ route('reset.password') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <p class="title">Reset Password</p>
                <p style="text-align: center; color: var(--text-grey); font-size: 0.9rem; margin-bottom: 10px;">
                    Enter your new password below to reset your account password.
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

                <label for="email">Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ $email }}" placeholder="Email address" readonly style="background-color: var(--bg-grey); cursor: not-allowed;">
                </div>

                <label for="password">New Password</label>

                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" id="password" placeholder="Enter new password" autocomplete="new-password" required>
                </div>

                <label for="password_confirmation">Confirm New Password</label>

                @error('password_confirmation')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" autocomplete="new-password" required>
                </div>

                <button type="submit" class="btn btn-primary">RESET PASSWORD</button>
                
                <a href="{{ route('admin.login') }}" class="forgot" style="text-align: center;">
                    Back to Login
                </a>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
</body>
</html>