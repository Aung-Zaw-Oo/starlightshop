<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Staff;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::with(['role', 'credential'])->paginate(5);
        return view('admin.employee', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('status', 'Active')->get();
        return view('admin.employee_create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'email' => 'required|email|unique:credentials,email',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        $currentUserRole = session('role');

        // Prevent Staff role from creating Admin or Manager accounts
        if ($currentUserRole === 'Staff' && in_array($request->role_id, Role::whereIn('name', ['Admin', 'Manager'])->pluck('id')->toArray())) {
            return redirect()->back()->with('error', 'You are not authorized to assign Admin or Manager roles.');
        }

        // Create Credential
        $credential = Credential::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        // Create Staff
        Staff::create([
            'role_id' => $validated['role_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'dob' => $validated['dob'],
            'credential_id' => $credential->id,
            'image' => $imagePath,
            'status' => 'Active',
        ]);

        return redirect()->route('admin.employee')->with('success', 'Staff created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staff = Staff::with(['role', 'credential'])->findOrFail($id);

        $currentUserId = session('staff_id');
        $currentUserRole = session('role');

        // Staff can only edit themselves
        if ($currentUserRole === 'Staff' && $staff->id !== $currentUserId) {
            return redirect()->route('admin.employee')->with('error', 'Unauthorized access.');
        }

        if ($currentUserRole === 'Staff') {
            // Staff should only see roles they can assign (exclude Admin and Manager)
            $roles = Role::where('status', 'Active')
                ->whereNotIn('name', ['Admin', 'Manager'])
                ->get();
        } else {
            // Admin and Manager see all active roles
            $roles = Role::where('status', 'Active')->get();
        }

        return view('admin.employee_edit', compact('staff', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $currentUserId = session('staff_id');
        $currentUserRole = session('role');

        // Staff can only update themselves
        if ($currentUserRole === 'Staff' && $staff->id !== $currentUserId) {
            return redirect()->route('admin.employee')->with('error', 'Unauthorized update attempt.');
        }

        // Prevent Staff from assigning Admin or Manager roles
        if ($currentUserRole === 'Staff') {
            $adminManagerRoleIds = Role::whereIn('name', ['Admin', 'Manager'])->pluck('id')->toArray();
            if (in_array($request->role_id, $adminManagerRoleIds)) {
                return redirect()->back()->with('error', 'You are not authorized to assign Admin or Manager roles.');
            }
        }

        // Validate input (adjust rules as needed)
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'status' => 'required|in:Active,Inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            if ($staff->image && Storage::disk('public')->exists($staff->image)) {
                Storage::disk('public')->delete($staff->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
            $staff->image = $imagePath;
        }

        // Only Admins and Managers can update role and status
        if ($currentUserRole !== 'Staff') {
            $staff->role_id = $validated['role_id'];
            $staff->status = $validated['status'];
        }

        // Staff can update their own info except role and status
        // (no action needed here as we skip role and status update for Staff)

        $staff->first_name = $validated['first_name'];
        $staff->last_name = $validated['last_name'];
        $staff->address = $validated['address'];
        $staff->phone = $validated['phone'];
        $staff->dob = $validated['dob'];

        $staff->save();

        return redirect()->route('admin.employee')->with('success', 'Staff updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $staff = Staff::findOrFail($id);
        $currentUserId = session('staff_id');
        $currentUserRole = session('role');

        // Prevent self-deletion
        if ($staff->id == $currentUserId) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        // Staff cannot delete anyone
        if ($currentUserRole === 'Staff') {
            return redirect()->back()->with('error', 'Unauthorized deletion attempt.');
        }

        $staff->delete();
        return redirect()->route('admin.employee')->with('success', 'Staff deleted successfully.');
    }


    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        if (!empty($query)) {
            $staff = Staff::where('first_name', 'like', "%$query%")
                        ->orWhere('last_name', 'like', "%$query%")
                        ->orWhereHas('role', function ($q) use ($query) {
                            $q->where('name', 'like', "%$query%");
                        })
                        ->with(['role', 'credential'])
                        ->paginate(5);
        } else {
            // If query is empty, return full paginated list
            $staff = Staff::with(['role', 'credential'])->paginate(5);
        }

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.staff.partials.staff-cards', compact('staff'))->render();
        } else {
            return view('admin.staff.partials.staff-table', compact('staff'))->render();
        }
    }
}
