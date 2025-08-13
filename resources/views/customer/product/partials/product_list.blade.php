<div class="products-grid grid-view" id="productsGrid">
    @foreach ($products as $product)
        <div class="product-card clickable-card"
            data-name="{{ strtolower($product->name) }}"
            data-category-id="{{ $product->category_id }}"
            data-price="{{ $product->sale_price }}"
            data-href="{{ route('customer.product_detail', $product->id) }}"
        >
            <div class="card-header">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
            </div>
            <div class="card-body">
                <div class="product-info">
                    <div>
                        <div class="product-title">
                            {{ \Illuminate\Support\Str::limit($product->name,40) }}
                        </div>
                    </div>
                    <div>
                        <div class="product-price">
                            $ {{ number_format($product->sale_price,2) }}
                        </div>
                        <div class="product-category">
                            {{ $product->category->name }}
                        </div>
                        <button class="detail-btn">
                            <a href="{{ route('customer.product_detail', $product->id) }}">More Detail <i class="fas fa-arrow-right"></i> </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
