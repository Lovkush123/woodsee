<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the main categories.
     */
    public function index()
    {
        $categories = MainCategory::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created main category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('main_category_images', 'public');
        }

        $category = MainCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Main Category created successfully!',
            'category' => $category,
        ]);
    }

    /**
     * Display the specified main category.
     */
    public function show($id)
    {
        $category = MainCategory::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified main category.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = MainCategory::findOrFail($id);

        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->store('main_category_images', 'public');
            $category->image = $imagePath;
        }

        // Update fields
        if ($request->has('name')) {
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
        }

        $category->description = $request->description ?? $category->description;
        $category->save();

        return response()->json([
            'message' => 'Main Category updated successfully!',
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified main category.
     */
    public function destroy($id)
    {
        $category = MainCategory::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'message' => 'Main Category deleted successfully!',
        ]);
    }
}
