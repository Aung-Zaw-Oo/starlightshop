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
    }

    .product-image img {
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        background-color: #333;
    }

    .product-info {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        min-width: 250px;
    }

    .product-name {
        font-size: 22px;
        font-weight: bold;
    }

    .product-stock,
    .product-price,
    .product-category {
        font-size: 16px;
        color: #E5E5E5;
    }

    .lower {
        border-top: 1px solid #555;
        padding-top: 1rem;
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

        .product-info {
            gap: 0.5rem;
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

    .product-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        min-width: 130px;
    }

    .add-to-cart {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        transition: background-color 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #3e8e41;
    }

    .back {
        background-color: #f44336;
        color: #fff;
        border: none;
        transition: background-color 0.3s ease;
    }

    .back:hover {
        background-color: #d32f2f;
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
                    <p class="product-stock"><i class="fa-solid fa-boxes-stacked"></i> {{ $product->qty }} Items instock.</p>
                    <p class="product-category">Category: {{ $product->category->name }}</p>
                    <p class="product-price">Price: {{ $product->sale_price }}</p>
                    <div class="product-buttons">
                        <button class="add-to-cart">
                            <a href=""><i class="fa-solid fa-cart-plus"></i> Add To Cart</a>
                        </button>
                        <button class="back">
                            <a href="{{ route('customer.product_list') }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
                        </button>
                    </div>
                </div>
                
            </div>
            <div class="lower">
                <p class="product-description">Description: {{ $product->description }}</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

