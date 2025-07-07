@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
@push('styles')
    <style>
        .main-content > div {
            padding-top: 1rem;
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            padding: 2rem;
            max-width: 900px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .left img {
            width: 300px;
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
        }

        .right {
            flex: 1;
            min-width: 280px;
            background-color: #2b2b2b;
            padding: 2rem;
            border-radius: 1rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .right h2 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #FCA311;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-bottom: 1rem;
        }

        form label {
            font-weight: 500;
            margin-bottom: 0.3rem;
            display: block;
            color: #e5e5e5;
        }

        form input[type="email"],
        form input[type="password"] {
            color: #fff;
            width: 100%;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #fff;
            transition: border-color 0.2s;
            background-color: var(--color-2);
        }

        form input[type="email"]:focus,
        form input[type="password"]:focus {
            border-color: #FCA311;
            outline: none;
        }

        .remember-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #ddd;
        }

        button[type="submit"] {
            padding: 0.75rem;
            background-color: var(--green);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #1d2a4d;
        }

        form a {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #FCA311;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        form a:hover {
            text-decoration: underline;
        }

        .alert-error {
            color: #b00020;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }

            .right {
                width: 100%;
                padding: 1.5rem;
            }

            label {
                text-align: left;
            }

            .left img {
                width: 200px;
                margin: 0 auto;
            }
        }
    </style>
@endpush

@section('content')
    <div>
        <h2 style="text-align:center;">CUSTOMER LOGIN</h2>
        <div class="login-container">
            <div class="left">
                <img src="{{ asset('storage/uploads/shopping-cart.png') }}" alt="">
            </div>
            <div class="right">
                <h2>Login</h2>
                <form action="{{ route('customer.loginProcess') }}" method="post">
                    @csrf

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="email-box">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="password-box">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="remember-box">
                        <input type="checkbox" name="remember-me" id="remember-me">
                        <label for="remember-me">Remember me</label>
                    </div>
                    <button type="submit">Login</button>
                    <a href="{{ route('customer.registerForm') }}">Don't have an account? <span style="color: var(--green);">Register Now.</span></a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Optional JS
    </script>
@endpush
