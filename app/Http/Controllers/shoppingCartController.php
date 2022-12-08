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

        // calculate total price using getTotalPriceAttribute in ShoppingCart model
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->total_price;
        }

        // calculate total quantity using getTotalQuantityAttribute in ShoppingCart model
        $totalQuantity = 0;
        foreach ($cart as $item) {
            $totalQuantity += $item->total_quantity;
        }

        // get total price and total quantity for each product in cart
        $products = [];
        foreach ($cart as $item) {
            $products[] = [
                'id' => $item->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
                'total_quantity' => $item->total_quantity,
            ];
        }

        

        return response()->json([
            'products' => $products,
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
        ]);


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
