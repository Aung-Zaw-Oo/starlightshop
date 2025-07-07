@extends('customer.layout.layout')

@section('title', 'Checkout')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

@push('styles')
    <style>
        /* ========== Container ========== */
        .payment-box {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #1a1a1a;
            border-radius: 12px;
            color: #fff;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .payment-box h3 {
            width: 100%;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #FCA311;
        }

        /* ========== Left Info Panel ========== */
        .payment-left {
            flex: 1;
            min-width: 280px;
            background-color: var(--green);
            border-radius: 8px;
            color: #000;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .payment-left div {
            margin-bottom: 1rem;
            border-bottom: 5px solid #fff;
            border-radius: 8px 8px 0 0;
        }

        .payment-left p {
            margin: 0;
            font-size: 1rem;
        }

        .payment-left span {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 0.3rem;
            display: inline-block;
        }

        /* ========== Right Stripe Panel ========== */
        .payment-right {
            flex: 1;
            min-width: 280px;
        }

        /* Stripe form */
        #payment-form {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 300px;
        }

        /* Stripe card input */
        #card-element {
            background: #2a2a2a;
            padding: 1rem;
            border-radius: 8px;
            min-height: 45px;
            color: #fff;
            border: 2px solid #333;
            transition: border-color 0.3s ease;
        }

        #card-element:focus-within {
            border-color: #4CAF50;
        }

        .StripeElement {
            font-size: 16px;
            color: #fff;
            background: transparent;
            border: none;
            outline: none;
        }

        /* ========== Buttons ========== */
        .payment-btns {
            display: flex;
            flex-direction: column;
            margin-top: auto;
        }

        .checkout-btn {
            background: linear-gradient(135deg, #4CAF50, #388e3c);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
            margin-bottom: 1rem;
        }

        .checkout-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #43a047, #2e7d32);
        }

        .checkout-btn:disabled {
            background: #666;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .cancel-btn {
            display: block;
            text-align: center;
            padding: 0.7rem 0;
            border-radius: 6px;
            background: #444;
            color: #eee;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .cancel-btn:hover {
            background: #666;
            color: #fff;
        }

        /* ========== Icons and Errors ========== */
        .payment-icons {
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: end;
        }

        #card-errors {
            font-size: 0.9rem;
            color: #ff4444;
            margin-top: 0.5rem;
            min-height: 1.2rem;
        }

        .loading {
            opacity: 0.6;
        }

        .empty-cart {
            width: 100%;
            text-align: center;
            padding: 2rem;
            color: #aaa;
        }

        .empty-cart a {
            color: #4CAF50;
            text-decoration: none;
        }

        .empty-cart a:hover {
            text-decoration: underline;
        }

        /* ========== Responsive ========== */
        @media (max-width: 768px) {
            .payment-box {
                flex-direction: column;
                padding: 1.5rem;
            }

            .checkout-btn, .cancel-btn {
                width: 100%;
                text-align: center;
            }

            #payment-form {
                min-height: max-content;
            }
        }
    </style>
@endpush

@section('content')
    <div class="payment-box">
        <h3>Welcome To Our Payment</h3>
        
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
                    <button id="submit-button" class="checkout-btn" type="submit">Pay Now</button>
                    <a href="{{ route('customer.cart') }}" class="cancel-btn">Cancel</a>
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
            document.getElementById('payment-amount').textContent = `$ ${total.toFixed(2)}`;
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

            const cardElement = elements.create('card');
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