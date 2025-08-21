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

                <label for="email">Your Email</label>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email address" autocomplete="email">
                </div>

                <button type="submit" class="btn btn-primary">SEND RESET LINK</button>
                
                <a href="{{ route('admin.login') }}" class="forgot" style="text-align: center;">
                    Remember your password? Back to Login
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