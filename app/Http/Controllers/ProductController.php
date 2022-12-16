<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Helpers\isExist;
use Illuminate\Validation\Rules\File;

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
            'price' => 'required',
            'image' => File::types(['jpg', 'png', 'jpeg'])->max(1024 * 10),
        ]);

        // check if category exist

        if (!isExist::isExist('Category', 'id', $request->category)) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->storePublicly('photos', 'public');
            $url = asset('storage/' . $path);
        }


        $product = Product::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $url ?? null
            ]
        );

        if ($request->category) {
            $product->categories()->attach($request->category);
        }

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {

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
