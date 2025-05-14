<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        return SubCategory::with('mainCategory')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sub_category_images', 'public');
        }

        $subcategory = SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Generate slug from name
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Sub Category created successfully!',
            'subcategory' => $subcategory
        ], 201);
    }

    public function show($id)
    {
        return SubCategory::with('mainCategory')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'main_category_id' => 'sometimes|exists:main_categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $subcategory->image = $request->file('image')->store('sub_category_images', 'public');
        }

        // Update fields including slug if name is updated
        if ($request->filled('name')) {
            $subcategory->slug = Str::slug($request->name);
        }

        $subcategory->update($request->only(['main_category_id', 'name', 'description']));

        return response()->json([
            'message' => 'Sub Category updated successfully!',
            'subcategory' => $subcategory
        ]);
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);

        if ($subcategory->image) {
            Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->delete();

        return response()->json(['message' => 'Sub Category deleted successfully!']);
    }
}
