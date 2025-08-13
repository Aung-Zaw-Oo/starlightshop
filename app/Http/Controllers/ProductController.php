<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        $categories = Category::where('status', 'active')->get();
        return view('admin.product.product', compact('products','categories'));
    }

    public function create()
    {
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
            'image' => 'required|image|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'name.unique' => 'Product name already exists.',
            'name.max' => 'Product name should not exceed 255 characters.',
            'category_id.required' => 'Category is required.',
            'sale_price.required' => 'Sale price is required.',
            'purchase_price.required' => 'Purchase price is required.',
            'qty.required' => 'Quantity is required.',
            'image.required' => 'Product Image is required.',
            'image.image' => 'Please upload a valid image file.',
            'image.max' => 'Image size should not exceed 2MB.',
            'description.max' => 'Description should not exceed 255 characters.',
        ]);

        // Custom validation for sale price > purchase price
        if ($validated['sale_price'] <= $validated['purchase_price']) {
            return back()
                ->withErrors(['sale_price' => 'Sale price must be greater than purchase price.'])
                ->withInput();
        }

        $uuid = Str::uuid()->toString();
        $imagePath = 'uploads/'.$uuid.'.'.$request->image->extension();
        $request->image->move(public_path('storage/uploads'), $imagePath);

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
        ],[
            'name.required' => 'Product name is required.',
            'name.max' => 'Product name should not exceed 255 characters.',
            'category_id.required' => 'Category is required.',
            'sale_price.required' => 'Sale price is required.',
            'purchase_price.required' => 'Purchase price is required.',
            'qty.required' => 'Quantity is required.',
            'image.image' => 'Please upload a valid image file.',
            'image.max' => 'Image size should not exceed 2MB.',
            'description.max' => 'Description should not exceed 255 characters.',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'sale_price' => $validated['sale_price'],
                'purchase_price' => $validated['purchase_price'],
                'qty' => $validated['qty'],
                'description' => $validated['description'] ?? '',
            ];

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image && File::exists(public_path('storage/' . $product->image))) {
                    File::delete(public_path('storage/' . $product->image));
                }                

                $uuid = Str::uuid()->toString();
                $imagePath =  'uploads/'.$uuid.'.'.$request->image->extension();
                $request->image->move(public_path('storage/uploads'), $imagePath);

                $updateData['image'] = $imagePath;
            }

            // Update product with all fields
            $product->update($updateData);

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

        // delete old file
        if ($product->image && File::exists(public_path('storage/' . $product->image))) {
            File::delete(public_path('storage/' . $product->image));
        }    

        $product->delete();
        return redirect()->route('admin.product')->with('info', 'Product deleted successfully.');
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        $categoryId = $request->get('category');

        $products = Product::with('category')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('name', 'like', "%$query%")
                        ->orWhere('sale_price', 'like', "%$query%")
                        ->orWhere('purchase_price', 'like', "%$query%")
                        ->orWhere('qty', 'like', "%$query%")
                        ->orWhere('status', 'like', "%$query%")
                        ->orWhereHas('category', function ($q3) use ($query) {
                            $q3->where('name', 'like', "%$query%");
                        });
                });
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
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
