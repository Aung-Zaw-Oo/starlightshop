<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use App\Models\Credential;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('auth.forgot_password');
    }

    // Handle sending reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check email in credentials table
        $credential = Credential::where('email', $request->email)->first();

        if (!$credential) {
            return back()->withErrors(['email' => 'No account found with this email.']);
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

        return back()->with('status', 'Password reset link sent to your email!');
    }

    // Show reset password form
    public function showResetForm($token, Request $request)
    {
        $email = $request->email;
        return view('auth.reset_password', compact('token', 'email'));
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        // Check token
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>=', now()->subMinutes(1))
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid or expired token!']);
        }

        // Update password in credentials table
        $credential = Credential::where('email', $request->email)->first();
        $credential->password = Hash::make($request->password);
        $credential->save();

        // Delete token after reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('admin/login')->with('status', 'Password has been reset successfully!');
    }
}
