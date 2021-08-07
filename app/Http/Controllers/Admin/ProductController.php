<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'brands' => Brand::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(NewProductRequest $request)
    {
        $path = $request->file('image')
            ->storeAs('public/images/products', $request->file('image')->getClientOriginalName());

        Product::query()->create([
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'cost' => $request->get('cost'),
            'image' => $path,
            'description' => $request->get('description')
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $path = $product->image;

        $slugExists = Product::query()
            ->where('slug', $request->get('slug'))
            ->where('id', '!=', $product->id)
            ->exists();

        if($slugExists) {
            return redirect()->back()->withErrors(['This slug has already been taken']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->storeAs('public/images/products', $request->file('image')->getClientOriginalName());

            Storage::delete('/' . $product->image);
        }

        $product->update([
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'cost' => $request->get('cost'),
            'image' => $path,
            'description' => $request->get('description')
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product)
    {
        Storage::delete('/' . $product->image);

        $product->delete();

        return redirect(route('products.index'));
    }
}
