<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the images.
     */
    public function index()
    {
        $images = Image::all();

        // Append full URL to each image
        $images->transform(function ($image) {
            $image->image_url = Storage::url($image->image);
            return $image;
        });

        return response()->json($images);
    }

    /**
     * Store a newly created image.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // Store image in 'public/images' and get the path
        $path = $request->file('image')->store('images', 'public');

        // Create image record
        $image = Image::create([
            'product_id' => $request->product_id,
            'image' => $path,
            'is_active' => $request->is_active,
        ]);

        // Add image URL to response
        $image->image_url = Storage::url($image->image);

        return response()->json($image, 201);
    }

    /**
     * Display the specified image.
     */
    public function show(Image $image)
    {
        $image->image_url = Storage::url($image->image);
        return response()->json($image);
    }

    /**
     * Update the specified image.
     */
    public function update(Request $request, Image $image)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // If new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image file
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }

            // Save new image
            $path = $request->file('image')->store('images', 'public');
            $image->image = $path;
        }

        $image->product_id = $request->product_id;
        $image->is_active = $request->is_active;
        $image->save();

        $image->image_url = Storage::url($image->image);

        return response()->json($image);
    }

    /**
     * Remove the specified image.
     */
    public function destroy(Image $image)
    {
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return response()->json(null, 204);
    }
}
