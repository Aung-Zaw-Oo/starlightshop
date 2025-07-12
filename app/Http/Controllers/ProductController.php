<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.product.product', compact('products'));
    }

    public function create()
    {
        if (session('role') === 'Staff') {
            return redirect()->back()->with('error', 'You are not authorized to create products.');
        }

        $categories = Category::where('status', 'active')->get();
        return view('admin.product.product_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'sale_price' => $validated['sale_price'],
            'staff_id' => session('staff_id'),
            'purchase_price' => $validated['purchase_price'],
            'qty' => $validated['qty'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'status' => 'Active'
        ]);

        return redirect()->route('admin.product')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit($id)
    {

        if (session('role') === 'Staff') {
            return redirect()->back()->with('error', 'You are not authorized to create products.');
        }

        $product = Product::findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        return view('admin..product.product_edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $imagePath = $request->file('image')->store('uploads', 'public');
                $product->image = $imagePath;
            }

            $product->update([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'sale_price' => $validated['sale_price'],
                'purchase_price' => $validated['purchase_price'],
                'qty' => $validated['qty'],
                'description' => $validated['description'] ?? '',
            ]);

            return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->withErrors(['name' => 'Product name already exists. Please choose a different name.']);
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred. Please try again.']);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.product')->with('success', 'Product deleted successfully.');
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $products = Product::with('category')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('sale_price', 'like', "%$query%")
                    ->orWhere('purchase_price', 'like', "%$query%")
                    ->orWhere('qty', 'like', "%$query%")
                    ->orWhere('status', 'like', "%$query%")
                    ->orWhereHas('category', function ($q2) use ($query) {
                        $q2->where('name', 'like', "%$query%");
                    });
            })
            ->paginate(10);

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.product.partials.product-card', compact('products'))->render();
        } else {
            return view('admin.product.partials.product-table', compact('products'))->render();
        }
    }
}
