<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-left">
            <span class="star-icon">
                <img src="{{ asset('icons/logo.svg') }}" alt="" srcset="">
            </span>
            <button class="menu-toggle" id="menuToggle">☰</button>
        </div>
        <div class="nav-right">
            <div class="profile-container">
                <button class="profile-btn" id="profileBtn">
                    <img src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg" alt="Profile">
                </button>
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="#">
                        <i class="fa-solid fa-user"></i>        
                        <span>Profile</span>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-gauge-high"></i>
                </span>Dashboard
            </a>
            <a href="{{ route('Order') }}" class="menu-item {{ Route::is('admin.order') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </span>Orders
                <span class="order-count">10</span>
            </a>
            <a href="{{ route('admin.customer') }}" class="menu-item {{ Route::is('admin.customer') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-users"></i>
                </span>Customer
            </a>
            <a href="{{ route('admin.product') }}" class="menu-item {{ Route::is('admin.product') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-box"></i>
                </span>Products</a>
            <a href="{{ route('admin.category') }}" class="menu-item {{ Route::is('admin.category') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>Categories
            </a>
            <a href="{{ route('admin.employee') }}" class="menu-item {{ Route::is('admin.employee') ? 'active' : '' }}">
                <span class="icon">
                    <i class="fa-solid fa-user-gear"></i>
                </span>Employees
            </a>
            <a href="{{route('Order') }}">Test</a>

        </nav>
    </aside>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>
</html>
