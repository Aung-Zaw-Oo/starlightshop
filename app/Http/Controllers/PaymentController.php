<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Stripe\Stripe;
use App\Models\Order;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Checkout
    public function checkout()
    {
        return view('customer.checkout');
    }

    public function processPayment(Request $request)
    {
        // Validate request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'paymentMethodId' => 'required|string',
            'cart' => 'required|array|min:1'
        ]);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),
            ]);

            if (in_array($paymentIntent->status, ['requires_action', 'succeeded'])) {
                $order = Order::create([
                    'customer_id'   => session('customer_id'),
                    'payment_type'  => '4242-xxxx-xxxx-xxxx',
                    'order_date'    => now(),
                    'total_price'   => $request->amount / 100,
                    'qty'           => collect($request->cart)->sum('quantity'),
                    'order_status'  => 'pending',
                    'status'        => 'active',
                ]);

                foreach ($request->cart as $item) {
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['id'],
                        'qty'        => $item['quantity'],
                        'price'      => $item['price'],
                        'status'     => 'active',
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'paymentIntent' => $paymentIntent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function paymentSuccess()
    {
        return view('customer.thanks');
    }
}
