<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ShoppingCart;

class shoppingCartController extends Controller
{
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $cart = ShoppingCart::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cart);
    }

    public function getCart()
    {
        // get products in cart by user id
        $cart = ShoppingCart::where('user_id', auth()->user()->id)->get();

        return response()->json($cart);


    }

    public function updateCart(Request $request, $id)
    {
        $cart = ShoppingCart::find($id);

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json($cart);
    }

    public function deleteCart($id)
    {
        $cart = ShoppingCart::find($id);
        $cart->delete();

        return response()->json($cart);
    }
}
