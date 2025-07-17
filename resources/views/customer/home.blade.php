@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">

@section('content')
    <div class="carousel-container">
        <div class="carousel">
            <!-- Slides Container -->
            <div class="slides" id="slideContainer">
                @php
                    $latestProducts = array_slice($products->toArray(), -3);
                @endphp

                @foreach ($latestProducts as $index => $product)
                    <div class="slide">
                        <div class="slide-content">
                            <h2>{{ $product['name'] }}</h2>
                            <p>{{ $product['description'] }}</p>
                            <a href="{{ route('customer.product_detail', $product['id']) }}" class="btn primary">Shop Collection</a>
                        </div>
                        <div class="slide-image">
                            <img src="{{ asset('storage/' . $product['image']) }}"
                                alt="{{ $product['name'] }}"
                                loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <div class="carousel-controls">
                <button class="carousel-btn" id="prevBtn" aria-label="Previous slide">❮</button>
                <button class="carousel-btn" id="nextBtn" aria-label="Next slide">❯</button>
            </div>

            <!-- Carousel Dots -->
            <div class="dots" id="dotsContainer">
                @foreach ($latestProducts as $index => $product)
                    <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                @endforeach
            </div>
        </div>
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
    <!-- <section class="top-selling">
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
    </section> -->

    <!-- New Arrivals -->
    <!-- <section class="new-arrivals">
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
    </section> -->
@endsection

@push('scripts')
<script>
    const slideContainer = document.getElementById('slideContainer');
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;
    const totalSlides = slides.length;

    // Grab transition duration from CSS variable (optional fallback)
    const rootStyles = getComputedStyle(document.documentElement);
    const transitionTime = rootStyles.getPropertyValue('--transition') || '0.5s ease';

    // Apply transition directly to slide container for smooth control
    slideContainer.style.transition = transitionTime;

    function goToSlide(index) {
        currentIndex = index;
        const offset = -index * 100;
        slideContainer.style.transform = `translateX(${offset}%)`;

        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentIndex].classList.add('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        goToSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        goToSlide(currentIndex);
    }

    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
        });
    });

    // Optional: autoplay with pause on hover
    let autoPlayInterval = setInterval(nextSlide, 3000);

    document.querySelector('.carousel').addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });

    document.querySelector('.carousel').addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextSlide, 3000);
    });

    // Initial setup
    goToSlide(0);
</script>
@endpush