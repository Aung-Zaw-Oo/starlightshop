<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomerSession;
use Jenssegers\Agent\Agent;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['credential'])->paginate(10);
        return view('admin.customer.customer', compact('customers'));
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
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:credentials,email',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        // Create credential
        $credential = Credential::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Handle image upload
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
        if (session('role') === 'Staff') {
            return redirect()->back()->with('error', 'You are not authorized to edit customers.');
        }

        $customer = Customer::with(['credential'])->findOrFail($id);

        return view('admin.customer.customer_edit', compact('customer'));
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
    
    // Register Form
    public function registerForm(){
        return view('customer.register');
    }

    // Register Process
    public function registerProcess(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:credentials',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^\+?[0-9\s\-]{7,20}$/',
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:1900|max:9999',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $validated['image'] = $imagePath;
        }

        $dob = $validated['year'] . '-' . $validated['month'] . '-' . $validated['day'];

        $credential = Credential::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'dob' => $dob,
            'day' => $validated['day'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'image' => $imagePath,
            'credential_id' => $credential->id,
        ]);

        return redirect()->route('customer.loginForm');
    }

    // Login Form
    public function loginForm()
    {
        return view('customer.login');
    }

    // Login Process
    public function loginProcess(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the credential record by email
        $credential = Credential::where('email', $validated['email'])->first();

        // Check if credential exists and the password matches the hashed password in DB
        if ($credential && Hash::check($validated['password'], $credential->password)) {
            // Get the associated customer model
            $customer = $credential->customer;

            if ($customer) {
                // Store relevant customer info in session
                session()->put([
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $credential->email,
                    'customer_address' => $customer->address,
                    'customer_phone' => $customer->phone,
                    'customer_dob' => $customer->dob,
                    'customer_image' => $customer->image
                ]);

                // Detect browser and device info using Agent package
                $agent = new Agent();
                $browser = $agent->browser();

                if ($agent->isDesktop()) {
                    $device = 'Desktop';
                } elseif ($agent->isTablet()) {
                    $device = 'Tablet';
                } elseif ($agent->isMobile()) {
                    $device = 'Mobile';
                } else {
                    $device = 'Other';
                }

                // Check if a CustomerSession already exists for this credential
                $existingSession = CustomerSession::where('credential_id', $credential->id)->first();

                if ($existingSession) {
                    // Increment visit count and update browser/device info
                    $existingSession->increment('visit_count');
                    $existingSession->update([
                        'browser' => $browser,
                        'device' => $device,
                    ]);
                } else {
                    // Create a new session record if none exists
                    CustomerSession::create([
                        'credential_id' => $credential->id,
                        'browser' => $browser,
                        'device' => $device,
                        'visit_count' => 1,
                        'percentage' => 0,
                        'status' => 'active',
                    ]);
                }

                // Recalculate the visit percentage for all sessions
                $totalVisits = CustomerSession::sum('visit_count');
                $allSessions = CustomerSession::all();

                foreach ($allSessions as $session) {
                    $percentage = $totalVisits > 0
                        ? round(($session->visit_count / $totalVisits) * 100, 2)
                        : 0;

                    $session->update(['percentage' => $percentage]);
                }

                // Redirect to home with success message after login
                return redirect()->to(route('customer.home'))->with('success', 'Login successful');
            }
        }

        // Redirect back to login form with generic error if credentials invalid
        return redirect()->route('customer.loginForm')->with('error', 'Invalid credentials');
    }



    // Logout
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.home')->with('logged_out', true);
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $customers = Customer::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', "%$query%")
                ->orWhere('phone', 'like', "%$query%")
                ->orWhereHas('credential', function ($q) use ($query) {
                    $q->where('email', 'like', "%$query%");
                })
                // Total amount spent
                ->orWhereIn('id', function ($sub) use ($query) {
                    $sub->select('customers.id')
                        ->from('customers')
                        ->join('orders', 'customers.id', '=', 'orders.customer_id')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->groupBy('customers.id')
                        ->havingRaw('SUM(order_details.price * order_details.qty) LIKE ?', ["%$query%"]);
                })
                // Total items bought
                ->orWhereIn('id', function ($sub) use ($query) {
                    $sub->select('customers.id')
                        ->from('customers')
                        ->join('orders', 'customers.id', '=', 'orders.customer_id')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->groupBy('customers.id')
                        ->havingRaw('SUM(order_details.qty) LIKE ?', ["%$query%"]);
                });
        })
        ->with('credential')
        ->paginate(10);

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.customer.partials.customer-card', compact('customers'))->render();
        } else {
            return view('admin.customer.partials.customer-table', compact('customers'))->render();
        }
    }
}
