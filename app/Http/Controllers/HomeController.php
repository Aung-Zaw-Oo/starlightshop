<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        $topSellings = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(order_details.qty) as total_qty')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_qty')
            ->take(3)
            ->get();

        return view('customer.home', compact('products', 'categories', 'topSellings'));
    }
}
