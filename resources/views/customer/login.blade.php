@extends('customer.layout.layout')

@section('title', 'Login')

<link rel="stylesheet" href="{{ asset('css/customer/login.css') }}">

@section('content')
    <div class="container">
        <h2>CUSTOMER LOGIN</h2>
        <div class="login-container">
            <div class="left">
                <img src="{{ asset('storage/uploads/shopping-cart.png') }}" alt="">
            </div>
            <div class="right">
                <h2>Login</h2>
                <form action="{{ route('customer.loginProcess') }}" method="post" id="loginForm">
                    @csrf

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="input-box">
                        <label for="email">Email:</label>

                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <input type="email" name="email" id="email"  placeholder="example@gmail.com" value="{{ old('email') }}">
                    </div>

                    <div class="input-box">
                        <label for="password">Password:</label>

                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <input type="password" name="password" id="password"  placeholder="Enter your password">
                    </div>

                    <div class="remember-box">
                        <input type="checkbox" name="remember-me" id="remember-me">
                        <label for="remember-me">Remember me</label>
                    </div>

                    <button type="submit" class="btn primary">Login</button>
                    <a href="{{ route('customer.registerForm') }}">Don't have an account? <span style="color: var(--primary);">Register Now.</span></a>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hide error message after 5 seconds
        const errorMessage = document.querySelector('.error');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }

        // remember me
        const emailInput = document.getElementById('email');
        const rememberMeCheckbox = document.getElementById('remember-me');
        const loginForm = document.getElementById('loginForm');

        // On page load: fill email if saved
        const savedEmail = localStorage.getItem('rememberedEmail');
        if (savedEmail) {
            emailInput.value = savedEmail;
            rememberMeCheckbox.checked = true;
        }

        loginForm.addEventListener('submit', function() {
            if (rememberMeCheckbox.checked) {
            // Save email to localStorage
            localStorage.setItem('rememberedEmail', emailInput.value);
            } else {
            // Remove saved email if checkbox not checked
            localStorage.removeItem('rememberedEmail');
            }
        });
    });
</script>