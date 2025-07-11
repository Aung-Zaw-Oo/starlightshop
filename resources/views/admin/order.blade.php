@extends('admin.layout')

@section('title', 'Orders')

@section('content')

<!-- Breadcrumb -->
<div class="order-breadcrumb">
    <div class="order-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span> > </span>
        <span>Orders</span>
    </div>
    <div class="order-beadcrumb-center">
            <label for="from-date" class="desktop-only">From:</label>
            <input type="date" name="from_date" id="from-date">
            <label for="to-date" class="desktop-only">To:</label>
            <input type="date" name="to_date" id="to-date">
    </div>
    <div class="order-beadcrumb-right">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" id="search" placeholder="search">
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
        @include('admin.order.partials.order-table', ['orderdetails' => $orderdetails, 'orders' => $orders])
    </table>
</div>



<!-- Notification Container -->
<div id="notification-container"></div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ========== AJAX SEARCH ==========
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('order-table-body');
        const cardList = document.getElementById('order-card-list');
        let typingTimer;
        const delay = 500;

        const performSearch = () => {
            const query = searchInput.value.trim();
            const device = window.innerWidth <= 1024 ? 'mobile' : 'desktop';

            fetch(`{{ route('admin.order.ajaxSearch') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-Device': device
                }
            })
            .then(response => response.text())
            .then(html => {
                if (device === 'mobile' && cardList) {
                    cardList.innerHTML = html;
                } else if (tableBody) {
                    tableBody.innerHTML = html;
                }
            })
            .catch(error => console.error('AJAX Search Error:', error));
        };

        if (searchInput) {
            searchInput.addEventListener('keyup', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(performSearch, delay);
            });

            searchInput.addEventListener('keydown', () => {
                clearTimeout(typingTimer);
            });
        }

        // ========== NOTIFICATION SYSTEM ==========
        function showNotification(type, title, message, duration = 5000) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;

            let icon = '';
            switch (type) {
                case 'success': icon = 'fa-circle-check'; break;
                case 'error': icon = 'fa-circle-exclamation'; break;
                case 'info': icon = 'fa-circle-info'; break;
                default: icon = 'fa-circle-info';
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

            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

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

        window.showNotification = showNotification;
        window.hideNotification = hideNotification;

        @if(session('success'))
            showNotification('success', 'Success!', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showNotification('error', 'Error!', '{{ session('error') }}');
        @endif

        @if(session('info'))
            showNotification('info', 'Info', '{{ session('info') }}');
        @endif
    });
</script>

@endpush