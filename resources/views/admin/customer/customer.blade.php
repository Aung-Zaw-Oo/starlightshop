@extends('admin.layout.layout')

@section('title', 'Customers')

@section('content')
<!-- Notification Container -->
<div id="notification-container"></div>

<!-- Breadcrumb -->
<div class="customer-breadcrumb">
    <div class="customer-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Customers</span>
    </div>
    <div class="customer-beadcrumb-right">
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
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Items Bought</th>
                <th>Money Spent</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody id="customer-table-body">
            @include('admin.customer.partials.customer-table', ['customers' => $customers])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="card-list mobile-only" id="customer-card-list">
    @include('admin.customer.partials.customer-card', ['customers' => $customers])
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    let typingTimer;
    const typingDelay = 500;

    function sendSearchRequest(page = 1) {
        const query = searchInput.value.trim();

        const params = new URLSearchParams({
            query: query,
            page: page
        });

        fetch(`{{ route('admin.customer.ajaxSearch') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-Device': window.innerWidth <= 768 ? 'mobile' : 'desktop'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (window.innerWidth <= 768) {
                document.querySelector('#customer-card-list').innerHTML = html;
            } else {
                document.querySelector('#customer-table-body').innerHTML = html;
            }
            handleClickable();
        })
        .catch(error => console.error('Search error:', error));
    }

    // Search on keyup
    searchInput.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => sendSearchRequest(), typingDelay);
    });

    // Pagination support
    document.addEventListener('click', function (e) {
        if (e.target.matches('.pagination a')) {
            e.preventDefault();
            const pageUrl = new URL(e.target.href);
            const page = pageUrl.searchParams.get('page');
            sendSearchRequest(page);
        }
    });
});
</script>
@endpush
