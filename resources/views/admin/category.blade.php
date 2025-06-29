@extends('admin.layout')

@section('title', 'Categories')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
@push('styles')
<style>
    /* Shared */
    img.avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: bold;
    }

    .status.active { color: green; }
    .status.inactive { color: gray; }

    .clickable-row,
    .clickable-card {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .clickable-row:hover,
    .clickable-card:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .breadcrumb-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .breadcrumb-left span {
        color: var(--color-8);
        font-weight: 500;
        margin-right: 5px;
    }

    .search-box {
        position: relative;
        width: 100%;
        max-width: 300px;
    }

    .search-box i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: var(--color-5);
        font-size: 1rem;
        pointer-events: none;
    }

    .search-box input {
        width: 100%;
        padding: 8px 12px 8px 35px;
        border: 1px solid var(--color-8);
        border-radius: 6px;
        background-color: var(--color-2);
        color: var(--color-8);
    }

    .breadcrumb-right .btn {
        background-color: var(--btn-primary);
        color: var(--color-8);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.95rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .breadcrumb-right .btn:hover {
        background-color: var(--btn-primary-hover);
    }

    .pagination-wrapper {
        margin-top: 20px;
        text-align: center;
    }

    .pagination {
        display: inline-flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border: 1px solid var(--color-8);
        border-radius: 4px;
        font-size: 14px;
        background-color: var(--color-2);
        color: var(--color-8);
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .page-link:hover {
        background-color: var(--btn-primary-hover);
    }

    .pagination .active .page-link {
        background-color: var(--btn-primary);
        color: white;
        font-weight: bold;
        pointer-events: none;
    }

    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Notification Styles */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .notification.success {
        background-color: #065f46;
        color: #d1fae5;
        border: 1px solid #059669;
    }

    .notification.error {
        background-color: #7f1d1d;
        color: #fecaca;
        border: 1px solid #dc2626;
    }

    .notification.info {
        background-color: #1e3a8a;
        color: #dbeafe;
        border: 1px solid #3b82f6;
    }

    .notification-icon {
        font-size: 18px;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        margin-bottom: 2px;
    }

    .notification-message {
        font-size: 13px;
        opacity: 0.9;
    }

    .notification-close {
        background: none;
        border: none;
        color: inherit;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        opacity: 0.7;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
    }

    .notification-close:hover {
        opacity: 1;
    }

    /* Alert Styles for fallback */
    .alert {
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background-color: #065f46;
        color: #d1fae5;
        border: 1px solid #059669;
    }

    .alert-error {
        background-color: #7f1d1d;
        color: #fecaca;
        border: 1px solid #dc2626;
    }

    .alert-info {
        background-color: #1e3a8a;
        color: #dbeafe;
        border: 1px solid #3b82f6;
    }

    .alert i {
        font-size: 16px;
    }

    /* Desktop Table */
    table {
        width: 100%;
        border-collapse: collapse;
        border-top: 1px solid var(--color-8);
        border-bottom: 1px solid var(--color-8);
    }

    th, td {
        padding: 10px 20px;
        text-align: left;
        vertical-align: middle;
        border-top: 1px solid var(--color-8);
    }

    th {
        font-weight: 600;
    }

    .desktop-only { display: block; }
    .mobile-only, .clickable-card {
        display: none;
    }

    /* Mobile Cards */
    .card-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .staff-card {
        background: var(--color-2);
        border: 1px solid var(--color-8);
        border-radius: 8px;
        padding: 16px;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .card-header .name {
        font-weight: bold;
        font-size: 1.1rem;
        color: var(--color-8);
    }

    .card-body div {
        margin-bottom: 6px;
        font-size: 0.9rem;
        color: var(--color-8);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .desktop-only { display: none; }
        .mobile-only, .clickable-card {
            display: block;
            margin-bottom: 10px;
        }

        .breadcrumb-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .breadcrumb-right .btn,
        .search-box input {
            width: 100%;
        }

        img.avatar {
            width: 30px;
            height: 30px;
        }

        .status {
            font-size: 0.75rem;
            padding: 2px 6px;
        }

        .notification {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
            transform: translateY(-100px);
        }

        .notification.show {
            transform: translateY(0);
        }

        .search-box {
            max-width: unset;
        }
    }
</style>
@endpush

@section('content')
<!-- Flash Messages (Fallback for non-JS users) -->
@if(session('info'))
    <div class="alert alert-info">
        <i class="fa-solid fa-circle-info"></i>
        {{ session('info') }}
    </div>
@endif

<div class="breadcrumb-bar">
    <div class="breadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span> > </span>
        <span>Categories</span>
    </div>

    <div class="breadcrumb-center">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="search" placeholder="Search category..." />
        </div>
    </div>

    <div class="breadcrumb-right">
        <a href="{{ route('admin.category.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Add</a>
    </div>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-only">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Status</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody id="staff-table-body">
            @include('admin.category.partials.category-table', ['categories' => $categories])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="card-list mobile-only" id="staff-card-list">
    @include('admin.category.partials.category-cards', ['categories' => $categories])
</div>

<div class="pagination-wrapper">
    {{ $categories->onEachSide(1)->links('vendor.pagination.custom') }}
</div>

<!-- Notification Container -->
<div id="notification-container"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const handleClickable = () => {
        document.querySelectorAll('.clickable-row, .clickable-card').forEach(el => {
            el.addEventListener('click', () => {
                window.location.href = el.dataset.href;
            });
        });
    };

    handleClickable();

    const searchInput = document.getElementById('search');
    let typingTimer;
    const typingDelay = 500;

    searchInput.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            const query = searchInput.value.trim();
            fetch(`{{ route('admin.category.ajaxSearch') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-Device': window.innerWidth <= 768 ? 'mobile' : 'desktop'
                }
            })
            .then(response => response.text())
            .then(html => {
                if (window.innerWidth <= 768) {
                    document.querySelector('#staff-card-list').innerHTML = html;
                } else {
                    document.querySelector('#staff-table-body').innerHTML = html;
                }
                handleClickable();
            })
            .catch(error => console.error('Search error:', error));
        }, typingDelay);
    });

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
        // Hide the fallback alert
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) alert.style.display = 'none';
        }, 100);
    @endif
    
    @if(session('error'))
        showNotification('error', 'Error!', '{{ session('error') }}');
        // Hide the fallback alert
        setTimeout(() => {
            const alert = document.querySelector('.alert-error');
            if (alert) alert.style.display = 'none';
        }, 100);
    @endif
    
    @if(session('info'))
        showNotification('info', 'Information', '{{ session('info') }}');
        // Hide the fallback alert
        setTimeout(() => {
            const alert = document.querySelector('.alert-info');
            if (alert) alert.style.display = 'none';
        }, 100);
    @endif
    
    // Make showNotification available globally for future use
    window.showNotification = showNotification;
});
</script>
@endpush