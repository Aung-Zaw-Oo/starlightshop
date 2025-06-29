<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);
        return view('admin.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUserRole = session('role');

        // Example authorization: prevent Staff from creating categories
        if ($currentUserRole === 'Staff') {
            return redirect()->back()->with('error', 'You are not authorized to create categories.');
        }

        $category = Category::where('status', 'active')->get();
        return view('admin.category_create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

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

        if (session('role') === 'Staff') {
            return redirect()->back()->with('error', 'You are not authorized to edit categories.');
        }

        return view('admin.category_edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $currentUserRole = session('role');

        // Staff are not authorized to update categories
        if ($currentUserRole === 'Staff') {
            return redirect()->back()->with('error', 'Unauthorized update attempt.');
        }

        // Validate inputs - use lowercase status to match DB enum
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload and delete old one if exists
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
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
        $currentUserRole = session('role');

        // Staff cannot delete
        if ($currentUserRole === 'Staff') {
            return redirect()->back()->with('error', 'Unauthorized deletion attempt.');
        }

        $category->delete();
        return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
    }


   public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        if (!empty($query)) {
            $categories = Category::where('name', 'like', "%$query%")
                        ->paginate(5);
        } else {
            // If query is empty, return full paginated list
            $categories = Category::paginate(5);
        }

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.category.partials.category-cards', compact('categories'))->render();
        } else {
            return view('admin.category.partials.category-table', compact('categories'))->render();
        }
    }
}
