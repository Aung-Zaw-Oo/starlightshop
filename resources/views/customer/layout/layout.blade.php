<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/customer/reset.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/customer/layout.css') }}">
  @stack('styles')
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
        <li><a href="{{ route('customer.about') }}">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>
    <div class="nav-right">
      <div class="profile-container">
        <button class="profile-btn" id="profileBtn" type="button">
          <i class="fa-solid fa-user-gear"></i>
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
            <a href=""><i class="fas fa-user"></i>Profile</a>
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
          <div id="cart-items" style="justify-items: center;"></div>
          <div id="cart-total" style="padding: 0.75rem; font-weight: bold; text-align: right; border-top: 1px solid var(--border-dark);">
            Total: $0.00
          </div>
          <div style="padding: 0.75rem; text-align: center;">
            <!-- Go to Shop -->
            <a href="{{ route('customer.product_list') }}" class="btn primary" style="width: 100%; display: inline-block;" id="go-to-shop">Go Shopping</a>

            <!-- Go to Cart -->
            <a href="{{ route('customer.cart') }}" class="btn primary" style="width: 100%; display: inline-block;" id="go-to-cart">Go to Cart</a>
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
                    <a href="https://maps.app.goo.gl/rB27Zx6Kdp2aJqtc7" target="_blank">No. 33, Pansodan, Upper BLock, Yangon Myanmar</a>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:+95948383383">+95 948 383 383</a>
                </li>
                <li>
                    <i class="fa-solid fa-envelopes-bulk"></i>
                    <a href="mailto:starlight@shopping.com.mm">starlight@shopping.com.mm</a>
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
                <button class="btn primary">Subscribe</button>
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

<script src="https://kit.fontawesome.com/2e96e08057.js" crossorigin="anonymous"></script>
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

// ====== Cart Logic ======

function updateCartCount() {
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartCountEl.textContent = totalItems;
}

function updateCartDropdown() {
  cartItemsContainer.innerHTML = '';

  if (cart.length === 0) {
    document.getElementById('go-to-cart').style.display = 'none';
    document.getElementById('go-to-shop').style.display = 'inline-block';

    cartItemsContainer.innerHTML = `
    <p style="padding: 1rem;">Your cart is empty.</p>
    <img src="{{ asset('storage/uploads/empty-cart.png') }}"></img>
    `;
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
    <strong>
      ${item.name}
    </strong>
    <span>Category: ${item.category}</span>
    <div style="display: flex; align-items: center; gap: 0.5rem;">
      <button class="qty-btn" data-index="${index}" data-action="decrease" ${disableMinus}>−</button>
      <span>${item.quantity}</span>
      <button class="qty-btn" data-index="${index}" data-action="increase" ${disablePlus}>+</button>
    </div>
  <span>
    $${(item.price * item.quantity).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
    })}
  </span>
  <button class="remove-cart-btn" data-index="${index}">Remove</button>
  </div>
  `;

  cartItemsContainer.appendChild(itemEl);

  document.getElementById('go-to-cart').style.display = 'inline-block';
  document.getElementById('go-to-shop').style.display = 'none';
});

cartTotalEl.textContent = `Total: $${total.toLocaleString('en-US', {
minimumFractionDigits: 2,
maximumFractionDigits: 2
})}`;
}

// ====== Cart Event Listeners ======
document.addEventListener('click', function (e) {
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
    showNotification("Maximum stock reached.", "error");
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
    const removedItem = cart[index]; // capture item before removing

    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartDropdown();

    showNotification(`${removedItem.name} removed from cart.`, 'warning');
  }
});

@if(session('logged_out'))
  localStorage.removeItem('cart');
  sessionStorage.removeItem('cart');

  updateCartCount();
  updateCartDropdown();

  window.location.reload();
@endif

const handleClickable = () => {
  document.querySelectorAll('.clickable-row, .clickable-card').forEach(el => {
    el.addEventListener('click', () => {
      window.location.href = el.dataset.href;
    });
  });
};

// ====== Init on Load ======
updateCartCount();
updateCartDropdown();

window.addEventListener('cartUpdated', function(e) {
  cart = e.detail.cart || [];
  updateCartCount();
  updateCartDropdown();
});

function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.className = `notification ${type}`;
  notification.innerHTML = `
    <span class="notification-icon">
      ${type === 'success' ? '<i class="fas fa-circle-check"></i>' : type === 'error' ? '<i class="fas fa-circle-exclamation"></i>' : '<i class="fas fa-circle-info"></i>'}
    </span>
    <div class="notification-content">
      <div class="notification-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
      <div class="notification-message">${message}</div>
    </div>
    <button class="notification-close" aria-label="Close notification">&times;</button>
  `;

  document.body.appendChild(notification);

  // Force reflow so that transition will work
  void notification.offsetWidth;

  notification.classList.add('show');

  // Auto-remove after 3 seconds
  const autoRemove = setTimeout(() => notification.remove(), 3000);

  // Close button removes immediately
  notification.querySelector('.notification-close').addEventListener('click', () => {
    clearTimeout(autoRemove);
    notification.remove();
  });
}

</script>
@stack('scripts')
</body>
</html>