@extends('customer.layout.layout')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: #2a2a2a;
            padding: 20px;
            border-right: 1px solid #404040;
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        .sidebar h3 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Price Range */
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
            color: #cccccc;
        }

        /* Categories */
        .categories {
            background-color: #333333;
            border-radius: 8px;
            padding: 20px;
        }

        .categories h4 {
            color: #ffffff;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .category-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            cursor: pointer;
            padding: 2px 0;
        }

        .category-item input[type="checkbox"] {
            margin-right: 10px;
            width: 16px;
            height: 16px;
            accent-color: #4CAF50;
        }

        .category-item label {
            color: #cccccc;
            font-size: 13px;
            cursor: pointer;
            user-select: none;
        }

        .category-item:hover label {
            color: #ffffff;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-status {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input, input[type="number"] {
            background-color: #404040;
            border: none;
            border-radius: 6px;
            padding: 10px 15px;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
            outline: none;
        }

        .search-bar input::placeholder {
            color: #888888;
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
            border: none;
            padding: 8px;
            border-radius: 4px;
            color: #cccccc;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .view-btn:hover,
        .view-btn.active {
            background-color: #555555;
            color: #ffffff;
        }

        .sort-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-section label {
            color: #cccccc;
            font-size: 14px;
        }

        .sort-select {
            background-color: #404040;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
            outline: none;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .products-grid.list-view {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .product-card {
            background-color: #2a2a2a;
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .product-card.list-item {
            flex-direction: row;
            align-items: center;
            padding: 20px;
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
            color: #888888;
            font-size: 14px;
            flex-shrink: 0;
        }

        .product-card.list-item .product-image {
            width: 120px;
            height: 80px;
            margin-bottom: 0;
            margin-right: 20px;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-card.list-item .product-info {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .product-details {
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .product-card.list-item .product-title {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #4CAF50;
            margin-bottom: 5px;
        }

        .product-card.list-item .product-price {
            font-size: 20px;
            margin-bottom: 0;
            text-align: right;
        }

        .product-category {
            font-size: 12px;
            color: #888888;
        }

        .product-card.list-item .product-category {
            font-size: 13px;
            margin-top: 5px;
        }

        .product-card.list-item .product-price-category {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
            text-align: left;
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

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
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
                justify-content: space-between;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }
            
            .view-controls {
                justify-content: space-between;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 15px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .search-section {
                flex-direction: column;
                align-items: stretch;
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
                    <input type="number" name="" id="">
                </div>
                
                <div class="price-input">
                    <label for="maxPrice">Max:</label>
                    <input type="number" name="" id="">
                </div>
            </div>
            
            <div class="categories">
                <h4>Category</h4>
                <div class="category-item">
                    <input type="checkbox" id="gaming-desktop" checked>
                    <label for="gaming-desktop">Gaming Desktop</label>
                </div>
                <div class="category-item">
                    <input type="checkbox" id="thin-light" checked>
                    <label for="thin-light">Thin and Light</label>
                </div>
                <div class="category-item">
                    <input type="checkbox" id="business-laptop" checked>
                    <label for="business-laptop">Business Laptop</label>
                </div>
                <div class="category-item">
                    <input type="checkbox" id="gaming-laptop" checked>
                    <label for="gaming-laptop">Gaming Laptop</label>
                </div>
                <div class="category-item">
                    <input type="checkbox" id="accessories" checked>
                    <label for="accessories">Accessories</label>
                </div>
            </div>
        </aside>
        
        <main class="main-content">
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
            
            <div class="products-grid" id="productsGrid">
                                 
            </div>
        </main>
    </div>
    
    
@endsection

@push('scripts')
    <script>

        // DOM elements
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuBtn = document.getElementById('menuBtn');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');

        gridView.onclick = () => {
            gridView.classList.add('active');
            listView.classList.remove('active');
        }

        listView.onclick = () => {
            gridView.classList.remove('active');
            listView.classList.add('active');
        }

        // Mobile menu toggle
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

    </script>
@endpush
