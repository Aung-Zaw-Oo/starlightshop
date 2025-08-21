<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Credential;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Mail\CustomerResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('auth.admin.forgot_password');
    }

    public function showCustomerForgotForm()
    {
        return view('auth.customer.forgot_password');
    }

    // Handle sending reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ],[
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email format.'
        ]);

        // Check email in credentials table
        $credential = Credential::where('email', $request->email)->first();

        if (!$credential) {
            return back()->with('error', 'No account found with this email.');
        }

        // Generate token
        $token = Str::random(64);

        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $credential->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Send email
        try {
            Mail::to($credential->email)->send(new ResetPasswordMail($token, $credential->email));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return back()->with('info', 'Password reset link sent to your email!');
    }

    public function sendCustomerResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ],[
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email format.'
        ]);

        // Check email in credentials table
        $credential = Credential::where('email', $request->email)->first();

        if (!$credential) {
            return back()->with('error', 'No account found with this email.');
        }

        // Generate token
        $token = Str::random(64);

        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $credential->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Send email
        try {
            Mail::to($credential->email)->send(new CustomerResetPasswordMail($token, $credential->email));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return back()->with('info', 'Password reset link sent to your email!');
    }

    // Show reset password form
    public function showResetForm($token, Request $request)
    {
        $email = $request->email;
        return view('auth.admin.reset_password', compact('token', 'email'));
    }

    public function showCustomerResetForm($token, Request $request)
    {
        $email = $request->email;
        return view('auth.customer.reset_password', compact('token', 'email'));
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ],[
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email format!',
            'password.required' => 'Password is required!',
            'password.confirmed' => 'Password does not match!',
            'password.min' => 'Password must be at least 6 characters!',
            'token.required' => 'Token is required!'
        ]);

        // Check token
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>=', now()->subMinutes(1))
            ->first();

        if (!$reset) {
            return back()->with('error', 'Invalid or expired token!');
        }

        // Update password in credentials table
        $credential = Credential::where('email', $request->email)->first();
        $credential->password = Hash::make($request->password);
        $credential->save();

        // Delete token after reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('admin/login')->with('success', 'Password has been reset successfully!');
    }

    public function resetCustomerPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ],[
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email format!',
            'password.required' => 'Password is required!',
            'password.confirmed' => 'Password does not match!',
            'password.min' => 'Password must be at least 6 characters!',
            'token.required' => 'Token is required!'
        ]);

        // Check token
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>=', now()->subMinutes(1))
            ->first();

        if (!$reset) {
            return back()->with('error', 'Invalid or expired token!');
        }

        // Update password in credentials table
        $credential = Credential::where('email', $request->email)->first();
        $credential->password = Hash::make($request->password);
        $credential->save();

        // Delete token after reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('customer/login')->with('success', 'Password has been reset successfully!');
    }
}
