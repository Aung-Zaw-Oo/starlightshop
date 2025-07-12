<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
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
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <p class="title">Welcome Back!</p>

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
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" autocomplete="email">
                </div>
                <label for="password">Your Password</label>

                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your password" autocomplete="current-password">
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
</body>
</html>
