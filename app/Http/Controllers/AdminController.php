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
        $totalOrder = Order::where('order_status', '!=' ,'cancelled')->count();
        $orderThisWeek = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $totalSignup = Customer::count();
        $signupThisWeek = Customer::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

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

        $details = OrderDetail::with('product', 'order')->get();
        $totalIncome = 0;
        $incomeThisWeek = 0;

        $totalProfit = 0;
        $profitThisWeek = 0;
        // Dashboard Cards KPI Data Calculation
        foreach ($details as $detail) {
            $qty = $detail->qty;
            $salePrice = $detail->product->sale_price ?? 0;
            $purchasePrice = $detail->product->purchase_price ?? 0;

            $totalIncome += $qty * $salePrice;
            if ($detail->order->order_date >= now()->startOfWeek() && $detail->order->order_date <= now()->endOfWeek()) {
                $incomeThisWeek += $qty * $salePrice;
            }

            $totalProfit += $qty * ($salePrice - $purchasePrice);
            if ($detail->order->order_date >= now()->startOfWeek() && $detail->order->order_date <= now()->endOfWeek()) {
                $profitThisWeek += $qty * ($salePrice - $purchasePrice);
            }
        }

        // Dashboard Order Chart Dynamic Data
        $ordersThisWeek = Order::selectRaw('DAYNAME(order_date) as day, COUNT(*) as count')
            ->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('order_status', '!=' ,'cancelled')
            ->groupBy('day')
            ->pluck('count', 'day');

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

        // Dashboard Profit Expense Chart Dynamic Data - WEEKLY
        $weeklyIncomeExpenseData = OrderDetail::with('product', 'order')
            ->whereHas('order', function($query) {
                $query->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
            })
            ->get()
            ->groupBy(function ($detail) {
                return Carbon::parse($detail->order->order_date)->format('D'); // Mon, Tue, etc.
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

        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $weeklyChartData = collect($weekDays)->map(function ($day) use ($weeklyIncomeExpenseData) {
            $income = $weeklyIncomeExpenseData[$day]['income'] ?? 0;
            $expense = $weeklyIncomeExpenseData[$day]['expense'] ?? 0;
            return [$day, $income, $expense];
        });

        // Dashboard Profit Expense Chart Dynamic Data - MONTHLY
        $monthlyData = OrderDetail::with('product', 'order')
            ->whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($detail) {
                return Carbon::parse($detail->order->order_date)->format('M');
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

        $ordersPerMonth = Order::selectRaw('MONTH(order_date) as month_num, COUNT(*) as count')
            ->whereYear('order_date', now()->year)
            ->groupBy('month_num')
            ->pluck('count', 'month_num');

        $ordersPerMonthChartData = collect($months)->map(function ($month, $index) use ($ordersPerMonth) {
            $monthNumber = $index + 1;
            $count = $ordersPerMonth[$monthNumber] ?? 0;
            return [$month, $count];
        });

        return view('admin.dashboard.dashboard', compact(
            'totalIncome','totalOrder','totalProfit','totalSignup',
            'incomeThisWeek','orderThisWeek','profitThisWeek','signupThisWeek',
            
            'ordersPerDay',
            'ordersPerMonthChartData',

            'weeklyChartData',  // NEW: Weekly column chart data
            'monthlyChartData', // Existing monthly column chart data

            'mobileCount','desktopCount','tabletCount',

            'chromeCount','firefoxCount','safariCount','otherCount',

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
