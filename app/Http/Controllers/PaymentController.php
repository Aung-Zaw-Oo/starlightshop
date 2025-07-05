<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
     // Stripe Payment
    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),  // add your own success route here
            ]);


            return response()->json(['success' => true, 'paymentIntent' => $paymentIntent]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess()
    {
        return view('customer.thanks');
    }
}
