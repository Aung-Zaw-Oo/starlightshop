<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index(){
        $products = Product::paginate(12);
        $categories = Category::all();
        return view('customer.product_list', compact('products', 'categories'));
    }

    public function productDetail($id){
        $product = Product::findOrFail($id);
        return view('customer.product_detail', compact('product'));
    }
}
