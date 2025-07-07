<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StarLight Store</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}"/>
  @stack('styles')
  <style>
    :root {
      /* Backgrounds */
      --bg-1: #000000;
      --bg-2: #1a1a1a;
      --bg-3: #2d2d2d;
      --bg-4: #404040;
      --bg-5: #525252;
      --bg-6: #6b6b6b;
      --bg-7: #808080;
      --bg-8: #a3a3a3;
      --bg-9: #c7c7c7;
      --bg-10: #d4d4d4;
      --bg-11: #e6e6e6;
      --bg-12: #f5f5f5;
      --bg-13: #ffffff;

      /* Text */
      --text-1: #000000;
      --text-2: #1a1a1a;
      --text-3: #2d2d2d;
      --text-4: #404040;
      --text-5: #525252;
      --text-6: #6b6b6b;
      --text-7: #808080;
      --text-8: #a3a3a3;
      --text-9: #c7c7c7;
      --text-10: #d4d4d4;
      --text-11: #e6e6e6;
      --text-12: #f5f5f5;
      --text-13: #ffffff;

      /* Semantic Aliases */
      --bg-dark: var(--bg-1);
      --bg-dark-2: var(--bg-2);
      --bg-dark-3: var(--bg-3);
      --text-light: var(--text-13);
      --border-dark: var(--text-4);
      --btn-primary: #10b981;

      /* Status Colors */
      --green: #10b981;
      --red: #ef4444;
      --blue: #3b82f6;
      --yellow: #f59e0b;

      /* Custom */
      --yellow-star: #ffd700;
      --scroll-thumb: #555;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: system-ui, sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-light);
      min-height: 100vh;
    }

    nav.top-nav {
      background: linear-gradient(135deg, var(--bg-dark-2), var(--bg-dark-3));
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid var(--border-dark);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }

    .nav-left, .nav-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      color: var(--text-light);
      font-size: 1.25rem;
      font-weight: 600;
    }

    .star-icon {
      color: var(--yellow-star);
      font-size: 1.5rem;
    }

    .nav-menu {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-menu a {
      color: var(--text-light);
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-menu a:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-1px);
    }

    .nav-menu a.active {
      background: var(--green);
      box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .cart-icon {
      position: relative;
      color: var(--text-light);
      font-size: 1.25rem;
      padding: 0.5rem;
      border-radius: 50%;
      transition: 0.3s;
      text-decoration: none;
    }

    .cart-icon:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: scale(1.1);
    }

    .cart-count {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--green);
      color: var(--text-light);
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    .profile-container {
      position: relative;
    }

    .profile-btn {
      background: none;
      border: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem;
      border-radius: 50px;
      color: var(--text-light);
      cursor: pointer;
      transition: 0.3s;
    }

    .profile-btn:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .profile-btn img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--border-dark);
    }

    .profile-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      background: var(--bg-dark-3);
      border: 1px solid var(--border-dark);
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      min-width: 200px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1001;
      overflow: hidden;
    }

    .profile-dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .profile-dropdown a {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1rem;
      color: var(--text-light);
      text-decoration: none;
      transition: 0.3s;
      border-bottom: 1px solid var(--border-dark);
    }

    .profile-dropdown a:last-child {
      border-bottom: none;
    }

    .profile-dropdown a:hover {
      background: rgba(255, 255, 255, 0.1);
      padding-left: 1.25rem;
    }

    .profile-dropdown i {
      width: 16px;
      font-size: 0.9rem;
    }

    .mobile-menu-toggle {
      display: none;
      background: none;
      border: none;
      color: var(--text-light);
      font-size: 1.25rem;
      padding: 0.5rem;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .mobile-menu-toggle:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .main-content {
      min-height: max-content;
      background: var(--bg-dark-1);
    }

    @media (max-width: 1024px) {
      .nav-menu {
        gap: 0;
      }
    }

    @media (max-width: 768px) {
      .top-nav {
        padding: 1rem;
        flex-wrap: wrap;
      }

      .nav-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-dark-3);
        flex-direction: column;
        overflow: hidden;
        max-height: 0;
        padding: 0 1rem;
        border-top: 1px solid transparent;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
        transition: all 0.4s ease;
        gap: 2rem;
      }

      .nav-menu.show {
        max-height: max-content;
        padding: 1rem;
        border-top: 1px solid var(--border-dark);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
      }


      .mobile-menu-toggle {
        display: block;
      }

      .profile-dropdown {
        right: -10px;
        min-width: 180px;
      }
    }

    @media (max-width: 480px) {
      .logo {
        font-size: 1.1rem;
      }

      .star-icon {
        font-size: 1.25rem;
      }

      .profile-btn img {
        width: 28px;
        height: 28px;
      }

      nav.top-nav {
        padding: 1rem;
      }

      .nav-left,
      .nav-right {
        width: 100%;
        justify-content: space-between;
      }

      .profile-dropdown {
        right: -90px;
        min-width: 180px;
      }
    }

    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: var(--bg-dark-2);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--bg-4);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--scroll-thumb);
    }

    footer {
      padding: 1rem 2rem;
      background-color: var(--bg-dark-3);
    }

    .footer-upper {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .footer-col {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .footer-col h3 {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }

    .footer-col ul {
      list-style: none;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .footer-col li {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.95rem;
    }

    .subscribe-container {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .subscribe-container input[type="email"] {
      flex: 1;
      padding: 0.5rem;
      background-color: var(--bg-3);
      border: 1px solid var(--border-dark);
      border-radius: 4px;
      color: var(--text-light);
      min-width: 150px;
    }

    .subscribe-container button {
      padding: 0.5rem 1rem;
      background: var(--green);
      color: var(--text-light);
      border: none;
      border-radius: 4px;
      cursor: pointer;
      white-space: nowrap;
    }

    .social-icons {
      display: flex;
      gap: 1rem;
      margin-top: 1rem;
    }

    .social-icons i {
      font-size: 1.5rem;
      cursor: pointer;
      transition: color 0.3s;
    }

    .social-icons i:hover {
      color: var(--btn-primary);
    }

    .footer-lower {
      text-align: center;
      font-size: 0.9rem;
      color: var(--text-light);
    }

    .cart-container {
      position: relative;
    }

    .cart-btn {
      background: none;
      border: none;
      position: relative;
      color: var(--text-light);
      font-size: 1.25rem;
      padding: 0.5rem;
      border-radius: 50%;
      cursor: pointer;
      transition: 0.3s;
    }

    .cart-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: scale(1.1);
    }

    .cart-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      background: var(--bg-dark-3);
      border: 1px solid var(--border-dark);
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      min-width: 250px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1001;
    }

    .cart-dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .cart-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 0.75rem;
      border-bottom: 1px solid var(--border-dark);
    }

    .cart-item img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }

    .cart-item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      font-size: 14px;
    }

    .cart-item-details strong {
      font-size: 16px;
    }

    .cart-item-details span {
      color: var(--text-9);
    }

    .remove-cart-btn {
      background: transparent;
      border: none;
      color: var(--red);
      font-size: 14px;
      cursor: pointer;
      padding: 0.25rem 0;
      align-self: flex-end;
      transition: 0.3s;
    }

    .remove-cart-btn:hover {
      text-decoration: underline;
    }

    .cart-dropdown {
  max-height: 400px;
  overflow-y: auto;
  scrollbar-width: thin;
}

.qty-btn {
  background: var(--bg-5);
  border: none;
  color: #fff;
  width: 24px;
  height: 24px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.2s;
}

.qty-btn:hover {
  background: var(--green);
}

.qty-btn:disabled {
  background: #555;
  opacity: 0.5;
  cursor: not-allowed;
}

.add-to-cart {
  background: var(--green);
  border: none;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.2s;
}

.add-to-cart:hover {
  background-color: #3e8e41;
}

  </style>
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
              {{ session('customer_name') }}
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
                        No. 33, Pandodan, Upper BLock, Yangon Myanmar
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
        <p>&copy; 2025 StarLight Store. All rights reserved.</p>
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
