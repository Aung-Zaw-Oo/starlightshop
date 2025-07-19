@extends('customer.layout.layout')

@section('title', 'Checkout')

<link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">

@section('content')
<div class="checkout-box">
    <h2>Welcome To Our Payment</h2>
    <div class="payment-box">
        <div id="empty-cart-message" class="empty-cart" style="display: none;">
            <p>Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
            <a href="{{ route('customer.product_list') }}">Continue Shopping</a>
        </div>

        <div class="payment-left">
            <div>
                <p>Amount:</p>
                <span id="payment-amount">$ 0.00</span>
            </div>
            <div>
                <p>Account Type:</p>
                <p>Account Transaction</p>
            </div>
            <div>
                <p>Transaction Time:</p>
                <p class="transaction-time">Loading...</p>
            </div>
        </div>

        <div class="payment-right">
            <form id="payment-form">
                <p class="payment-title" style="text-align: center; margin-bottom: 1rem;">VISA/ MASTER CARD ENTRY</p>
                <div id="card-errors" role="alert"></div>
                <p style="margin-bottom: 1rem;">Card Number</p>
                <div id="card-element" style="margin-bottom: 1rem;"></div>
                <div class="payment-icons">
                    <i class="fa-brands fa-cc-mastercard"></i>
                    <i class="fa-brands fa-cc-visa"></i>
                </div>
                <div class="payment-btns">
                    <button id="submit-button" class="btn primary" type="submit">Pay Now</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            let total = 0;

            // Check if cart is empty
            if (cart.length === 0) {
                document.getElementById('empty-cart-message').style.display = 'block';
                document.querySelector('.payment-left').style.display = 'none';
                document.querySelector('.payment-right').style.display = 'none';
                return;
            }

            // Calculate total
            cart.forEach(item => {
                total += parseFloat(item.price) * parseInt(item.quantity);
            });

            // Update UI
            document.getElementById('payment-amount').textContent = `$ ${parseFloat(total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.querySelector('.transaction-time').textContent = new Date().toLocaleString();

            // Initialize Stripe
            const stripe = Stripe("{{ config('services.stripe.key') }}");

            const elements = stripe.elements({
                fonts: [{ cssSrc: 'https://fonts.googleapis.com/css?family=Roboto' }],
                appearance: {
                    theme: 'night',
                    variables: {
                        colorBackground: '#2a2a2a',
                        colorText: '#ffffff',
                        colorPrimary: '#4CAF50',
                        borderRadius: '6px',
                    }
                }
            });

            const cardElement = elements.create('card', {
                style: {
                    base: {
                        color: '#ffffff',
                        fontFamily: 'Roboto, sans-serif',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#cccccc'
                        }
                    },
                    invalid: {
                        color: '#ff5252'
                    }
                }
            });

            cardElement.mount('#card-element');

            // Handle form submission
            document.getElementById('payment-form').addEventListener('submit', async (e) => {
                e.preventDefault();

                const submitButton = document.getElementById('submit-button');
                const cardErrors = document.getElementById('card-errors');

                // Disable button and show loading state
                submitButton.disabled = true;
                submitButton.textContent = 'Processing...';
                cardErrors.textContent = '';

                try {
                    // Create payment method
                    const { paymentMethod, error } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardElement,
                    });

                    if (error) {
                        cardErrors.textContent = error.message;
                        return;
                    }

                    // Process payment
                    const response = await fetch("{{ route('payment.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            paymentMethodId: paymentMethod.id,
                            amount: Math.round(total * 100),
                            cart: cart
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Clear cart and redirect
                        localStorage.removeItem('cart');
                        
                        // Trigger cart update event for other components
                        window.dispatchEvent(new CustomEvent('cartUpdated', { 
                            detail: { 
                                cart: [], 
                                totalItems: 0,
                                totalPrice: 0
                            } 
                        }));
                        
                        window.location.href = data.redirect_url || '/customer/payment/success';
                    } else {
                        cardErrors.textContent = data.error || 'Payment failed. Please try again.';
                    }
                } catch (error) {
                    cardErrors.textContent = 'Network error. Please check your connection and try again.';
                    console.error('Payment error:', error);
                } finally {
                    // Re-enable button
                    submitButton.disabled = false;
                    submitButton.textContent = 'Pay Now';
                }
            });

            // Handle card element changes
            cardElement.on('change', function(event) {
                const cardErrors = document.getElementById('card-errors');
                if (event.error) {
                    cardErrors.textContent = event.error.message;
                } else {
                    cardErrors.textContent = '';
                }
            });
        });
    </script>
@endpush