<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
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
        ]);

        // send mail
        Mail::to('1997azo.azo@gmail.com')->send(new ContactMessage($validated));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
