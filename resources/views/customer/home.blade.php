@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
    /* Carousel Container */
        .carousel {
            position: relative;
            width: 75%;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 10px;
            padding: 50px 0;
        }

        /* Slides Wrapper */
        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            display: flex;
            flex-direction: row;
            height: 300px;
        }

        .slide-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 20px;
            padding-left: 4rem;
            gap: 1rem;
        }

        .slide-content h2 {
            font-size: 2rem;
        }        

        .slide-image {
            flex: 1;
            overflow: hidden;
            padding-right: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 4 / 3;
        }

        .slide-image img {
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }


        /* Buttons */
        .buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 2;
        }

        .buttons button {
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 10px 20px;
            cursor: pointer;
            transition: background 0.3s;
            border-radius: 5px;
        }

        .buttons button:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        /* Dots */
        .dots {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .dot {
            display: inline-block;
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dot.active {
            background-color: #333;
        }

        .categories {
            background-color: var(--bg-1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .categories > h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .category-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            /* padding: 1rem; */
        }

        .tag {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tag a {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .tag img {
            width: 50px;
            height: auto;
            display: block;
            border-radius: 0.5rem;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .tag img:hover {
            transform: scale(1.1);
        }

        .top-selling {
            padding: 2rem;
            background: var(--bg-1);
        }

        .top-selling > h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .selling-cards {
            display: flex;
            gap: 1rem;
        }

        .left, .right {
            width: 50%;
            /* padding: 2rem; */
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .left > div, .right > div {
            background: var(--bg-2);
        }

        .first, .second, .third {
            width: 100%;
            padding: 2rem;
            display: flex;
            border-radius: .5rem;
        }

        .first {
            flex-direction: column;
            justify-content: space-between;
        }

        .image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .second, .third {
            flex-direction: row-reverse;
            justify-content: space-between;
        }


        /* Responsive: Tablet */
        @media (max-width: 1024px) {
            
        }

        /* Responsive: Mobile */
        @media (max-width: 768px) {
            .carousel {
                width: 100%;
                border-radius: 0;
            }

            .slide {
                flex-direction: column;
            }

            .slide-content {
                display: none;
            }

            .slide-image {
                flex: 1;
                padding: 0;
            }
        }

        @media (max-width: 425px) {
            .category-tags {
                gap: 1rem;
            }

            .tag a {
                width: 85px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Carousel -->
    <div class="carousel">
        <div class="slides" id="slideContainer">
            <div class="slide">
                <div class="slide-content">
                    <h2>
                        {{ $products[count($products) - 3]->description }}
                    </h2>
                    <button>Shop Collection</button>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 3]->image) }}" alt="Slide 1">
                </div>
            </div>
            <div class="slide">
                <div class="slide-content">
                    <h2>
                        {{ $products[count($products) - 2]->description }}
                    </h2>
                    <button>Shop Collection</button>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 2]->image) }}" alt="Slide 2">
                </div>
            </div>
            <div class="slide">
                <div class="slide-content">
                    <h2>
                        {{ $products[count($products) - 1]->description }}
                    </h2>
                    <button>Shop Collection</button>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 1]->image) }}" alt="Slide 3">
                </div>
            </div>
        </div>
        <div class="buttons">
            <button onclick="prevSlide()">❮</button>
            <button onclick="nextSlide()">❯</button>
        </div>
    </div>

    <!-- Carousel Dots -->
    <div class="dots">
        <span class="dot" onclick="showSlide(0)"></span>
        <span class="dot" onclick="showSlide(1)"></span>
        <span class="dot" onclick="showSlide(2)"></span>
    </div>

    <!-- Categories -->
    <div class="categories">
        <h2>CATEGORIES</h2>
        <div class="category-tags">
            @foreach ($categories as $category)
            <div class="tag">
                <a href="/category/{{ $category->id }}">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="">
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top Selling -->
    <div class="top-selling">
        <h2>TOP SELLING</h2>
        <div class="selling-cards">
            <div class="left">
                <div class="first">
                    <div class="image">
                        <img src="" alt="">
                        {{ $topSellings[0]->name }}
                    </div>
                    <div class="description">desc</div>
                </div>
            </div>
            <div class="right">
                <div class="second">
                    <div class="image">image</div>
                    <div class="description">desc</div>
                </div>
                <div class="third">
                    <div class="image">image</div>
                    <div class="description">desc</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const slideContainer = document.getElementById('slideContainer');
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let index = 0;

        function showSlide(i) {
            if (i < 0) index = slides.length - 1;
            else if (i >= slides.length) index = 0;
            else index = i;

            slideContainer.style.transform = `translateX(${-index * 100}%)`;

            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === index);
            });
        }

        function nextSlide() {
            showSlide(index + 1);
        }

        function prevSlide() {
            showSlide(index - 1);
        }

        setInterval(nextSlide, 5000);
        showSlide(index);
    </script>
@endpush
