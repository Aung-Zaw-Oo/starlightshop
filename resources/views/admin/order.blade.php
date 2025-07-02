@extends('admin.layout')

@section('title', 'Customers')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
@push('styles')
    @push('styles')
    <style>
        /* Shared Styles */
        img.avatar {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
        }

        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: bold;
        }

        .status.pending { color: yellow; }
        .status.delivered { color: lightgreen; }
        .status.cancelled { color: red; }

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

        /* Date Filter Styling */
        .breadcrumb-center {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .breadcrumb-center label {
            color: var(--color-8);
            font-weight: 500;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .breadcrumb-center input[type="date"] {
            padding: 8px 12px;
            border: 1px solid var(--color-8);
            border-radius: 6px;
            background-color: var(--color-2);
            color: var(--color-8);
            font-size: 0.9rem;
            min-width: 140px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .breadcrumb-center input[type="date"]:focus {
            outline: none;
            border-color: var(--btn-primary);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .breadcrumb-center input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.8);
            cursor: pointer;
        }

        .breadcrumb-center input[type="date"]::-webkit-inner-spin-button,
        .breadcrumb-center input[type="date"]::-webkit-clear-button {
            display: none;
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
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--btn-primary);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .date-box {
            position: relative;
            max-width: 140px;
            width: 100%;
        }

        .date-box input[type="date"] {
            width: 100%;
            padding: 8px 36px 8px 12px; /* padding-right for icon space */
            border: 1px solid var(--color-8);
            border-radius: 6px;
            background-color: var(--color-2);
            color: var(--color-8);
            font-size: 0.9rem;
            appearance: none; /* Removes default icon in Firefox */
            -webkit-appearance: none; /* Removes default icon in WebKit browsers */
            -moz-appearance: none;
            position: relative;
            z-index: 1;
        }

        .date-box input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            z-index: 2;
            cursor: pointer;
        }

        .date-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-5);
            font-size: 1rem;
            pointer-events: none;
            z-index: 1;
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

        td div {
            text-wrap: nowrap;
            overflow: hidden;
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

            .breadcrumb-center {
                justify-content: center;
                gap: 10px;
            }

            .breadcrumb-center label {
                font-size: 0.8rem;
            }

            .breadcrumb-center input[type="date"] {
                min-width: 120px;
                font-size: 0.8rem;
                padding: 6px 8px;
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

            .date-box {
                max-width: 100%;
            }

            .date-box input[type="date"] {
                font-size: 0.85rem;
                padding: 6px 36px 6px 10px;
            }
        }

        /* Very small screens */
        @media (max-width: 480px) {
            .breadcrumb-center {
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }

            .breadcrumb-center > div {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .breadcrumb-center input[type="date"] {
                flex: 1;
                min-width: auto;
            }
        }
    </style>
@endpush
@endpush

@section('content')
<!-- Flash Messages for non-JS fallback -->
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
        <span>Orders</span>
    </div>

    <div class="breadcrumb-center">
        <div class="date-box">
            <input type="date" id="from-date" name="from_date" placeholder="From Date" />
            <i class="fa-regular fa-calendar"></i>
        </div>
        <div class="date-box">
            <input type="date" id="to-date" name="to_date" placeholder="To Date" />
            <i class="fa-regular fa-calendar"></i>
        </div>
    </div>




    <div class="breadcrumb-right">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="search" placeholder="Search customers..." />
        </div>
    </div>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-only">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Qty</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="order-table-body">
           @include('admin.order.partials.order-table', ['orderdetails' => $orderdetails, 'orders' => $orders])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="card-list mobile-only" id="order-card-list">
    @include('admin.order.partials.order-cards', ['orderdetails' => $orderdetails, 'orders' => $orders])
</div>

<div class="pagination-wrapper">
    {{ $orders->onEachSide(1)->links('vendor.pagination.custom') }}
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
            const fromDateInput = document.getElementById('from-date');
            const toDateInput = document.getElementById('to-date');
            let typingTimer;
            const typingDelay = 500;

            // Combined search function
            const performSearch = () => {
                const query = searchInput.value.trim();
                const fromDate = fromDateInput.value;
                const toDate = toDateInput.value;

                // Build URL with parameters
                const params = new URLSearchParams();
                if (query) params.append('query', query);
                if (fromDate) params.append('from_date', fromDate);
                if (toDate) params.append('to_date', toDate);

                const url = `{{ route('admin.order.ajaxSearch') }}?${params.toString()}`;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-Device': window.innerWidth <= 768 ? 'mobile' : 'desktop'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (window.innerWidth <= 768) {
                        document.querySelector('#order-card-list').innerHTML = html;
                    } else {
                        document.querySelector('#order-table-body').innerHTML = html;
                    }
                    handleClickable();
                })
                .catch(error => console.error('Search error:', error));
            };

            // Search input with debounce
            searchInput.addEventListener('keyup', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(performSearch, typingDelay);
            });

            // Date inputs - immediate search
            fromDateInput.addEventListener('change', performSearch);
            toDateInput.addEventListener('change', performSearch);

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