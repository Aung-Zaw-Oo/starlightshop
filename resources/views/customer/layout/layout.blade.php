<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StarLight Store</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/customer/reset.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/customer/layout.css') }}">
</head>
<body>
  <nav class="top-nav">
    <div class="nav-left">
      <a href="{{ route('customer.home') }}" class="logo">
        <img src="{{ asset('icons/logo.svg') }}" alt="" />
        StarLight Store
      </a>
      <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
      </button>
      
    </div>
    <div class="nav-center">
        <ul class="nav-menu" id="navMenu">
        <li><a href="{{ route('customer.home') }}" class="{{ Route::currentRouteName() == 'customer.home' ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('customer.product_list') }}" class="{{ Route::currentRouteName() == 'customer.product_list' ? 'active' : '' }}">Product List</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>
    <div class="nav-right">
      <div class="profile-container">

        <button class="profile-btn" id="profileBtn">
          <a href="#">
            <i class="fa-solid fa-user-gear"></i>
          </a>
          <span>
            @if (session('customer_name'))
              {{ \Illuminate\Support\Str::limit(session('customer_name'), 10) }}
            @else
              Account
            @endif
          </span>
        </button>

        <div class="profile-dropdown" id="profileDropdown">

          @if (session('customer_name'))
            <a href="{{ route('order.history') }}"><i class="fa-solid fa-clock-rotate-left"></i>Purchase History</a>
            <a href="#"><i class="fas fa-user"></i>Profile</a>
            <a href="#"><i class="fas fa-cog"></i>Settings</a>
            <a href="{{ route('customer.logout') }}"><i class="fas fa-sign-out-alt"></i>Logout</a>
          @else
            <a href="{{ route('customer.loginForm') }}"><i class="fas fa-sign-in-alt"></i>Login</a>
            <a href="{{ route('customer.registerForm') }}"><i class="fas fa-user-plus"></i>Register</a>
          @endif

        </div>
      </div>

      <!-- Cart -->
      <div class="cart-container">
        <button class="cart-btn" id="cartBtn">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count" id="cart-count">0</span>
        </button>

        <!-- Cart Dropdown -->
        <div class="cart-dropdown" id="cartDropdown">
          <div id="cart-items"></div>
          <div id="cart-total" style="padding: 0.75rem; font-weight: bold; text-align: right; border-top: 1px solid var(--border-dark);">
            Total: $0.00
          </div>
          <div style="padding: 0.75rem; text-align: center;">
            <a href="{{ route('customer.cart') }}" class="add-to-cart" style="width: 100%; display: inline-block;">Go to Cart</a>
          </div>
        </div>
      </div>

    </div>
  </nav>

  <main class="main-content">
    @yield('content')
  </main>

  <footer>
    <div class="footer-upper">
        <div class="footer-col">
            <h3>Star Light Store</h3>
            <ul>
                <li>
                    <i class="fa-solid fa-location-arrow"></i>
                    <span>
                        No. 33, Pansodan, Upper BLock, Yangon Myanmar
                    </span>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <span>+95 948 383 383</span>
                </li>
                <li>
                    <i class="fa-solid fa-envelopes-bulk"></i>
                    <span>
                        starlight@shopping.com.mm
                    </span>
                </li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Customer Service</h3>
            <ul>
                <li>Return Policy</li>
                <li>Delivery Information</li>
                <li>Privacy Policy</li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Subscribe</h3>
            <p>Receive updates, hot deals, discounts sent straight in your inbox daily</p>
            <div class="subscribe-container">
                <input type="email" name="subscribe" id="subscribe" placeholder="Email Address">
                <button>Subscribe</button>
            </div>
            <div class="social-icons">
                <i class="fa-brands fa-square-facebook"></i>
                <i class="fa-brands fa-square-twitter"></i>
                <i class="fa-brands fa-square-instagram"></i>
            </div>
        </div>
    </div>
    <div class="footer-lower">
        <p>&copy; 2025 Star Light Online Shop. Designed By O-Technique Myanmar.</p>
    </div>
  </footer>

<script>
  // ====== DOM Elements ======
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');
  const cartBtn = document.getElementById('cartBtn');
  const cartDropdown = document.getElementById('cartDropdown');
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const navMenu = document.getElementById('navMenu');
  const cartCountEl = document.getElementById('cart-count');
  const cartItemsContainer = document.getElementById('cart-items');
  const cartTotalEl = document.getElementById('cart-total');

  // ====== Cart State ======
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  // ====== UI Toggles ======
  profileBtn?.addEventListener('click', e => {
  e.stopPropagation();
  profileDropdown?.classList.toggle('show');
  });

  cartBtn?.addEventListener('click', e => {
  e.stopPropagation();
  cartDropdown?.classList.toggle('show');
  });

  mobileMenuToggle?.addEventListener('click', e => {
  e.stopPropagation();
  navMenu?.classList.toggle('show');
  });

  document.addEventListener('click', e => {
  if (!profileBtn?.contains(e.target) && !profileDropdown?.contains(e.target)) {
    profileDropdown?.classList.remove('show');
  }
  if (!mobileMenuToggle?.contains(e.target) && !navMenu?.contains(e.target)) {
    navMenu?.classList.remove('show');
  }
  if (!cartBtn?.contains(e.target) && !cartDropdown?.contains(e.target)) {
    cartDropdown?.classList.remove('show');
  }
  });

  window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    navMenu?.classList.remove('show');
  }
  });

  // ====== Smooth Scroll for Anchor Links ======
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
  });

  // ====== Cart Logic ======

  function updateCartCount() {
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartCountEl.textContent = totalItems;
  }

  function showNotification(message) {
  const notification = document.createElement('div');
  notification.className = 'notification';
  notification.textContent = message;
  document.body.appendChild(notification);
  setTimeout(() => notification.remove(), 3000);
  }

  function updateCartDropdown() {
  cartItemsContainer.innerHTML = '';
  if (cart.length === 0) {
    cartItemsContainer.innerHTML = '<p style="padding: 1rem;">Your cart is empty.</p>';
    cartTotalEl.textContent = 'Total: $0.00';
    return;
  }

  let total = 0;

  cart.forEach((item, index) => {
    const itemEl = document.createElement('div');
    itemEl.className = 'cart-item';
    total += item.price * item.quantity;

    const disableMinus = item.quantity <= 1 ? 'disabled' : '';
    const disablePlus = item.quantity >= item.stockQty ? 'disabled' : '';

    itemEl.innerHTML = `
      <img src="${item.image}" alt="${item.name}">
      <div class="cart-item-details">
        <strong>${item.name}</strong>
        <span>Category: ${item.category}</span>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <button class="qty-btn" data-index="${index}" data-action="decrease" ${disableMinus}>−</button>
          <span>${item.quantity}</span>
          <button class="qty-btn" data-index="${index}" data-action="increase" ${disablePlus}>+</button>
        </div>
        <span>$${(item.price * item.quantity).toFixed(2)}</span>
        <button class="remove-cart-btn" data-index="${index}">Remove</button>
      </div>
    `;

    cartItemsContainer.appendChild(itemEl);
  });

  cartTotalEl.textContent = `Total: $${total.toFixed(2)}`;
  }

  // ====== Cart Event Listeners ======

  document.addEventListener('click', function (e) {
  // Add to Cart
  const addBtn = e.target.closest('.add-to-cart-btn');
  if (addBtn) {
    const productId = addBtn.dataset.productId;
    const productName = addBtn.dataset.productName;
    const price = parseFloat(addBtn.dataset.price);
    const image = addBtn.dataset.image;
    const category = addBtn.dataset.category;
    const stockQty = parseInt(addBtn.dataset.stock);

    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
      if (existingItem.quantity < stockQty) {
        existingItem.quantity += 1;
      } else {
        showNotification("Maximum stock reached.");
        return;
      }
    } else {
      cart.push({
        id: productId,
        name: productName,
        price,
        quantity: 1,
        image,
        category,
        stockQty
      });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartDropdown();
    showNotification(`${productName} added to cart!`);
  }

  // Quantity Update
  if (e.target.classList.contains('qty-btn')) {
    const index = parseInt(e.target.dataset.index);
    const action = e.target.dataset.action;
    const item = cart[index];

    if (action === 'increase' && item.quantity < item.stockQty) {
      item.quantity += 1;
    } else if (action === 'decrease' && item.quantity > 1) {
      item.quantity -= 1;
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartDropdown();
  }

  // Remove Item
  if (e.target.classList.contains('remove-cart-btn')) {
    const index = e.target.dataset.index;
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartDropdown();
    showNotification("Item removed from cart");
  }
  });

  // Remove Cart Items On Delete
  @if(session('logged_out'))
    localStorage.removeItem('cart');
    sessionStorage.removeItem('cart');
    console.log('Cart cleared after logout.');

    // Optional: update UI if needed before reload
    updateCartCount();
    updateCartDropdown();

    // Reload the page to reflect cleared cart
    window.location.reload();
  @endif


  // ====== Init on Load ======
  updateCartCount();
  updateCartDropdown();

</script>
  @stack('scripts')
</body>
</html>
