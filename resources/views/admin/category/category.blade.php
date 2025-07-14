@extends('admin.layout.layout')

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
    @include('admin.category.partials.category-card', ['categories' => $categories])
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
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
                    'X-Device': window.innerWidth <= 1024 ? 'mobile' : 'desktop'
                }
            })
            .then(response => response.text())
            .then(html => {
                if (window.innerWidth <= 1024) {
                    document.querySelector('#category-card-list').innerHTML = html;
                } else {
                    document.querySelector('#category-table-body').innerHTML = html;
                }
                handleClickable();
            })
            .catch(error => console.error('Search error:', error));
        }, typingDelay);
    });
});
</script>
@endpush