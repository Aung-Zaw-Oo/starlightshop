<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>

@php
    $staff = session('staff_id') ? \App\Models\Staff::with('credential')->find(session('staff_id')) : null;
@endphp

<!-- Top Navigation -->
<nav class="top-nav">
    <div class="nav-left">
        <span class="star-icon">
            <img src="{{ asset('icons/logo.svg') }}" alt="Logo">
        </span>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">☰</button>
    </div>
    <div class="nav-right">
        <div class="profile-container">
            <button class="profile-btn" id="profileBtn">
                <img src="{{ asset('storage/' . ($staff?->image ?? 'uploads/default-avatar.png')) }}" alt="{{ $staff?->first_name ?? 'Profile' }}">
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                @if ($staff)
                    <a href="{{ route('admin.staff.edit', $staff->id) }}">
                        <i class="fa-solid fa-user"></i>        
                        <span>Profile</span>
                    </a>
                    <a href="{{ route('admin.logout') }}">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                @else
                    <a href="{{ route('admin.login') }}">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Login</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <nav class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-gauge-high"></i></span>
            <span class="text">Dashboard</span>
        </a>

        <a href="{{ route('admin.order') }}" class="menu-item {{ Route::currentRouteName() == 'admin.order' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-bag-shopping"></i></span>
            <span class="text">Orders</span>
            <span class="order-count">
                {{ \App\Models\Order::count() }}
            </span>
        </a>

        <a href="{{ route('admin.customer') }}" class="menu-item {{ Route::currentRouteName() == 'admin.customer' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-users"></i></span>
            <span class="text">Customers</span>
        </a>

        <a href="{{ route('admin.product') }}" class="menu-item {{ Route::currentRouteName() == 'admin.product' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-box"></i></span>
            <span class="text">Products</span>
        </a>

        <a href="{{ route('admin.category') }}" class="menu-item {{ Route::currentRouteName() == 'admin.category' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-boxes-stacked"></i></span>
            <span class="text">Categories</span>
        </a>

        <a href="{{ route('admin.employee') }}" class="menu-item {{ Route::currentRouteName() == 'admin.employee' ? 'active' : '' }}">
            <span class="icon"><i class="fa-solid fa-user-gear"></i></span>
            <span class="text">Employees</span>
        </a>
    </nav>
</aside>

<!-- Overlay for mobile -->
<div class="overlay" id="overlay"></div>

<!-- Main Content -->
<main class="main-content" id="mainContent">
    @yield('content')
</main>

<script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/layout.js') }}"></script>
@stack('scripts')
</body>
</html>
