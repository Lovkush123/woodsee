<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF; // ← Import the PDF facade

class InvoiceController extends Controller
{
    public function generateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'invoice_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Generate a unique invoice number
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        // Step 1: Create invoice record without link
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'invoice_date' => $request->invoice_date,
            'status' => 'unpaid',
        ]);

        // Step 2: Generate the PDF using a Blade view
        $pdf = PDF::loadView('invoice.pdf', compact('invoice'));

        // Step 3: Store PDF in /storage/app/public/invoices/
        $fileName = 'invoices/' . $invoiceNumber . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        // Step 4: Update invoice with link to stored file
        $invoice->invoice_link = 'storage/' . $fileName;
        $invoice->save();

        return response()->json(['invoice' => $invoice], 201);
    }

    public function getInvoice($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json(['invoice' => $invoice]);
    }

    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:paid,unpaid,pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $invoice->status = $request->status;
        $invoice->save();

        return response()->json(['message' => 'Invoice status updated successfully', 'invoice' => $invoice]);
    }
}
