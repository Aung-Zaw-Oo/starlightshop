@extends('customer.layout.layout')

@section('title', 'Products')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/customer/product_list.css') }}">
@endpush

@section('content')
<h2 style="text-align: center; margin-bottom: calc(var(--margin) * 2);">OUR PRODUCTS</h2>
    <div class="container">
        <div class="overlay" id="overlay"></div>
        
        <aside class="sidebar" id="sidebar">
            <h3>Searching Info</h3>
            
            <div class="price-range">
                <div class="price-input">
                    <label for="minPrice">Min Price:</label>
                    <input type="number" id="minPrice" placeholder="Please enter mininal price.">
                </div>
                
                <div class="price-input">
                    <label for="maxPrice">Max Price:</label>
                    <input type="number" id="maxPrice" placeholder="Please enter maximum price.">
                </div>
            </div>
            
            <div class="categories">
                <h4>Category</h4>

                <div class="filter-actions" style="margin-bottom: 1rem;">
                    <button type="button" id="selectAllBtn" class="btn primary">Select All</button>
                    <button type="button" id="clearFiltersBtn" class="btn primary">Clear Filters</button>
                </div>

                @php
                    $selectedCategories = request()->has('category')
                        ? [request()->get('category')]
                        : explode(',', request()->get('categories', ''));
                @endphp

                @foreach ($categories as $category)
                    <div class="category-item">
                        <input
                            type="checkbox"
                            id="category-{{ $category->id }}"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                        >
                        <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
        </aside>
        
        <main class="main-section">
            <div class="header">
                <div class="search-section">
                    <button class="mobile-menu-btn" id="menuBtn">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="search-bar">
                        <input type="text" placeholder="Search Product......" id="searchInput">
                    </div>
                </div>
                
                <div class="view-controls">
                    <div class="view-toggle">
                        <button class="view-btn active" id="gridView">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" id="listView">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    
                    <div class="sort-section">
                        <label for="sortSelect">Sort by</label>
                        <select class="sort-select" id="sortSelect">
                            <option value="all">All Products</option>
                            <option value="price-low">Lower to higher</option>
                            <option value="price-high">Higher to lower</option>
                            <option value="name-asc">Name A-Z</option>
                            <option value="name-desc">Name Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div id="ajaxProductContainer">
                @include('customer.product.partials.product_list', ['products' => $products])
            </div>
            
            <div class="pagination-wrapper" id="paginationWrapper">
                {{ $products->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </main>
    </div>
@endsection

@push('scripts')
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const ajaxProductContainer = document.getElementById('ajaxProductContainer');
    let productsGrid = document.getElementById('productsGrid');
    const viewButtons = document.querySelectorAll('.view-btn');
    const searchInput = document.getElementById('searchInput');
    const categoryCheckboxes = document.querySelectorAll('.category-item input[type="checkbox"]');
    const sortSelect = document.getElementById('sortSelect');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');

    let currentView = 'grid'; // default

    gridView.addEventListener('click', () => {
        currentView = 'grid';
        gridView.classList.add('active');
        listView.classList.remove('active');
        productsGrid.classList.add('grid-view');
        productsGrid.classList.remove('list-view');
        applyViewMode();
    });

    listView.addEventListener('click', () => {
        currentView = 'list';
        gridView.classList.remove('active');
        listView.classList.add('active');
        productsGrid.classList.add('list-view');
        productsGrid.classList.remove('grid-view');
        applyViewMode();
    });

    function applyViewMode() {
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            if (currentView === 'list') {
                card.classList.add('list-item');
            } else {
                card.classList.remove('list-item');
            }
        });
    }

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    selectAllBtn.addEventListener('click', () => {
        categoryCheckboxes.forEach(cb => cb.checked = true);
        filterProducts();
    });

    clearFiltersBtn.addEventListener('click', () => {
        searchInput.value = '';
        minPriceInput.value = '';
        maxPriceInput.value = '';
        categoryCheckboxes.forEach(cb => cb.checked = false);
        sortSelect.selectedIndex = 0;
        filterProducts();
    });

    function getSelectedCategories() {
        return Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.id.replace('category-', ''))
            .join(',');
    }

    function fetchProducts(page = 1) {
        const search = searchInput.value.trim();
        const categories = getSelectedCategories();
        const minPrice = minPriceInput.value.trim();
        const maxPrice = maxPriceInput.value.trim();
        const sort = sortSelect.value;

        const params = new URLSearchParams({
            search,
            categories,
            minPrice,
            maxPrice,
            sort,
            page
        });

        fetch(`{{ route('customer.products.ajaxSearch') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('ajaxProductContainer').innerHTML = data.html;
            document.getElementById('paginationWrapper').innerHTML = data.pagination;

            // Reassign productsGrid and reapply view
            productsGrid = document.getElementById('productsGrid');

            if (currentView === 'list') {
                productsGrid.classList.add('list-view');
                productsGrid.classList.remove('grid-view');
            } else {
                productsGrid.classList.add('grid-view');
                productsGrid.classList.remove('list-view');
            }

            applyViewMode();
            attachPaginationLinks();
            handleClickable();
        })
        .catch(err => {
            console.error('AJAX fetch error:', err);
            document.getElementById('ajaxProductContainer').innerHTML = '<p>Error loading products. Please try again.</p>';
        });
    }

    function filterProducts() {
        fetchProducts(1);
    }

    function attachPaginationLinks() {
        document.querySelectorAll('#paginationWrapper a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                fetchProducts(page);
            });
        });
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(filterProducts, 300);
    });

    categoryCheckboxes.forEach(cb => cb.addEventListener('change', filterProducts));
    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);
    sortSelect.addEventListener('change', filterProducts);

    attachPaginationLinks();
    handleClickable();
    fetchProducts(1);
</script>
@endpush