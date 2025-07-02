@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        /* Carousel */
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
            transition: background 0.3s ease;
            border-radius: 5px;
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
            padding: 1rem;
            background: var(--bg-1);
        }

        .top-selling > h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .top-selling a {
            color: var(--green);
            transition: color 0.3s ease;
        }

        .top-selling a:hover {
            color: #0a662e;
        }

        .selling-cards {
            display: flex;
            gap: 1rem;
        }


        .left, .right {
            width: 50%;
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
            transition: all .3s ease;
        }

        .first:hover, .second:hover, .third:hover {
            scale: 1.01;
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

        .description {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: start;
        }
        
        .first img {
            max-width: 300px;
        }

        .second img, .third img {
            max-width: 200px;
        }

        .second, .third {
            flex-direction: row-reverse;
            justify-content: space-between;
        }
             
        /* NEW ARRIVALS */
        .new-arrivals {
            background: var(--bg-1);
            padding: 2rem 1rem;
        }

        .new-arrivals h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        /* Card Container */
        .arrival-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        /* Card */
        .new-arrival-card {
            background: var(--bg-2);
            padding: 1rem;
            border-radius: .75rem;
            width: 100%;
            max-width: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .new-arrival-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Card Image */
        .new-arrival-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: .5rem;
        }

        /* Card Details */
        .card-lower {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .card-lower p {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-13);
        }

        .card-lower button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .card-lower button a {
            color: var(--green);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .card-lower button a:hover {
            color: #0a662e;
        }

        /* Responsive: Tablet */
        @media (max-width: 1024px) {
            .arrival-cards-container {
                gap: 1.5rem;
            }
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

            .selling-cards {
                flex-direction: column;
            }

            .left, .right{
                width: 100%;
            }

            .first {
                flex-direction: row-reverse;
            }

            .image img {
                max-width: 250px;
            }

            .new-arrival-card {
                max-width: 45%;
            }
        }

        @media (max-width: 425px) {
            .category-tags {
                gap: 1rem;
            }

            .tag a {
                width: 85px;
            }

            .first, .second, .third {
                flex-direction: column;
                gap: 1rem;
            }

            .new-arrival-card {
                max-width: 100%;
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
                        <img src="{{ asset('storage/' . $topSellings[0]->image) }}" alt="">
                    </div>
                    <div class="description">
                        <p>{{ $topSellings[0]->name }}</p>
                        <button style="color: var(--green);">
                            <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="second">
                    <div class="image">
                        <img src="{{ asset('storage/' . $topSellings[1]->image) }}" alt="">
                    </div>
                    <div class="description">
                        <p>{{ $topSellings[1]->name }}</p>
                        <button style="color: var(--green);">
                            <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
                <div class="third">
                    <div class="image">
                        <img src="{{ asset('storage/' . $topSellings[2]->image) }}" alt="">
                    </div>
                    <div class="description">
                        <p>{{ $topSellings[2]->name }}</p>
                        <button style="color: var(--green);">
                            <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Arrivals -->
     <div class="new-arrivals">
        <h2>NEW ARRIVALS</h2>
        <!-- New Arrival Cards -->
        <div class="arrival-cards-container">
            <div class="new-arrival-card">
                <div class="card-upper">
                    <img src="{{ asset('storage/' . $products[count($products) - 1]->image) }}" alt="">
                </div>
                <div class="card-lower">
                    <p>{{$products[count($products) - 1]->name}}</p>
                    <p>$ {{$products[count($products) - 1]->sale_price}}</p>
                    <button style="color: var(--green);">
                        <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>

            <div class="new-arrival-card">
                <div class="card-upper">
                    <img src="{{ asset('storage/' . $products[count($products) - 2]->image) }}" alt="">
                </div>
                <div class="card-lower">
                    <p>{{$products[count($products) - 2]->name}}</p>
                    <p>$ {{$products[count($products) - 2]->sale_price}}</p>
                    <button style="color: var(--green);">
                        <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>

            <div class="new-arrival-card">
                <div class="card-upper">
                    <img src="{{ asset('storage/' . $products[count($products) - 3]->image) }}" alt="">
                </div>
                <div class="card-lower">
                    <p>{{$products[count($products) - 3]->name}}</p>
                    <p>$ {{$products[count($products) - 3]->sale_price}}</p>
                    <button style="color: var(--green);">
                        <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>

            <div class="new-arrival-card">
                <div class="card-upper">
                    <img src="{{ asset('storage/' . $products[count($products) - 4]->image) }}" alt="">
                </div>
                <div class="card-lower">
                    <p>{{$products[count($products) - 4]->name}}</p>
                    <p>$ {{$products[count($products) - 4]->sale_price}}</p>
                    <button style="color: var(--green);">
                        <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>

            <div class="new-arrival-card">
                <div class="card-upper">
                    <img src="{{ asset('storage/' . $products[count($products) - 5]->image) }}" alt="">
                </div>
                <div class="card-lower">
                    <p>{{$products[count($products) - 5]->name}}</p>
                    <p>$ {{$products[count($products) - 5]->sale_price}}</p>
                    <button style="color: var(--green);">
                        <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
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
