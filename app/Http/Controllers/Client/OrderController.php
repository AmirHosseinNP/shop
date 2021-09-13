<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;


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

        $invoice = (new Invoice())->amount($order->total_amount);

        return Payment::purchase($invoice, function ($driver, $transactionId) use($order) {
            $order->update([
                'transaction_id' => $transactionId
            ]);
        })->pay()->render();
    }

    public function show(Order $order)
    {
        Cart::removeCart();
        return view('client.orders.show', compact('order'));
    }

    public function verify(Request $request)
    {
        $order = Order::query()->where('transaction_id', $request->get('Authority'))->first();

        $order->update([
            'payment_status' => $request->get('Status')
        ]);

        return redirect(route('client.orders.show', $order));
    }
}
