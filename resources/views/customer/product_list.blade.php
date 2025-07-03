@extends('customer.layout.layout')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
<style>
    :root {
        --green: #4CAF50;
        --color-8: #E5E5E5;
        --color-2: #2a2a2a;
        --btn-primary: #4CAF50;
        --btn-primary-hover: #3e9142;

        --transition: all 0.3s ease;
    }

    .main-content {
        padding: 1rem;
    }

    /* Remove default number arrows */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Layout */
    .container {
        display: flex;
        min-height: 100vh;
        gap: 1rem;
    }

    .main-section {
        flex: 1;
    }

    /* Sidebar */
    .sidebar {
        width: 280px;
        background-color: var(--color-2);
        padding: 20px;
        border-right: 1px solid #404040;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .sidebar h3 {
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .price-range {
        margin-bottom: 30px;
    }

    .price-input {
        margin-bottom: 15px;
    }

    .price-input label {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        color: #ccc;
    }

    .categories {
        background-color: #333;
        border-radius: 8px;
        padding: 20px;
    }

    .categories h4 {
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 15px;
    }

    .category-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .category-item input {
        margin-right: 10px;
        width: 16px;
        height: 16px;
        accent-color: var(--green);
    }

    .category-item label {
        font-size: 13px;
        color: #ccc;
        cursor: pointer;
    }

    .category-item:hover label {
        color: #fff;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }

    .search-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }

    .search-status {
        background-color: var(--green);
        color: #fff;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 8px;
    }

    .search-bar {
        position: relative;
        flex: 1;
    }

    .search-bar input,
    input[type="number"],
    .sort-select {
        background-color: #404040;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 14px;
        width: 100%;
        outline: none;
    }

    .search-bar input::placeholder {
        color: #888;
    }

    .view-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .view-toggle {
        display: flex;
        gap: 5px;
    }

    .view-btn {
        background-color: #404040;
        color: #ccc;
        border: none;
        padding: 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.2s;
    }

    .view-btn:hover,
    .view-btn.active {
        background-color: #555;
        color: #fff;
    }

    .sort-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sort-section label {
        color: #ccc;
        font-size: 14px;
        text-wrap: nowrap;
    }

    .sort-select {
        cursor: pointer;
    }

    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        transition: 0.3s ease;
    }

    .products-grid.list-view {
        grid-template-columns: 1fr;
    }

    .product-card {
        background-color: var(--color-2);
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        transition: 0.2s;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .product-image {
        width: 100%;
        height: 180px;
        background-color: #404040;
        border-radius: 6px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
    }

    .product-card.list-item .product-image {
        width: 120px;
        height: 80px;
        margin-right: 20px;
        margin-bottom: 0;
    }

    .product-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card.list-item .product-info {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .product-title {
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 5px;
    }

    .product-price {
        font-size: 18px;
        font-weight: 600;
        color: var(--green);
        margin-bottom: 5px;
    }

    .product-category {
        font-size: 12px;
        color: #888;
    }

    #selectAllBtn, #clearFiltersBtn {
        background-color: var(--green);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        border: none;
        cursor: pointer;
        margin-right: 8px;
        transition: 0.2s;
    }

    .btn:hover {
        background-color: var(--btn-primary-hover);
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 999;
    }

    .detail-btn a {
        color: var(--green);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-btn a:hover {
        color: #0a662e;
        transform: translateX(5px);
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 20px;
        text-align: center;
    }

    .pagination {
        display: inline-flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
        list-style: none;
        padding: 0;
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

    /* Responsive */
    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 80%;
            max-width: 280px;
            z-index: 1000;
            transform: translateX(-100%);
            overflow-y: auto;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .mobile-menu-btn {
            display: block;
        }

        .overlay.show {
            display: block;
        }

        .header {
            flex-direction: column;
            align-items: stretch;
        }

        .search-section {
            flex-direction: column;
            align-items: stretch;
        }

        .view-controls {
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .product-card.list-item {
            flex-direction: column;
        }

        .product-card.list-item .product-image {
            width: 100%;
            height: 180px;
            margin: 0 0 10px;
        }

        .product-card.list-item .product-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .main-section {
            padding: 1rem;
        }

        .search-status {
            font-size: 11px;
            padding: 6px 10px;
        }

        .btn {
            font-size: 11px;
            padding: 6px 10px;
        }

        .product-title {
            font-size: 14px;
        }

        .product-price {
            font-size: 16px;
        }

        .search-bar input,
        .sort-select,
        input[type="number"] {
            font-size: 13px;
            padding: 8px 12px;
        }
    }
</style>
@endpush


@section('content')
    <div class="container">
        <div class="overlay" id="overlay"></div>
        
        <aside class="sidebar" id="sidebar">
            <h3>Searching Info</h3>
            
            <div class="price-range">
                <div class="price-input">
                    <label for="minPrice">Min:</label>
                    <input type="number" name="" id="minPrice">
                </div>
                
                <div class="price-input">
                    <label for="maxPrice">Max:</label>
                    <input type="number" name="" id="maxPrice">
                </div>
            </div>
            
            <div class="categories">
                <h4>Category</h4>

                <div class="filter-actions" style="margin-bottom: 1rem;">
                    <button type="button" id="selectAllBtn" class="btn">Select All</button>
                    <button type="button" id="clearFiltersBtn" class="btn">Clear Filters</button>
                </div>

                @foreach ($categories as $category)
                    <div class="category-item">
                        <input type="checkbox" id="category-{{ $category->id }}" checked>
                        <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
        </aside>
        
        <main class="main-section">
            <div class="header">
                <div class="search-section">
                    <button class="mobile-menu-btn" id="menuBtn">☰</button>
                    <div class="search-status">Searching</div>
                    <div class="search-bar">
                        <input type="text" placeholder="Search Product......" id="searchInput">
                    </div>
                </div>
                
                <div class="view-controls">
                    <div class="view-toggle">
                        <button class="view-btn active" id="gridView">⊞</button>
                        <button class="view-btn" id="listView">☰</button>
                    </div>
                    
                    <div class="sort-section">
                        <label for="sortSelect">Sort by</label>
                        <select class="sort-select" id="sortSelect">
                            <option value="price-low">Lower to higher</option>
                            <option value="price-high">Higher to lower</option>
                            <option value="name-asc">Name A-Z</option>
                            <option value="name-desc">Name Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="products-grid grid-view" id="productsGrid">

                @foreach ($products as $product)
                    <div class="product-card list-item"
                        data-name="{{ strtolower($product->name) }}"
                        data-category-id="{{ $product->category_id }}"
                        data-price="{{ $product->sale_price }}"
                    >
                        <div class="card-header">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                        </div>
                        <div class="card-body">
                            <div class="product-title">
                                {{ $product->name }}
                            </div>
                            <div class="product-price">
                                {{ $product->sale_price }}
                            </div>
                            <div class="product-category">
                                {{ $product->category->name }}
                            </div>
                            <button class="detail-btn">
                                <a href="{{ route('customer.product_detail', $product->id) }}">More Detail <i class="fas fa-arrow-right"></i> </a>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    <div class="pagination-wrapper">
            {{ $products->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>
@endsection

@push('scripts')
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');

    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const productsGrid = document.getElementById('productsGrid');
    const viewButtons = document.querySelectorAll('.view-btn');
    const searchInput = document.getElementById('searchInput');
    const categoryCheckboxes = document.querySelectorAll('.category-item input[type="checkbox"]');
    const sortSelect = document.getElementById('sortSelect');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');

    const productCards = document.querySelectorAll('.product-card');

    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');

    // Grid/List View
    gridView.onclick = () => {
        productsGrid.classList.remove('list-view');
        viewButtons.forEach(btn => btn.classList.remove('active'));
        gridView.classList.add('active');
    };

    listView.onclick = () => {
        productsGrid.classList.add('list-view');
        viewButtons.forEach(btn => btn.classList.remove('active'));
        listView.classList.add('active');
    };

    // Sidebar Toggle
    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

        // Select All Categories
    selectAllBtn.addEventListener('click', () => {
        categoryCheckboxes.forEach(cb => cb.checked = true);
        filterProducts();
    });

    // Clear All Filters
    clearFiltersBtn.addEventListener('click', () => {
        searchInput.value = '';
        minPriceInput.value = '';
        maxPriceInput.value = '';
        categoryCheckboxes.forEach(cb => cb.checked = false);
        sortSelect.selectedIndex = 0;
        filterProducts();
    });

    // Filter logic
    function filterProducts() {
        const search = searchInput.value.toLowerCase();
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.id.replace('category-', ''));

        const min = minPriceInput.value ? parseFloat(minPriceInput.value) : 0;
        const max = maxPriceInput.value ? parseFloat(maxPriceInput.value) : Infinity;

        productCards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const price = parseFloat(card.dataset.price);
            const categoryId = card.dataset.categoryId;

            const matchName = name.includes(search);
            const matchCategory = selectedCategories.includes(categoryId);
            const matchPrice = price >= min && price <= max;

            if (matchName && matchCategory && matchPrice) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        sortProducts(); // re-sort after filtering
    }

    // Sorting logic
    function sortProducts() {
        const sortValue = sortSelect.value;
        const cardsArray = Array.from(productCards).filter(card => card.style.display !== 'none');

        cardsArray.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            const nameA = a.dataset.name;
            const nameB = b.dataset.name;

            switch (sortValue) {
                case 'price-low':
                    return priceA - priceB;
                case 'price-high':
                    return priceB - priceA;
                case 'name-asc':
                    return nameA.localeCompare(nameB);
                case 'name-desc':
                    return nameB.localeCompare(nameA);
                default:
                    return 0;
            }
        });

        // Re-append sorted cards
        cardsArray.forEach(card => productsGrid.appendChild(card));
    }

    // Event Listeners
    searchInput.addEventListener('input', filterProducts);
    categoryCheckboxes.forEach(cb => cb.addEventListener('change', filterProducts));
    sortSelect.addEventListener('change', sortProducts);
    minPriceInput?.addEventListener('input', filterProducts);
    maxPriceInput?.addEventListener('input', filterProducts);
</script>
@endpush

