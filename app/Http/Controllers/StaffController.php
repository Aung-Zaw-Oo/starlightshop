<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index() {
        $staff = Staff::with(['role', 'credential'])
                    ->orderBy('first_name')
                    ->paginate(10);
        return view('staff.index', compact('staff'));
    }
}
