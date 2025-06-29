<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: var(--color-4);
        }

        .box {
            width: 425px;
            padding: 20px;
            border-radius: 10px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
        }
        
        .logo img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .title {
            color: var(--color-8);
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        form {
            background-color: var(--color-2);
            color: var(--color-8);
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 10px;
            gap: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
            background: transparent;
            background-color: none;
            border-radius: 15px;
            transition: all 0.3s ease-in-out;
        }

        .input-group:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, .3);
        }

        .input-group i {
            border: 1px solid var(--color-8);
            font-size: 1.5rem;
            padding: 10px 15px;
            border-radius: 15px 0 0 15px;
        }
        
        .input-group input {
            border: 1px solid var(--color-8);
            padding: 10px 15px;
            width: 100%;
            border-radius: 0 15px 15px 0;
            color: var(--color-8);
            background-color: transparent;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px var(--color-2) inset !important;
            box-shadow: 0 0 0 1000px var(--color-2) inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        .forgot {
            text-align: right;
            color: var(--color-5);
            text-decoration: none;
            transition: all 0.3s ease-in-out;
        }

        .forgot:hover {
            color: var(--color-6);
        }

        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }
        
        .btn-primary {
            background-color: var(--btn-primary);
            color: var(--color-8);
        }

        .btn-primary:hover {
            background-color: var(--btn-primary-hover);
            box-shadow: 0 0 20px rgba(255, 255, 255, .3);
        }

        .alert-error {
            color: #b00020;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .field-error {
            color: red;
            font-size: 0.85rem;
            margin: 4px 0 8px;
        }
        </style>
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
