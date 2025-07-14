@extends('admin.layout.layout')

@section('title', 'Products')

@section('content')
<!-- Notification Container -->
<div id="notification-container"></div>

<!-- Breadcrumb -->
<div class="product-breadcrumb">
    <div class="product-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Products</span>
        <div>
            <select name="category" id="category" required>
                <option value="" selected disabled>Select Category</option>
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="product-beadcrumb-center">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" id="search" placeholder="search">
        </div> 
    </div>
    <div class="product-beadcrumb-right">
         <a href="{{ route('admin.product.create') }}" class="btn primary"><i class="fa-solid fa-plus"></i> Add</a>
    </div>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-only">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Category</th>
                <th>Sale Price</th>
                <th>Purchase Price</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody id="product-table-body">
            @include('admin.product.partials.product-table', ['products' => $products])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-only" id="product-card-list">
    @include('admin.product.partials.product-card', ['products' => $products])
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    let typingTimer;
    const typingDelay = 500;

    function sendSearchRequest(page = 1) {
        const query = searchInput.value.trim();
        const category = categorySelect.value;

        const params = new URLSearchParams({
            query: query,
            category: category,
            page: page
        });

        fetch(`{{ route('admin.product.ajaxSearch') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-Device': window.innerWidth <= 1024 ? 'mobile' : 'desktop'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (window.innerWidth <= 1024) {
                document.querySelector('#product-card-list').innerHTML = html;
            } else {
                document.querySelector('#product-table-body').innerHTML = html;
            }
            handleClickable();
        })
        .catch(error => console.error('Search error:', error));
    }

    // Trigger AJAX on typing in search input
    searchInput.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => sendSearchRequest(), typingDelay);
    });

    // Trigger AJAX on category change
    categorySelect.addEventListener('change', () => {
        sendSearchRequest();
    });

    // Handle pagination clicks
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