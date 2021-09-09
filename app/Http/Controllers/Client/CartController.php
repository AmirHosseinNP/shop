<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('client.cart.index', [
            'items' => Cart::getProductsInCart(),
            'total_cost' => session()->has('cart') ? Cart::totalCost() : null,
            'total_cost_with_discount' => session()->has('cart') ? Cart::totalCostWithDiscount() : null,
            'total_discount' => session()->has('cart') ? Cart::calculateTotalDiscount() : null,
            'total_items' => session()->has('cart') ? Cart::totalItems() : null
        ]);
    }

    public function store(Product $product,Request $request)
    {
        Cart::new($product, $request);

        return response()->json(
            [
                'cart' => session()->get('cart'),
                'msg' => 'successful'
            ], 200);
    }

    public function destroy(Product $product)
    {
        Cart::delete($product);

        return response()->json(
            [
                'cart' => session()->get('cart'),
                'msg' => 'deleted'
            ], 200);
    }
}
