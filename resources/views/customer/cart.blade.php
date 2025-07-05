@extends('customer.layout.layout')

@section('title', 'Cart')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
<style>
    .cart-box {
        max-width: 1200px;
        margin: auto;
        padding: 1rem;
    }

    .cart-header {
        text-align: center;
        padding: 2rem 1rem;
    }

    .cart-header h3 {
        margin-bottom: 1rem;
        font-size: 2rem;
        color: #fff;
    }

    .cart-header h4 {
        font-size: 1.2rem;
        color: #ccc;
    }

    .cart-body {
        background-color: #1a1a1a;
        border-radius: 8px;
        padding: 1rem;
    }

    .cart-body-titles,
    .cart-body-items {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr 0.5fr;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--color-8);
        color: #eee;
        align-items: center;
    }

    .cart-body-titles {
        font-weight: bold;
        color: #aaa;
        font-size: 0.95rem;
    }

    .cart-body-titles p {
        text-align: start;
    }

    .cart-body-items img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 1rem;
        background-color: #333;
    }

    .cart-body-items > div:first-child {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cart-body-items p {
        color: #fff;
        font-size: 0.95rem;
        text-align: start;
    }

    .cart-body-items i {
        color: #ff5555;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .cart-body-items i:hover {
        color: red;
    }

    .qty-btn {
        background-color: #333;
        border: 1px solid #555;
        color: #fff;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .qty-btn:hover:not(:disabled) {
        background-color: #555;
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .mobile {
        display: none;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cart-body-titles,
        .cart-body-items {
            grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr 0.5fr;
        }
    }

    @media (max-width: 768px) {
        .cart-body-titles,
        .cart-body-items {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto auto;
            row-gap: 1rem;
        }

        .cart-body-items > div:first-child {
            grid-column: 1 / -1;
            justify-content: center;
        }

        .cart-body-titles {
            display: none;
        }

        .cart-body-items {
            border: 1px solid #333;
            padding: 1rem;
            border-radius: 8px;
            background-color: #222;
            margin-bottom: 1rem;
        }

        .cart-body-items p {
            text-align: left;
        }

        .cart-body-items i {
            grid-column: 2;
            justify-self: end;
        }

        .mobile {
            display: inline;
        }
    }
</style>
@endpush

@section('content')
    <div class="cart-box">
        <div class="cart-header">
            <h3>ADD TO CART</h3>
            <h4>Your Cart (<span>0</span> items)</h4>
        </div>
        <div class="cart-body">
            <div class="cart-body-titles">
                <p>Item</p>
                <p>Price</p>
                <p>Quantity</p>
                <p>Stock Qty</p>
                <p>Total</p>
                <p>Action</p>
            </div>

            <div class="cart-body-items-container"><!-- JS DATA INJECTION --></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.querySelector('.cart-body-items-container');
    const cartCount = document.querySelector('.cart-header span');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Function to update cart count in dropdown/navbar
    function updateCartCount() {
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        
        // Update main cart count
        cartCount.textContent = totalItems;
        
        // Update dropdown/navbar cart count (multiple possible selectors)
        const dropdownCounts = document.querySelectorAll('.cart-count, .navbar-cart-count, #cart-count, [data-cart-count]');
        dropdownCounts.forEach(el => {
            el.textContent = totalItems;
        });
        
        // Trigger custom event for other components
        window.dispatchEvent(new CustomEvent('cartUpdated', { 
            detail: { 
                cart: cart, 
                totalItems: totalItems,
                totalPrice: cart.reduce((total, item) => total + (item.quantity * item.price), 0)
            } 
        }));
    }

    // Function to update dropdown cart items
    function updateCartDropdown() {
        // Update dropdown cart items (adjust selector based on your dropdown structure)
        const dropdownContainer = document.querySelector('.cart-dropdown-items, .navbar-cart-items, #cart-dropdown-items');
        
        if (dropdownContainer) {
            dropdownContainer.innerHTML = '';
            
            if (cart.length === 0) {
                dropdownContainer.innerHTML = '<p style="text-align:center; color:#aaa; padding:1rem;">Your cart is empty.</p>';
            } else {
                cart.forEach((item, index) => {
                    const itemEl = document.createElement('div');
                    itemEl.className = 'dropdown-cart-item';
                    itemEl.innerHTML = `
                        <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border-bottom: 1px solid #333;">
                            <img src="${item.image}" alt="${item.name}" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-size: 0.85rem; margin: 0; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${item.name}</p>
                                <p style="font-size: 0.8rem; margin: 0; color: #aaa;">${item.quantity} × $${item.price.toFixed(2)}</p>
                            </div>
                            <button onclick="removeFromDropdown(${index})" style="background: none; border: none; color: #ff5555; cursor: pointer; padding: 0.2rem;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `;
                    dropdownContainer.appendChild(itemEl);
                });
            }
        }
        
        // Update dropdown total
        const dropdownTotal = document.querySelector('.cart-dropdown-total, .navbar-cart-total, #cart-dropdown-total');
        if (dropdownTotal) {
            const total = cart.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            dropdownTotal.textContent = `$${total.toFixed(2)}`;
        }
    }

    // Function to remove item from dropdown
    window.removeFromDropdown = function(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        updateCartCount();
        updateCartDropdown();
    };

    function renderCart() {
        cartContainer.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartContainer.innerHTML = '<p style="text-align:center; color:#aaa;">Your cart is empty.</p>';
            // Remove totals section when cart is empty
            const existingTotals = document.getElementById('cart-totals');
            if (existingTotals) {
                existingTotals.remove();
            }
            updateCartCount();
            updateCartDropdown();
            return;
        }

        cart.forEach((item, index) => {
            const itemTotal = item.quantity * item.price;
            total += itemTotal;

            const disableMinus = item.quantity <= 1 ? 'disabled' : '';
            const disablePlus = item.quantity >= item.stockQty ? 'disabled' : '';

            const itemEl = document.createElement('div');
            itemEl.className = 'cart-body-items';

            itemEl.innerHTML = `
                <div>
                    <img src="${item.image}" alt="${item.name}">
                    <p>${item.name}</p>
                </div>
                <p><span class="mobile">Price: <br></span>${item.price.toFixed(2)}</p>
                <p>
                    <span class="mobile">Quantity: <br></span>
                    <button class="qty-btn" data-index="${index}" data-action="decrease" ${disableMinus}>−</button>
                    <span style="margin: 0 8px;">${item.quantity}</span>
                    <button class="qty-btn" data-index="${index}" data-action="increase" ${disablePlus}>+</button>
                </p>
                <p><span class="mobile">Stock Qty: <br></span>${item.stockQty}</p>
                <p><span class="mobile">Total: <br></span>${itemTotal.toFixed(2)}</p>
                <p><i class="fa-solid fa-trash" data-index="${index}"></i></p>
            `;

            cartContainer.appendChild(itemEl);
        });

        updateTotals(total);
        updateCartCount();
        updateCartDropdown();
    }

    function updateTotals(total) {
        // Only create/update totals if cart has items
        if (cart.length === 0) {
            const existingTotals = document.getElementById('cart-totals');
            if (existingTotals) {
                existingTotals.remove();
            }
            return;
        }

        let existingTotals = document.getElementById('cart-totals');
        if (!existingTotals) {
            existingTotals = document.createElement('div');
            existingTotals.id = 'cart-totals';
            existingTotals.style.cssText = `
                text-align: right;
                margin-top: 1rem;
                padding: 1rem;
                color: #eee;
                font-size: 1.1rem;
                max-width: 350px;
                margin-left: auto;
                display: grid;
                gap: 1rem;
            `;
            cartContainer.after(existingTotals);
        }

        existingTotals.innerHTML = `
            <p>Subtotal: ${total.toFixed(2)}</p>
            <p style="font-weight:bold; border-top: 1px solid #fff">Grand Total: ${total.toFixed(2)}</p>
            <a href="{{ route('customer.checkout') }}" class="add-to-cart" style="width: 100%; display: inline-block; text-align: center;">Checkout</a>
            <a href="{{ route('customer.product_list') }}" class="cancel-btn" style="width: 100%; display: inline-block; text-align: center; background-color: red; border-radius: 4px; padding: 0.5rem 1rem;">Cancel</a>
        `;
    }

    // Initial render
    renderCart();

    // Quantity change (+/-)
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('qty-btn')) {
            const index = parseInt(e.target.dataset.index);
            const action = e.target.dataset.action;

            if (action === 'increase' && cart[index].quantity < cart[index].stockQty) {
                cart[index].quantity++;
            } else if (action === 'decrease' && cart[index].quantity > 1) {
                cart[index].quantity--;
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        // Remove item
        if (e.target.classList.contains('fa-trash')) {
            const index = parseInt(e.target.getAttribute('data-index'));
            if (!isNaN(index)) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }            
        }
    });

    // Listen for cart updates from other pages (external updates only)
    window.addEventListener('storage', function(e) {
        if (e.key === 'cart') {
            cart = JSON.parse(e.newValue) || [];
            renderCart();
        }
    });
    
    // Expose function for external cart updates
    window.updateCartFromExternal = function(newCart) {
        cart = newCart;
        renderCart();
    };
});
    </script>
@endpush