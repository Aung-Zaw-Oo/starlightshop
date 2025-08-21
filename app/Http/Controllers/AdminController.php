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
        ],[
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email format!',
            'password.required' => 'Password is required!'
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
        // Total Orders (excluding cancelled)
        $totalOrder = Order::where('order_status', '!=', 'cancelled')->count();
        $orderThisWeek = Order::where('order_status', '!=', 'cancelled')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Total Signups
        $totalSignup = Customer::count();
        $signupThisWeek = Customer::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // Customer Sessions Count
        $sessions = CustomerSession::get();
        $mobileCount = $desktopCount = $tabletCount = 0;
        $chromeCount = $firefoxCount = $safariCount = $otherCount = 0;

        foreach ($sessions as $session) {
            switch($session->device) {
                case 'Mobile': $mobileCount++; break;
                case 'Desktop': $desktopCount++; break;
                case 'Tablet': $tabletCount++; break;
            }

            switch($session->browser) {
                case 'Chrome': $chromeCount++; break;
                case 'Firefox': $firefoxCount++; break;
                case 'Safari': $safariCount++; break;
                default: $otherCount++; break;
            }
        }

        // Fetch OrderDetails excluding cancelled orders
        $details = OrderDetail::with('product', 'order')
            ->whereHas('order', function($query) {
                $query->where('order_status', '!=', 'cancelled');
            })
            ->get();

        $totalIncome = $incomeThisWeek = 0;
        $totalProfit = $profitThisWeek = 0;

        foreach ($details as $detail) {
            $qty = $detail->qty;
            $salePrice = $detail->product->sale_price ?? 0;
            $purchasePrice = $detail->product->purchase_price ?? 0;

            $totalIncome += $qty * $salePrice;
            $totalProfit += $qty * ($salePrice - $purchasePrice);

            if ($detail->order->order_date >= now()->startOfWeek() && $detail->order->order_date <= now()->endOfWeek()) {
                $incomeThisWeek += $qty * $salePrice;
                $profitThisWeek += $qty * ($salePrice - $purchasePrice);
            }
        }

        // Orders per Day (weekly)
        $ordersThisWeek = Order::selectRaw('DAYNAME(order_date) as day, COUNT(*) as count')
            ->where('order_status', '!=', 'cancelled')
            ->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('day')
            ->pluck('count', 'day');

        $dayMap = ['Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday'];
        $ordersPerDay = collect($dayMap)->map(fn($full,$short) => [$short, $ordersThisWeek[$full] ?? 0, $ordersThisWeek[$full] ?? 0])->values();

        // Weekly Income & Expense Chart
        $weeklyIncomeExpenseData = OrderDetail::with('product', 'order')
            ->whereHas('order', function($q) {
                $q->where('order_status', '!=', 'cancelled')
                ->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
            })
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->order->order_date)->format('D'))
            ->map(fn($details) => [
                'income' => $details->sum(fn($d) => $d->qty * ($d->product->sale_price ?? 0)),
                'expense' => $details->sum(fn($d) => $d->qty * ($d->product->purchase_price ?? 0))
            ]);

        $weekDays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $weeklyChartData = collect($weekDays)->map(fn($day) => [
            $day,
            $weeklyIncomeExpenseData[$day]['income'] ?? 0,
            $weeklyIncomeExpenseData[$day]['expense'] ?? 0
        ]);

        // Monthly Income & Expense Chart
        $monthlyData = OrderDetail::with('product', 'order')
            ->whereHas('order', fn($q) => $q->where('order_status','!=','cancelled')->whereYear('order_date', now()->year))
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->order->order_date)->format('M'))
            ->map(fn($details) => [
                'income' => $details->sum(fn($d) => $d->qty * ($d->product->sale_price ?? 0)),
                'expense' => $details->sum(fn($d) => $d->qty * ($d->product->purchase_price ?? 0))
            ]);

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $monthlyChartData = collect($months)->map(fn($month) => [
            $month,
            $monthlyData[$month]['income'] ?? 0,
            $monthlyData[$month]['expense'] ?? 0
        ]);

        // Orders per Month
        $ordersPerMonth = Order::selectRaw('MONTH(order_date) as month_num, COUNT(*) as count')
            ->where('order_status', '!=', 'cancelled')
            ->whereYear('order_date', now()->year)
            ->groupBy('month_num')
            ->pluck('count','month_num');

        $ordersPerMonthChartData = collect($months)->map(fn($month, $index) => [
            $month,
            $ordersPerMonth[$index+1] ?? 0
        ]);

        return view('admin.dashboard.dashboard', compact(
            'totalIncome','totalOrder','totalProfit','totalSignup',
            'incomeThisWeek','orderThisWeek','profitThisWeek','signupThisWeek',
            'ordersPerDay','ordersPerMonthChartData',
            'weeklyChartData','monthlyChartData',
            'mobileCount','desktopCount','tabletCount',
            'chromeCount','firefoxCount','safariCount','otherCount'
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
