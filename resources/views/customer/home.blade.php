@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        :root {
            --bg-1: #f8f9fa;
            --bg-2: #ffffff;
            --text-13: #333333;
            --green: #28a745;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --border-radius: 0.5rem;
            --transition: all 0.3s ease;
        }

        /* CAROUSEL SECTION */
        .carousel {
            position: relative;
            width: min(75%, 1200px);
            margin: 0 auto;
            padding: 3rem 0 0 0;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            display: flex;
            height: 350px;
        }

        .slide-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 4rem;
            gap: 1.5rem;
            color: white;
        }

        .slide-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin: 0;
        }

        .slide-content a {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            backdrop-filter: blur(10px);
            align-self: flex-start;
        }

        .slide-content a:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .slide-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .slide-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: var(--border-radius);
        }

        /* Carousel Controls */
        .carousel-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 10;
            padding: 0 1rem;
        }

        .carousel-btn {
            background: rgba(0, 0, 0, 0.7);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            backdrop-filter: blur(5px);
        }

        .carousel-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 1rem 0 3rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ccc;
            cursor: pointer;
            transition: var(--transition);
        }

        .dot.active {
            background: var(--green);
            transform: scale(1.2);
        }

        /* CATEGORIES SECTION */
        .categories {
            background: var(--bg-1);
            padding: 4rem 2rem;
            text-align: center;
        }

        .categories h2 {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--text-13);
            font-weight: 700;
        }

        .category-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .tag {
            transition: var(--transition);
        }

        .tag:hover {
            transform: translateY(-5px);
        }

        .tag a {
            display: block;
            text-decoration: none;
        }

        .tag img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .tag img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* TOP SELLING SECTION */
        .top-selling {
            padding: 4rem 2rem;
            background: var(--bg-2);
        }

        .top-selling h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--text-13);
            font-weight: 700;
        }

        .selling-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .selling-card {
            background: var(--bg-1);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            gap: 1.5rem;
        }

        .selling-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .selling-card.featured {
            grid-column: 1;
            grid-row: 1 / 3;
            flex-direction: column;
            text-align: center;
        }

        .selling-card img {
            max-width: 200px;
            height: auto;
            object-fit: contain;
            border-radius: var(--border-radius);
        }

        .selling-card.featured img {
            max-width: 300px;
            margin: 0 auto;
        }

        .card-description {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
        }

        .card-description h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-13);
            margin: 0;
        }

        .shop-now-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .shop-now-btn a {
            color: var(--green);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .shop-now-btn a:hover {
            color: #0a662e;
            transform: translateX(5px);
        }

        /* NEW ARRIVALS SECTION */
        .new-arrivals {
            background: var(--bg-1);
            padding: 4rem 2rem;
        }

        .new-arrivals h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--text-13);
            font-weight: 700;
        }

        .arrival-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .new-arrival-card {
            background: var(--bg-2);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }

        .new-arrival-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .new-arrival-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        .card-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-details h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-13);
            margin: 0;
        }

        .card-details .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--green);
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 1024px) {
            .carousel {
                width: 90%;
            }

            .selling-cards {
                grid-template-columns: 1fr;
            }

            .selling-card.featured {
                grid-column: 1;
                grid-row: auto;
            }
        }

        @media (max-width: 768px) {
            .carousel {
                width: 100%;
                margin: 2rem 0;
                border-radius: 0;
            }

            .slide {
                flex-direction: column;
                height: auto;
                min-height: 400px;
            }

            .slide-content {
                padding: 2rem;
                text-align: center;
            }

            .slide-image {
                padding: 1rem 2rem 2rem;
            }

            .categories, .top-selling, .new-arrivals {
                padding: 3rem 1rem;
            }

            .categories h2, .top-selling h2, .new-arrivals h2 {
                font-size: 2rem;
            }

            .selling-card {
                flex-direction: column;
                text-align: center;
            }

            .selling-card img {
                max-width: 250px;
                margin: 0 auto;
            }

            .arrival-cards-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .carousel-controls {
                display: none;
            }

            .slide-content {
                padding: 1.5rem;
            }

            .slide-content h2 {
                font-size: 1.5rem;
            }

            .category-tags {
                gap: 1rem;
            }

            .tag img {
                width: 60px;
                height: 60px;
            }

            .selling-card {
                padding: 1.5rem;
            }

            .arrival-cards-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Carousel -->
    <div class="carousel">
        <div class="slides" id="slideContainer">
            <div class="slide">
                <div class="slide-content">
                    <h2>{{ $products[count($products) - 3]->description }}</h2>
                    <a href="{{ route('customer.product_detail', $products[count($products) - 3]->id) }}">Shop Collection</a>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 3]->image) }}" alt="{{ $products[count($products) - 3]->name }}">
                </div>
            </div>
            <div class="slide">
                <div class="slide-content">
                    <h2>{{ $products[count($products) - 2]->description }}</h2>
                    <a href="{{ route('customer.product_detail', $products[count($products) - 2]->id) }}">Shop Collection</a>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 2]->image) }}" alt="{{ $products[count($products) - 2]->name }}">
                </div>
            </div>
            <div class="slide">
                <div class="slide-content">
                    <h2>{{ $products[count($products) - 1]->description }}</h2>
                    <a href="{{ route('customer.product_detail', $products[count($products) - 1]->id) }}">Shop Collection</a>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('storage/' . $products[count($products) - 1]->image) }}" alt="{{ $products[count($products) - 1]->name }}">
                </div>
            </div>
        </div>
        
        <div class="carousel-controls">
            <button class="carousel-btn" id="prevBtn" aria-label="Previous slide">❮</button>
            <button class="carousel-btn" id="nextBtn" aria-label="Next slide">❯</button>
        </div>
    </div>

    <!-- Carousel Dots -->
    <div class="dots" id="dotsContainer">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
        <span class="dot" data-slide="2"></span>
    </div>

    <!-- Categories -->
    <section class="categories">
        <h2>CATEGORIES</h2>
        <div class="category-tags">
            @foreach ($categories as $category)
                <div class="tag">
                    <a href="/category/{{ $category->id }}" title="{{ $category->name }}">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Top Selling -->
    <section class="top-selling">
        <h2>TOP SELLING</h2>
        <div class="selling-cards">
            <div class="selling-card featured">
                <img src="{{ asset('storage/' . $topSellings[0]->image) }}" alt="{{ $topSellings[0]->name }}">
                <div class="card-description">
                    <h3>{{ $topSellings[0]->name }}</h3>
                    <button class="shop-now-btn">
                        <a href="{{ route('customer.product_detail', $topSellings[0]->id) }}">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
            
            <div class="selling-card">
                <img src="{{ asset('storage/' . $topSellings[1]->image) }}" alt="{{ $topSellings[1]->name }}">
                <div class="card-description">
                    <h3>{{ $topSellings[1]->name }}</h3>
                    <button class="shop-now-btn">
                        <a href="{{ route('customer.product_detail', $topSellings[1]->id) }}">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
            
            <div class="selling-card">
                <img src="{{ asset('storage/' . $topSellings[2]->image) }}" alt="{{ $topSellings[2]->name }}">
                <div class="card-description">
                    <h3>{{ $topSellings[2]->name }}</h3>
                    <button class="shop-now-btn">
                        <a href="{{ route('customer.product_detail', $topSellings[2]->id) }}">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="new-arrivals">
        <h2>NEW ARRIVALS</h2>
        <div class="arrival-cards-container">
            @for ($i = 1; $i <= 5; $i++)
                <div class="new-arrival-card">
                    <img src="{{ asset('storage/' . $products[count($products) - $i]->image) }}" alt="{{ $products[count($products) - $i]->name }}">
                    <div class="card-details">
                        <h3>{{ $products[count($products) - $i]->name }}</h3>
                        <p class="price">${{ $products[count($products) - $i]->sale_price }}</p>
                        <button class="shop-now-btn">
                            <a href="#">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            @endfor
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        class CarouselManager {
            constructor() {
                this.slideContainer = document.getElementById('slideContainer');
                this.slides = document.querySelectorAll('.slide');
                this.dots = document.querySelectorAll('.dot');
                this.prevBtn = document.getElementById('prevBtn');
                this.nextBtn = document.getElementById('nextBtn');
                this.currentIndex = 0;
                this.isAutoPlaying = true;
                this.autoPlayInterval = null;
                
                this.init();
            }

            init() {
                this.bindEvents();
                this.startAutoPlay();
                this.showSlide(0);
            }

            bindEvents() {
                this.prevBtn.addEventListener('click', () => {
                    this.pauseAutoPlay();
                    this.prevSlide();
                });

                this.nextBtn.addEventListener('click', () => {
                    this.pauseAutoPlay();
                    this.nextSlide();
                });

                this.dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        this.pauseAutoPlay();
                        this.showSlide(index);
                    });
                });

                // Pause on hover
                this.slideContainer.addEventListener('mouseenter', () => {
                    this.pauseAutoPlay();
                });

                this.slideContainer.addEventListener('mouseleave', () => {
                    this.startAutoPlay();
                });

                // Touch/swipe support
                this.addTouchSupport();
            }

            showSlide(index) {
                if (index < 0) {
                    this.currentIndex = this.slides.length - 1;
                } else if (index >= this.slides.length) {
                    this.currentIndex = 0;
                } else {
                    this.currentIndex = index;
                }

                const translateX = -this.currentIndex * 100;
                this.slideContainer.style.transform = `translateX(${translateX}%)`;

                // Update dots
                this.dots.forEach((dot, idx) => {
                    dot.classList.toggle('active', idx === this.currentIndex);
                });
            }

            nextSlide() {
                this.showSlide(this.currentIndex + 1);
            }

            prevSlide() {
                this.showSlide(this.currentIndex - 1);
            }

            startAutoPlay() {
                if (!this.isAutoPlaying) return;
                
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            }

            pauseAutoPlay() {
                if (this.autoPlayInterval) {
                    clearInterval(this.autoPlayInterval);
                    this.autoPlayInterval = null;
                }
            }

            addTouchSupport() {
                let startX = 0;
                let startY = 0;
                let endX = 0;
                let endY = 0;
                const minSwipeDistance = 50;

                this.slideContainer.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                });

                this.slideContainer.addEventListener('touchend', (e) => {
                    endX = e.changedTouches[0].clientX;
                    endY = e.changedTouches[0].clientY;

                    const deltaX = startX - endX;
                    const deltaY = startY - endY;

                    // Check if horizontal swipe is more significant than vertical
                    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
                        if (deltaX > 0) {
                            this.nextSlide();
                        } else {
                            this.prevSlide();
                        }
                    }
                });
            }
        }

        // Initialize carousel when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new CarouselManager();
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush