<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['credential'])->paginate(5);
        return view('admin.customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs - adjust as needed
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:credentials,email',
            'password' => 'required|string|min:6|confirmed',
            'item_bought' => 'required|string|max:255',
            'money_spent' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        // Create credential
        $credential = Credential::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        // Create customer linked to credential
        Customer::create([
            'credential_id' => $credential->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'item_bought' => $validated['item_bought'],
            'money_spent' => $validated['money_spent'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.customer')->with('success', 'Customer created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::with(['credential'])->findOrFail($id);

        return view('admin.customer_edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $credentialId = $customer->credential_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:credentials,email,' . $credentialId,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            if ($customer->image && Storage::disk('public')->exists($customer->image)) {
                Storage::disk('public')->delete($customer->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
            $customer->image = $imagePath;
        }

        // Update related credential's email
        $credential = Credential::findOrFail($credentialId);
        $credential->email = $validated['email'];
        $credential->save();

        // Update customer fields
        $customer->name = $validated['name'];
        $customer->phone = $validated['phone'];
        if ($validated['password']) {
            $credential->password = Hash::make($validated['password']);
        }

        $customer->save();

        return redirect()->route('admin.customer')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $credential = Credential::findOrFail($customer->credential_id);

        $customer->delete();
        $credential->delete();

        return redirect()->route('admin.customer')->with('success', 'Customer deleted successfully.');
    }


    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        if (!empty($query)) {
            $customers = Customer::where('name', 'like', "%$query%")
                ->orWhere('phone', 'like', "%$query%")
                ->orWhereHas('credential', function ($q) use ($query) {
                    $q->where('email', 'like', "%$query%");
                })
                // ->orWhere('item_bought', 'like', "%$query%")
                // ->orWhere('money_spent', 'like', "%$query%")
                ->with('credential')
                ->paginate(5);
        } else {
            $customers = Customer::with('credential')->paginate(5);
        }

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.customer.partials.customer-cards', compact('customers'))->render();
        } else {
            return view('admin.customer.partials.customer-table', compact('customers'))->render();
        }
    }
}
