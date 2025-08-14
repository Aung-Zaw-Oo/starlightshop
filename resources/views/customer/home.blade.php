@extends('customer.layout.layout')

@section('title', 'Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
@endpush

@section('content')
    <!-- Carousel -->
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
                            <p class="slide-title">{{ $product['name'] }}</p>
                            <!-- <p class="slide-description">{{ $product['description'] }}</p> -->
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
        <p class="section-title">CATEGORIES</p> 
        <div class="category-tags">
            @foreach ($categories as $category)
                <div class="tag">
                    <a href="{{ route('customer.product_list', ['category' => $category->id]) }}">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        <p style="margin-top: 8px;">{{ $category->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Top Sellings -->
    <section class="top-selling">
    <p class="section-title">TOP SELLING</p>
        <div class="top-selling-cards-container">
            @foreach ($topSellings as $product)
                <div class="top-selling-card"
                    data-href="{{ route('customer.product_detail', $product->id) }}"
                >
                    <div class="top-selling-card-image">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="top-selling-card-description">
                        <div>
                            <h3 style="margin-bottom: 8px;">{{ $product->name }}</h3>
                            <b class="price" style="font-size: 18px; color: var(--primary);">$ {{ number_format($product->sale_price, 2) }}</b>
                        </div>
                        <button class="detail-btn">
                            <a href="{{ route('customer.product_detail', $product->id) }}">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="new-arrivals">
        <p class="section-title">NEW ARRIVALS</p>
        <div class="new-arrival-cards-container">
            @for ($i = 1; $i <= 5; $i++)
                <div class="new-arrival-card" 
                    data-href="{{ route('customer.product_detail', $products[count($products) - $i]->id) }}"
                >
                    <div class="new-arrival-card-image"
                    >
                        <img src="{{ asset('storage/' . $products[count($products) - $i]->image) }}" alt="{{ $products[count($products) - $i]->name }}">
                    </div>
                    <div class="new-arrival-card-description">
                        <div style="margin-bottom: .5rem;">
                            <h3>
                                {{ \Illuminate\Support\Str::limit($products[count($products) - $i]->name,30) }}
                            </h3>
                            <b class="price" style="font-size: 18px; color: var(--primary);">$ {{ number_format($products[count($products) - $i]->sale_price, 2) }}</b>
                        </div>
                        <button class="detail-btn">
                            <a href="{{ route('customer.product_detail', $products[count($products) - $i]->id) }}">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            @endfor
        </div>
    </section>
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
    let autoPlayInterval = setInterval(nextSlide, 4000);

    document.querySelector('.carousel').addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });

    document.querySelector('.carousel').addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextSlide, 3000);
    });

    // Initial setup
    goToSlide(0);
    handleClickable();
</script>
@endpush