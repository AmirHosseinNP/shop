<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;

class Cart
{

    public static function new(Product $product, Request $request)
    {
        if (session()->has('cart')) {
            $cart = session('cart');
            $checkProductExistsInCart = Cart::checkProductExistsInCart($cart, $product);

            if (!in_array(true, $checkProductExistsInCart)) {
                $cart['products'][] = [
                    'product' => $product,
                    'quantity' => $request->get('quantity')
                ];

                session()->put('cart', $cart);

                $cart['total_items'] = Cart::totalItems();
                $cart['total_cost'] = Cart::totalCost();
                $cart['total_cost_with_discount'] = Cart::totalCostWithDiscount();
                $cart['total_discount'] = Cart::calculateTotalDiscount();

                session()->put('cart', $cart);
            } else {
                $itemQuantity = $cart['products'][array_search(true, $checkProductExistsInCart)]['quantity'];
                if ($itemQuantity != $request->get('quantity')) {
                    $cart['products'][array_search(true, $checkProductExistsInCart)]['quantity'] = $request->get('quantity');

                    session()->put('cart', $cart);

                    $cart['total_items'] = Cart::totalItems();
                    $cart['total_cost'] = Cart::totalCost();
                    $cart['total_cost_with_discount'] = Cart::totalCostWithDiscount();
                    $cart['total_discount'] = Cart::calculateTotalDiscount();

                    session()->put('cart', $cart);
                }
            }
        } else {
            session()->put('cart', [
                'products' => [
                    [
                        'product' => $product,
                        'quantity' => $request->get('quantity')
                    ]
                ],
                'total_items' => 1,
                'total_cost' => $product->cost * $request->get('quantity'),
                'total_cost_with_discount' => $product->cost_with_discount * $request->get('quantity'),
                'total_discount' => $product->discount_amount * $request->get('quantity')
            ]);
        }
    }

    public static function delete(Product $product)
    {
        $cart = session('cart');
        $items = collect(self::getProductsInCart());

        $items->each(function ($item, $key) use ($product, $items){
            if ($item['product']->id == $product->id) {
                $items->forget($key);
            }
        });

        $cart['products'] = $items->values()->toArray();

        session()->put('cart', $cart);

        $cart['total_items'] = Cart::totalItems();
        $cart['total_cost'] = Cart::totalCost();
        $cart['total_cost_with_discount'] = Cart::totalCostWithDiscount();
        $cart['total_discount'] = Cart::calculateTotalDiscount();

        session()->put('cart', $cart);
    }

    public static function checkProductExistsInCart($cart, $product)
    {
        $checkProductExistsInCart = [];

        foreach ($cart['products'] as $item) {
            if ($item['product']->id == $product->id) {
                array_push($checkProductExistsInCart, true);
            } else {
                array_push($checkProductExistsInCart, false);
            }
        }

        return $checkProductExistsInCart;
    }

    public static function totalItems()
    {
        return count(session('cart')['products']);
    }

    public static function totalCost()
    {
        $total_cost = 0;

        foreach (session('cart')['products'] as $item) {
            $total_cost += $item['product']->cost * $item['quantity'];
        }

        return $total_cost;
    }

    public static function totalCostWithDiscount()
    {
        $total_cost_with_discount = 0;

        foreach (session('cart')['products'] as $item) {
            $total_cost_with_discount += $item['product']->cost_with_discount * $item['quantity'];
        }

        return $total_cost_with_discount;
    }

    public static function getProductsInCart()
    {
        if (!session()->has('cart')) {
            return null;
        }
        return session()->get('cart')['products'];
    }

    public static function calculateTax()
    {
        return session()->get('cart')['total_cost_with_discount'] * 9 / 100;
    }

    public static function calculatePayable()
    {
        $total_cost = session()->get('cart')['total_cost_with_discount'];
        $tax = self::calculateTax();

        return $total_cost + $tax;
    }

    public static function calculateTotalDiscount()
    {
        $total_discount = 0;

        foreach (session('cart')['products'] as $item) {
            if ($item['product']->has_discount) {
                $total_discount += $item['product']->discount_amount * $item['quantity'];
            }
        }

        return $total_discount;
    }

    public static function removeCart()
    {
        session()->forget('cart');
    }
}
