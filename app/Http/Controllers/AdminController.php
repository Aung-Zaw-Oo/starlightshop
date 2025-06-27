<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function list(){
        // dd("hi");
        return view('admin.order');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credential = Credential::where('email', $request->email)->first();

        if (!$credential || !Hash::check($request->password, $credential->password)) {
            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }

        $staff = $credential->staff()->with('role')->first();

        if (!$staff || $staff->role->name !== 'Admin') {
            return back()->withErrors(['email' => 'Unauthorized user'])->withInput();
        }

        // Store session data
        session([
            'staff_id' => $staff->id,
            'role' => $staff->role->name,
            'staff_name' => $staff->first_name . ' ' . $staff->last_name,
        ]);

        return redirect()->route('admin.dashboard');
    }
}
