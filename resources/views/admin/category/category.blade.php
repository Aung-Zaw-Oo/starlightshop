@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<!-- Notification Container -->
<div id="notification-container"></div>

<!-- Breadcrumb -->
<div class="category-breadcrumb">
    <div class="category-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Categories</span>
    </div>
    <div class="category-beadcrumb-center">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" id="search" placeholder="search">
        </div> 
    </div>
    <div class="category-beadcrumb-right">
         <a href="{{ route('admin.category.create') }}" class="btn primary"><i class="fa-solid fa-plus"></i> Add</a>
    </div>
</div>

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
        <tbody id="category-table-body">
            @include('admin.category.partials.category-table', ['categories' => $categories])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-only" id="category-card-list">
    @include('admin.category.partials.category-cards', ['categories' => $categories])
</div>
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
                    document.querySelector('#category-card-list').innerHTML = html;
                } else {
                    document.querySelector('#category-table-body').innerHTML = html;
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