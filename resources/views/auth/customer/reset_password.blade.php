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
            <form action="{{ route('customer.reset.password') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <p class="title">Reset Password</p>
                <p style="text-align: center; color: var(--text-grey); font-size: 0.9rem; margin-bottom: 10px;">
                    Enter your new password below to reset your account password.
                </p>

                <label for="email">Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ $email }}" placeholder="Email address" readonly style="background-color: var(--bg-grey); cursor: not-allowed;">
                </div>

                <label for="password">New Password</label>

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" id="password" placeholder="Enter new password" autocomplete="new-password">
                </div>

                <label for="password_confirmation">Confirm New Password</label>

                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">RESET PASSWORD</button>
                
                <a href="{{ route('customer.loginForm') }}" class="forgot" style="text-align: center;">
                    Back to Login
                </a>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
    <script>
        @if(session('success'))
            showNotification("{{ session('success') }}", "success");
        @endif

        @if(session('error'))
            showNotification("{{ session('error') }}", "error");
        @endif

        @if (session('info'))
            showNotification("{{ session('info') }}", "info");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showNotification("{{ $error }}", "error");
            @endforeach
        @endif

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <span class="notification-icon">
                ${type === 'success' ? '<i class="fas fa-circle-check"></i>' : type === 'error' ? '<i class="fas fa-circle-exclamation"></i>' : '<i class="fas fa-circle-info"></i>'}
                </span>
                <div class="notification-content">
                <div class="notification-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close" aria-label="Close notification">&times;</button>
            `;

            document.body.appendChild(notification);

            void notification.offsetWidth;
            notification.classList.add('show');

            const autoRemove = setTimeout(() => notification.remove(), 3000);

            notification.querySelector('.notification-close').addEventListener('click', () => {
                clearTimeout(autoRemove);
                notification.remove();
            });
        }
    </script>
</body>
</html>