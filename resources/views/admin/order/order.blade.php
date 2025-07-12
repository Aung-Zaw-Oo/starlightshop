@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<!-- Notification Container -->
<div id="notification-container"></div>

<!-- Breadcrumb -->
<div class="order-breadcrumb">
    <div class="order-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Orders</span>
    </div>
    <div class="order-beadcrumb-center">
        <label for="from-date" class="">From:</label>
        <div>
            <input type="date" name="from_date" id="from-date">
            <i class="fa-solid fa-calendar"></i>
        </div>
        <label for="to-date" class="">To:</label>
        <div>
            <input type="date" name="to_date" id="to-date">
            <i class="fa-solid fa-calendar"></i>
        </div>
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
        <tbody id="order-table-body">
            @include('admin.order.partials.order-table', ['orderdetails' => $orderdetails, 'orders' => $orders])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
 <div class="mobile-only" id="order-card-list">
     @include('admin.order.partials.order-card', ['orderdetails' => $orderdetails, 'orders' => $orders])
 </div>

<!-- Notification Container -->
<div id="notification-container"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const fromDate = document.getElementById('from-date');
    const toDate = document.getElementById('to-date');
    let typingTimer;
    const typingDelay = 500;

    function sendSearchRequest(page = 1) {
        const query = searchInput.value.trim();
        const from = fromDate.value;
        const to = toDate.value;

        const params = new URLSearchParams({
            query: query,
            'from-date': from,
            'to-date': to,
            page: page,
        });

        fetch(`{{ route('admin.order.ajaxSearch') }}?${params.toString()}`, {
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
            handleClickable(); // re-bind click events after DOM change
        })
        .catch(error => console.error('Search error:', error));
    }

    // Trigger typing delay for text search
    searchInput.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => sendSearchRequest(), typingDelay);
    });

    // Trigger immediately on date change
    fromDate.addEventListener('change', () => sendSearchRequest());
    toDate.addEventListener('change', () => sendSearchRequest());

    // Handle pagination clicks with current filters
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