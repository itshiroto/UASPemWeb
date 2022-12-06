<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // crud functions for categories
    public function getAll()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getById($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function create(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create($request->all());

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

    //    update category with id $id
        $category = Category::find($id);
        $category->update($request->all());

        return response()->json($category);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json($category->name . ' deleted');  
    }
}
