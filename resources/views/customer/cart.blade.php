@extends('customer.layout.layout')

@section('title', 'Cart')

<link rel="stylesheet" href="{{ asset('css/customer/cart.css') }}">

@section('content')

    @php
        $sessionCart = session('cart', []);
    @endphp

    <script>
        const laravelCart = @json($sessionCart);
        if (!localStorage.getItem('cart') || localStorage.getItem('cart') === '[]') {
            localStorage.setItem('cart', JSON.stringify(laravelCart));
        }
    </script>

    <div class="cart-box">
        <div class="cart-header">
            <h2>ADD TO CART</h2>
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
            <div class="cart-body-items-container">
                <!-- JS DATA INJECTION -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.querySelector('.cart-body-items-container');
    const cartCount = document.querySelector('.cart-header span');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // function updateCartCount() {
    //     const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        
    //     cartCount.textContent = totalItems;
        
    //     const dropdownCounts = document.querySelectorAll('.cart-count, .navbar-cart-count, #cart-count, [data-cart-count]');
    //     dropdownCounts.forEach(el => {
    //         el.textContent = totalItems;
    //     });
        
    //     window.dispatchEvent(new CustomEvent('cartUpdated', { 
    //         detail: { 
    //             cart: cart, 
    //             totalItems: totalItems,
    //             totalPrice: cart.reduce((total, item) => total + (item.quantity * item.price), 0)
    //         } 
    //     }));
    // }

    window.removeFromDropdown = function(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));

        cart = JSON.parse(localStorage.getItem('cart')) || [];

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
            <p>Subtotal: ${parseFloat(total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
            <p style="font-weight:bold; border-top: var(--border); padding-top: var(--padding);">Grand Total: ${parseFloat(total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
            <a href="{{ route('payment.checkout') }}" class="btn primary" style="width: 100%; display: inline-block; text-align: center;">Checkout</a>
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