<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index(){
        $products = Product::paginate(10);
        $categories = Category::all();
        return view('customer.product_list', compact('products', 'categories'));
    }

    public function productDetail($id){
        $product = Product::findOrFail($id);
        return view('customer.product_detail', compact('product'));
    }

    // Ajax Search
    public function ajaxSearch(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if ($request->filled('categories')) {
            $categoryIds = explode(',', $request->categories);
            $categoryIds = array_filter($categoryIds, function($id) {
                return !empty(trim($id)) && is_numeric(trim($id));
            });
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($request->filled('minPrice') && is_numeric($request->minPrice)) {
            $query->where('sale_price', '>=', $request->minPrice);
        }
        if ($request->filled('maxPrice') && is_numeric($request->maxPrice)) {
            $query->where('sale_price', '<=', $request->maxPrice);
        }

        switch ($request->sort) {
            case 'price-low':
                $query->orderBy('sale_price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('sale_price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10)->appends($request->except('page'));
        $view = view('customer.product.partials.product_list', compact('products'))->render();
        $pagination = $products->onEachSide(1)->links('vendor.pagination.custom')->render();

        return response()->json([
            'html' => $view,
            'pagination' => $pagination,
        ]);
    }
}
