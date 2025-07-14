<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Models\Customer;
use App\Models\CustomerSession;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
        $details = OrderDetail::with('product', 'order')->get();
        $orderCount = Order::count();
        $signupCount = Customer::count();
        $sessions = CustomerSession::get();

        // Device Count
        $mobileCount = 0;
        $desktopCount = 0;
        $tabletCount = 0;

        // Browser Count
        $chromeCount = 0;
        $firefoxCount = 0;
        $safariCount = 0;
        $otherCount = 0;

        foreach ($sessions as $session) {
            $device = $session->device;
            if ($device == 'Mobile') {
                $mobileCount++;
            } elseif ($device == 'Desktop') {
                $desktopCount++;
            } elseif ($device == 'Tablet') {
                $tabletCount++;
            }

            $browser = $session->browser;
            if ($browser == 'Chrome') {
                $chromeCount++;
            } elseif ($browser == 'Firefox') {
                $firefoxCount++;
            } elseif ($browser == 'Safari') {
                $safariCount++;
            } else {
                $otherCount++;
            }
        }

        $totalIncome = 0;
        $totalProfit = 0;
    
        // Dashboard Cards KPI Data Calculation
        foreach ($details as $detail) {
            $qty = $detail->qty;
            $salePrice = $detail->product->sale_price ?? 0;
            $purchasePrice = $detail->product->purchase_price ?? 0;

            $totalIncome += $qty * $salePrice;
            $totalProfit += $qty * ($salePrice - $purchasePrice);
        }

        // Dashboard Order Chart Dynamic Data
        $ordersThisWeek = Order::selectRaw('DAYNAME(order_date) as day, COUNT(*) as count')
            ->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('day')
            ->pluck('count', 'day'); // ['Monday' => 30, ...]

        $dayMap = [
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday',
        ];

        $ordersPerDay = collect($dayMap)->map(function ($full, $short) use ($ordersThisWeek) {
            $count = $ordersThisWeek[$full] ?? 0;
            return [$short, $count, $count];
        })->values();

        $todayName = now()->format('l'); // e.g., 'Monday'
        $todayOrderCount = $ordersThisWeek[$todayName] ?? 0;

        // Dashboard Profit Chart Dynamic Data
        $monthlyData = OrderDetail::with('product', 'order')
            ->whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($detail) {
                return Carbon::parse($detail->order->order_date)->format('M'); // Jan, Feb, etc.
            })
            ->map(function ($details) {
                $income = $details->sum(function ($d) {
                    return $d->qty * ($d->product->sale_price ?? 0);
                });

                $expense = $details->sum(function ($d) {
                    return $d->qty * ($d->product->purchase_price ?? 0);
                });

                return [
                    'income' => $income,
                    'expense' => $expense
                ];
            });

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $monthlyChartData = collect($months)->map(function ($month) use ($monthlyData) {
            $income = $monthlyData[$month]['income'] ?? 0;
            $expense = $monthlyData[$month]['expense'] ?? 0;
            return [$month, $income, $expense];
        });


        return view('admin.dashboard.dashboard', compact(
            'totalIncome',
            'orderCount',
            'totalProfit',
            'signupCount',
            'todayOrderCount',
            'ordersPerDay',
            'monthlyChartData',
            'mobileCount',
            'desktopCount',
            'tabletCount',
            'chromeCount',
            'firefoxCount',
            'safariCount',
            'otherCount'
        ));
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
