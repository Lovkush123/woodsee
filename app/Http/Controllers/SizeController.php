<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Fetch all sizes
    public function index()
    {
        return response()->json(Size::all(), 200);
    }

    // Store new size
    public function store(Request $request)
    {
        $validated = $request->validate([
            'squirefit' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_id' => 'required|exists:products,id', // Validate product_id
        ]);

        $size = Size::create($validated);

        return response()->json($size, 201);
    }

    // Show single size by ID
    public function show($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        return response()->json($size, 200);
    }

    // Update size
    public function update(Request $request, $id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $validated = $request->validate([
            'squirefit' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'product_id' => 'sometimes|exists:products,id', // Allow updating product_id
        ]);

        $size->update($validated);

        return response()->json($size, 200);
    }

    // Delete size
    public function destroy($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $size->delete();

        return response()->json(['message' => 'Size deleted successfully'], 200);
    }
}
 