<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // crud functions for products
    public function getAll()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function getById($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function create(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);
    }

    public function update(Request $request, $id)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);

        $product = Product::find($id);
        $product->update($request->all());

        return response()->json($product);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
    }

}
