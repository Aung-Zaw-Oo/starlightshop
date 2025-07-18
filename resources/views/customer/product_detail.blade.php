@extends('customer.layout.layout')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/customer/product_detail.css') }}">
@push('styles')
<style>
.product-image::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('storage/' . $product->image) }}');
    background-repeat: no-repeat;
    background-size: 150%; /* controls zoom level */
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    background-position: var(--bg-position, center);
    border-radius: var(--radius);
}
</style>

@endpush
@section('content')
    <div class="product-detail">
        <h2>PRODUCT DETAIL</h2>
        <div class="product">
            <div class="upper">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-stock"><i class="fa-solid fa-boxes-stacked"></i>
                        @if ($product->qty == 1)
                            {{ $product->qty }} Item In Stock.
                        @elseif ($product->qty > 1)
                            {{ $product->qty }} Items In Stock.
                        @else
                            Out of Stock
                        @endif
                    </p>

                    <p class="product-category">Category: {{ $product->category->name }}</p>
                    <p class="product-price">Price: ${{ $product->sale_price }}</p>
                    <div class="product-buttons">
                        <button class="add-to-cart-btn btn primary"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}"
                            data-price="{{ $product->sale_price }}"
                            data-image="{{ asset('storage/' . $product->image) }}"
                            data-category="{{ $product->category->name }}"
                            data-stock="{{ $product->qty }}"
                        >
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>Add To Cart</span>
                        </button>
                    </div>
                    <div class="options">
                        <p><i class="fa-solid fa-money-check-dollar"></i> &nbsp;&nbsp; Flexible Payment Options</p>
                        <p><i class="fa-solid fa-arrow-rotate-right"></i> &nbsp;&nbsp; Standard Return Within 28 Days</p>
                    </div>
                </div>
            </div>
            <div class="lower">
                <p>Product Description</p>
                @foreach (explode('-', ltrim($product->description, '-')) as $item)
                    <li style="list-style: none;">{{ $item }}</li>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Zoom Effect
        const productImage = document.querySelector('.product-image');

        productImage.addEventListener('mousemove', function (e) {
            const rect = productImage.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;

            productImage.style.setProperty('--x', `${xPercent}%`);
            productImage.style.setProperty('--y', `${yPercent}%`);

            productImage.style.setProperty('--bg-position', `${xPercent}% ${yPercent}%`);
            productImage.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
        });
    </script>
@endpush

