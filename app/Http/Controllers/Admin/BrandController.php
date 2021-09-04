<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brands.index', [
            'brands' => Brand::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(NewBrandRequest $request)
    {
        $path = $request->file('image')
            ->storeAs('public/images/brands', $request->file('image')->getClientOriginalName());

        Brand::query()->create([
            'name' => $request->get('name'),
            'image' => $path
        ]);

        session()->flash('success', 'برند جدید با موفقیت ایجاد شد');

        return redirect(route('brands.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', [
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Brand $brand)
    {
        $nameExists = Brand::query()
            ->where('name', $request->get('name'))
            ->where('id', '!=', $brand->id)->exists();

        $path = $brand->image;

        if ($nameExists) {
            return redirect()->back()->withErrors(['name' => 'This name has already been taken']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->storeAs('public/images/brands', $request->file('image')->getClientOriginalName());

            Storage::delete('/' . $brand->image);
        }

        $brand->update([
            'name' => $request->get('name'),
            'image' => $path
        ]);

        session()->flash('success', 'برند با موفقیت ویرایش شد');

        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Brand $brand)
    {
        Storage::delete('/' . $brand->image);

        $brand->delete();

        session()->flash('success', 'برند با موفقیت حذف شد');

        return redirect(route('brands.index'));
    }
}
