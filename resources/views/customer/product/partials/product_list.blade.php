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
