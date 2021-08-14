<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPropertyController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.productProperties.index', [
           'product' => $product,
        ]);
    }

    public function create(Product $product)
    {
        return view('admin.productProperties.create', [
            'product' => $product,
            'propertyGroups' => $product->category->propertyGroups
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $properties = collect($request->get('properties'))->filter(function ($item) {
            if (!empty($item['value'])) {
                return $item;
            }
        });

        $product->properties()->sync($properties);

        return redirect(route('products.properties.index', $product));
    }
}
