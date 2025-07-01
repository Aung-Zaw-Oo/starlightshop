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
      --bg-dark: #0a0a0a;
      --bg-dark-2: #1a1a1a;
      --bg-dark-3: #2d2d2d;
      --text-light: #ffffff;
      --border-dark: #333;
      --btn-primary: #4f46e5;
      --green: #10b981;
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
      color: #ffd700;
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
      color: white;
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
      border: 1px solid #404040;
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
      border-bottom: 1px solid #404040;
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
      background: linear-gradient(135deg, var(--bg-dark), var(--bg-dark-2));
      padding: 1rem 2rem;
    }

    @media (max-width: 768px) {
      .top-nav {
        padding: 1rem;
        flex-wrap: wrap;
      }

      .nav-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-dark-3);
        flex-direction: column;
        padding: 1rem;
        border-top: 1px solid #404040;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
      }

      .nav-menu.show {
        display: flex;
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
    }

    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: var(--bg-dark-2);
    }

    ::-webkit-scrollbar-thumb {
      background: #404040;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
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
  background-color: #1e1e1e;
  border: 1px solid var(--border-dark);
  border-radius: 4px;
  color: white;
  min-width: 150px;
}

.subscribe-container button {
  padding: 0.5rem 1rem;
  background: var(--green);
  color: white;
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


  </style>
</head>
<body>
  <nav class="top-nav">
    <div class="nav-left">
      <a href="#" class="logo">
        <img src="{{ asset('icons/logo.svg') }}" alt="" />
        StarLight Store
      </a>
      <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
      </button>
      
    </div>
    <div class="nav-center">
        <ul class="nav-menu" id="navMenu">
        <li><a href="#" class="{{ Route::currentRouteName() == 'customer.home' ? 'active' : '' }}">Home</a></li>
        <li><a href="#">Product List</a></li>
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
          <span>Account</span>
        </button>
        <div class="profile-dropdown" id="profileDropdown">
            <a href="#"><i class="fas fa-sign-in-alt"></i>Login</a>
            <a href="#"><i class="fas fa-user-plus"></i>Register</a>

            <a href="#"><i class="fas fa-user"></i>Profile</a>
            <a href="#"><i class="fas fa-cog"></i>Settings</a>
            <a href="#"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
      </div>
      <a href="#" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">2</span>
      </a>
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
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');

    profileBtn.addEventListener('click', e => {
      e.stopPropagation();
      profileDropdown.classList.toggle('show');
    });

    mobileMenuToggle.addEventListener('click', e => {
      e.stopPropagation();
      navMenu.classList.toggle('show');
    });

    document.addEventListener('click', e => {
      if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('show');
      }
      if (!mobileMenuToggle.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove('show');
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        navMenu.classList.remove('show');
      }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
