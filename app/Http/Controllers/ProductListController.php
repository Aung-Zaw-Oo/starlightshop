<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('customer.product_list', compact('products'));
    }
}
