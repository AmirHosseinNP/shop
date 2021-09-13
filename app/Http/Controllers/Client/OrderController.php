<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('client.orders.create', [
            'items' => Cart::getProductsInCart(),
            'total_cost' => session()->has('cart') ? Cart::totalCost() : null,
            'total_cost_with_discount' => session()->has('cart') ? Cart::totalCostWithDiscount() : null,
            'total_discount' => session()->has('cart') ? Cart::calculateTotalDiscount() : null,
            'total_items' => session()->has('cart') ? Cart::totalItems() : null
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::query()->create([
            'total_amount' => Cart::calculatePayable(),
            'address' => $request->get('address')
        ]);


        foreach (Cart::getProductsInCart() as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            $order->details()->create([
                'product_id' => $product->id,
                'unit_amount' => $product->cost_with_discount,
                'quantity' => $quantity
            ]);
        }

        Cart::removeCart();

        return redirect()->back();
    }
}
