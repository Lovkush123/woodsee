<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Fetch all orders
    public function index()
    {
        return response()->json([
            'status' => true,
            'orders' => Order::with(['product', 'size'])->get(),
        ]);
    }

    // Store a new order
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id'      => 'required|exists:products,id',
                'size_id'         => 'nullable|exists:sizes,id',
                'qty'             => 'required|integer|min:1', // Added qty validation
                'amount'          => 'required|numeric',
                'tax'             => 'required|numeric',
                'total_amount'    => 'required|numeric',
                'delivery_amount' => 'required|numeric',
            ]);

            $order = Order::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Order created successfully',
                'order'   => $order->load(['product', 'size'])
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Order store error: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while creating the order',
            ], 500);
        }
    }

    // Show single order
    public function show($id)
    {
        $order = Order::with(['product', 'size'])->find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json(['status' => true, 'order' => $order]);
    }

    // Update order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'product_id'      => 'sometimes|exists:products,id',
            'size_id'         => 'sometimes|nullable|exists:sizes,id',
            'qty'             => 'sometimes|integer|min:1', // Added qty validation
            'amount'          => 'sometimes|numeric',
            'tax'             => 'sometimes|numeric',
            'total_amount'    => 'sometimes|numeric',
            'delivery_amount' => 'sometimes|numeric',
        ]);

        $order->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Order updated successfully',
            'order' => $order->load(['product', 'size'])
        ]);
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['status' => true, 'message' => 'Order deleted successfully']);
    }
}
