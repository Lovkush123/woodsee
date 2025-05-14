<?php

namespace App\Http\Controllers;

use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderListController extends Controller
{
    // GET /order-list
    public function index()
    {
        $orders = OrderList::with('order.product', 'order.size')->get();
    
        return response()->json([
            'order_list' => $orders
        ]);
    }
    

    // POST /order-list
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'order_ref_id' => 'required|integer', // New field
            'status' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'tax_amount' => 'nullable|numeric',
            'delivery_charges' => 'nullable|numeric',
        ]);

        // Generate a unique order_id (custom format)
        $validated['order_id'] = 'ORD-' . strtoupper(Str::random(8));

        $order = OrderList::create($validated);
        return response()->json($order, 201);
    }

    // GET /order-list/{id}
    public function show($id)
{
    $order = OrderList::with('order.product', 'order.size')->findOrFail($id);

    return response()->json([
        'order_list' => $order
    ]);
}


    // PUT/PATCH /order-list/{id}
    public function update(Request $request, $id)
    {
        $order = OrderList::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|string|max:50',
            'amount' => 'sometimes|numeric',
            'tax_amount' => 'sometimes|numeric',
            'delivery_charges' => 'sometimes|numeric',
            'order_ref_id' => 'sometimes|integer', // Include for update
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    // DELETE /order-list/{id}
    public function destroy($id)
    {
        $order = OrderList::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }
}
