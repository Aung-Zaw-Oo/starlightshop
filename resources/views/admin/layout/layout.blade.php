<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/order_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/customer_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product_create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/employee.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/employee_create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/employee_edit.css') }}">
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

    
<!-- Custom Delete Confirmation Modal -->
<div id="delete-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button type="button" class="modal-close" onclick="hideDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this record?</p>
            <p style="color: #a0aec0; font-size: 14px; margin-top: 12px;">This action cannot be undone and will permanently remove all associated data.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn modal-btn-cancel" onclick="hideDeleteModal()">Cancel</button>
            <button type="button" class="btn modal-btn-delete" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>
</main>

@stack('scripts')
<script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/layout.js') }}"></script>
<script>
    // Clickable Row
    const handleClickable = () => {
        document.querySelectorAll('.clickable-row, .clickable-card').forEach(el => {
            el.addEventListener('click', () => {
                window.location.href = el.dataset.href;
            });
        });
    };
    
    // Notification System
    function showNotification(type, title, message, duration = 5000) {
        const container = document.getElementById('notification-container');
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        // Get appropriate icon
        let icon = '';
        switch(type) {
            case 'success':
                icon = 'fa-circle-check';
                break;
            case 'error':
                icon = 'fa-circle-exclamation';
                break;
            case 'info':
                icon = 'fa-circle-info';
                break;
            default:
                icon = 'fa-circle-info';
        }
        
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fa-solid ${icon}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">${title}</div>
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close" onclick="hideNotification(this.parentElement)">
                <i class="fa-solid fa-times"></i>
            </button>
        `;
        
        container.appendChild(notification);
        
        // Show notification with animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto-hide notification
        setTimeout(() => {
            hideNotification(notification);
        }, duration);
    }
    
    function hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.parentElement.removeChild(notification);
            }
        }, 300);
    }
    
    // Make hideNotification available globally
    window.hideNotification = hideNotification;
    
    // Check for flash messages and show notifications
    @if(session('success'))
        showNotification('success', 'Success!', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showNotification('error', 'Error!', '{{ session('error') }}');
    @endif
    
    @if(session('info'))
        showNotification('info', 'Information', '{{ session('info') }}');
    @endif
    
    // Make showNotification available globally for future use
    window.showNotification = showNotification;


    // Modal Functions
    function showDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function hideDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }

    // Close modal when clicking on overlay
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDeleteModal();
        }
    });
</script>
</body>
</html>
