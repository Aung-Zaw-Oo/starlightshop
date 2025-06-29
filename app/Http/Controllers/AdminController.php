<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credential = Credential::where('email', $request->email)->first();

        if ($credential && Hash::check($request->password, $credential->password)) {
            $staff = $credential->staff()->with('role')->first();

            if (!$staff || !in_array(optional($staff->role)->name, ['Admin', 'Manager', 'Staff'])) {
                return redirect()->route('admin.login')->with('error', 'Unauthorized user');
            }

            // Update last_login
            $staff->update([
                'last_login' => now()
            ]);

            // Store staff data in session
            session([
                'staff' => $staff,
                'staff_id' => $staff->id,
                'staff_name' => $staff->first_name . ' ' . $staff->last_name,
                'staff_image' => $staff->image,
                'role' => $staff->role->name,
            ]);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function order()
    {
        return view('admin.order');
    }

    public function customer()
    {
        return view('admin.customer');
    }

    public function product()
    {
        return view('admin.product');
    }

    public function category()
    {
        return view('admin.category');
    }

    public function employee()
    {
        return view('admin.employee');
    }
}
