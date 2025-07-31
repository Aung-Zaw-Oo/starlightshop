<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.category.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::where('status', 'active')->get();
        return view('admin.category.category_create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'required|image|max:2048',
        ],[
            'name.required' => 'Category name is required.',
            'name.max' => 'Category name should not exceed 255 characters.',
            'image.image' => 'Please upload a valid image file.',
            'image.max' => 'Image size should not exceed 2MB.',
        ]);

        // Handle image upload
        $uuid = Str::uuid()->toString();
        $imagePath =  'uploads/'.$uuid.'.'.$request->image->extension();
        $request->image->move(public_path('storage/uploads'), $imagePath);

        // Create category with uploaded image path        
        $category = Category::create([
            'name' => $validated['name'],
            'image' => $imagePath,
        ]);

        $category->save();

        return redirect()->route('admin.category')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.category_edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:active,inactive',
    ]);

    if ($request->hasFile('image')) {
        if ($category->image && File::exists(public_path('storage/' . $category->image))) {
            File::delete(public_path('storage/' . $category->image));
        }

        $uuid = Str::uuid()->toString();
        $imagePath = 'uploads/' . $uuid . '.' . $request->image->extension();
        $request->image->move(public_path('storage/uploads'), $imagePath);

        $category->image = $imagePath;
    }

    $category->name = $validated['name'];
    $category->status = $validated['status'];
    $category->save();

    return redirect()->route('admin.category')->with('success', 'Category updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $category = Category::findOrFail($id);

        File::delete(public_path('storage/' . $category->image));

        $category->delete();
        return redirect()->route('admin.category')->with('info', 'Category deleted successfully.');
    }


   public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $categories = Category::where('name', 'like', "%$query%")
            ->orWhere('status', 'like', "%$query%")
                        ->paginate(10);

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.category.partials.category-card', compact('categories'))->render();
        } else {
            return view('admin.category.partials.category-table', compact('categories'))->render();
        }
    }
}
