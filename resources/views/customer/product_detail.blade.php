@extends('customer.layout.layout')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    @push('styles')
<style>
    .product-detail {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        color: #fff;
    }

    .product-detail > h2 {
        text-align: center;
        margin-bottom: 2rem;
        font-size: 24px;
    }

    .product {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .upper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .product-image {
        min-width: 250px;
        display: flex;
        justify-content: center;
        align-items: center;

        position: relative;
    overflow: hidden;
    }

    .product-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        background-color: #333;
    }

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

}

.product-image:hover::after {
    opacity: 1;
}

.product-image:hover img {
    opacity: 0;
}

    .product-info {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        min-width: 250px;
    }

    .product-name {
        font-size: 2rem;
        font-weight: bold;
    }

    .product-stock,
    .product-price,
    .product-category {
        font-size: 1.25rem;
    }

    .product-price{
        color: var(--green);
        font-weight: bold;
    }

    .product-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .add-to-cart, .back {
    display: inline-block;
    text-align: center;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    min-width: 130px;
    font-size: 14px;
    transition: background-color 0.3s ease;
    }

    .add-to-cart {
        background-color: #4CAF50;
        color: #fff;
    }

    .add-to-cart:hover {
        background-color: #3e8e41;
    }

    .back {
        background-color: #f44336;
        color: #fff;
    }

    .back:hover {
        background-color: #d32f2f;
    }


    .options {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        background-color: var(--color-2);
        padding: 10px 20px;
        border-radius: 5px;
    }

    .lower {
        border-top: 1px solid #555;
        padding-top: 1rem;
    }

    .lower p:first-child {
    font-weight: bold;
    margin-bottom: 0.5rem;
    font-size: 16px;
    }

    .product-description {
        font-size: 15px;
        line-height: 1.6;
        color: #ccc;
    }

    @media (max-width: 768px) {
        .upper {
            display: flex;
            flex-direction: column;
        }

        .product-info, .options {
            gap: 1rem;
        }

        .product-name {
            font-size: 20px;
        }

        .product-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .product-detail h2 {
            font-size: 20px;
        }

        .product-name {
            font-size: 18px;
        }

        .product-stock,
        .product-price,
        .product-category,
        .product-description {
            font-size: 14px;
        }
    }
</style>
@endpush

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
                        <button class="add-to-cart add-to-cart-btn"
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
                        <a href="{{ route('customer.product_list') }}" class="back"><i class="fa-solid fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="options">
                        <p><i class="fa-solid fa-money-check-dollar"></i> &nbsp;&nbsp; Flexible Payment Options</p>
                        <p><i class="fa-solid fa-arrow-rotate-right"></i> &nbsp;&nbsp; Standard Return Within 28 Days</p>
                    </div>
                </div>
            </div>
            <div class="lower">
                <p>Product Description</p>
                <p class="product-description">{{ $product->description }}</p>
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

