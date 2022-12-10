<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceProduct;

class InvoiceController extends Controller
{
    public function getUserInvoice()
    {
        // get invoice info with invoice_product table
        $invoices = Invoice::with('invoice_products')->where('user_id', auth()->user()->id)->get();
        return response()->json($invoices);

    }

    public function create(Request $request)
    {
        // accept array of product_id
        $request->validate([
            'products' => 'required',
        ]);

        $invoice = Invoice::create([
            'user_id' => auth()->user()->id,
            'invoice_date' => now()
        ]);

        
        // create invoice_product table from array of product_id
        foreach ($request->products as $product) {
            $invoice_product = InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
        }
        return response()->json($invoice);
        

    }
}
