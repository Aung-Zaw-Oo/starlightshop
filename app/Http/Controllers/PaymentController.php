<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use Stripe\PaymentIntent;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Mail\PurchaseConfirmation;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Checkout
    public function checkout()
    {
        return view('customer.checkout');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'paymentMethodId' => 'required|string',
            'cart' => 'required|array|min:1'
        ]);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),
            ]);

            // Only create order if payment succeeded
            if ($paymentIntent->status === 'succeeded') {

                // Create the Order
                $order = Order::create([
                    'customer_id'       => session('customer_id'),
                    'payment_type'      => '4242-xxxx-xxxx-xxxx', // you can replace with actual method type
                    'order_date'        => now(),
                    'total_price'       => $request->amount / 100,
                    'qty'               => collect($request->cart)->sum('quantity'),
                    'order_status'      => 'pending',
                    'status'            => 'active',
                    'stripe_payment_id' => $paymentIntent->id,
                ]);

                // Create OrderDetails & reduce stock
                foreach ($request->cart as $item) {
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['id'],
                        'qty'        => $item['quantity'],
                        'price'      => $item['price'],
                        'status'     => 'active',
                    ]);

                    $product = Product::find($item['id']);
                    if ($product) {
                        $product->qty -= $item['quantity'];
                        $product->save();
                    }
                }

                // Send confirmation email
                Mail::to(session('customer_email'))->send(new PurchaseConfirmation($order));
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
