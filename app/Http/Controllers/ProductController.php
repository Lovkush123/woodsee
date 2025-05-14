<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'thickness' => 'nullable|string',
            'size' => 'nullable|string',
            'application' => 'nullable|string',
            'woodtype' => 'nullable|string',
            'corematerial' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Handle file uploads
        if ($request->hasFile('image1')) {
            $validated['image1'] = $request->file('image1')->store('products', 'public');
        }

        if ($request->hasFile('image2')) {
            $validated['image2'] = $request->file('image2')->store('products', 'public');
        }

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::with(['sizes', 'images'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) return response()->json(['message' => 'Product not found'], 404);

        $validated = $request->validate([
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'thickness' => 'nullable|string',
            'size' => 'nullable|string',
            'application' => 'nullable|string',
            'woodtype' => 'nullable|string',
            'corematerial' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
        ]);

        // Handle file uploads
        if ($request->hasFile('image1')) {
            $validated['image1'] = $request->file('image1')->store('products', 'public');
        }

        if ($request->hasFile('image2')) {
            $validated['image2'] = $request->file('image2')->store('products', 'public');
        }

        $product->update($validated);

        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) return response()->json(['message' => 'Product not found'], 404);

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
