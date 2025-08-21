<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Mail\PurchaseConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    // Contact Form
    public function contact(Request $request)
    {
        // validate
        $validated = $request->validate([
            'first-name' => 'required|string|max:100',
            'last-name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
        ],[
            'first-name.required' => 'First name is required.',
            'last-name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'phone.required' => 'Phone number is required.',
            'message.required' => 'Message cannot be empty.'
        ]);

        // send mail
        Mail::to('1997azo.azo@gmail.com')->send(new ContactMessage($validated));

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function purchase($orderDetails)
    {
        $email = $orderDetails->order?->customer?->credential?->email;

        Mail::to($email)->send(new PurchaseConfirmation($orderDetails));
    }
}
