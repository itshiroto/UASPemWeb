<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // crud functions for products
    public function getAll()
    {
        $products = Product::with('categories')->get();
        return response()->json($products);
    }

    public function getById($id)
    {
        $product = Product::with('categories')->find($id);
        return response()->json($product);
    }

    public function create(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

    

        $product = Product::create(
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );

            
        if ($request->category) {
            $product->categories()->attach($request->category);
        }

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $product = Product::find($id);

        $product->update(
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );

        if ($request->category) {
            $product->categories()->sync($request->category);
        }

        return response()->json($product);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
    }

    public function getByCategory($id)
    {
        $products = Product::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->get();

        return response()->json($products);
    }

}
