<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create', [
            'categories' => Category::all(),
            'propertyGroups' => PropertyGroup::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(NewCategoryRequest $request)
    {
        $categoryExists = Category::query()
            ->where('title', $request->get('title'))
            ->where('category_id' , $request->get('category_id'))
            ->exists();

        if ($categoryExists) {
            return redirect()->back()->withErrors(['This category already exists']);
        }

        $category = Category::query()->create([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id')
        ]);

        $category->propertyGroups()->attach($request->get('property_groups'));

        session()->flash('success', 'دسته بندی جدید با موفقیت ایجاد شد');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'categories' => Category::all(),
            'category' => $category,
            'propertyGroups' => PropertyGroup::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categoryExists = Category::query()
            ->where('title', $request->get('title'))
            ->where('id' , '!=', $category->id)
            ->exists();

        if ($categoryExists) {
            return redirect()->back()->withErrors(['title' => 'این دسته بندی وجود دارد']);
        }

        $category->update([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id')
        ]);

        $category->propertyGroups()->sync($request->get('property_groups'));

        session()->flash('success', 'دسته بندی با موفقیت ویرایش شد');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Category $category)
    {
        $reltaedExists = Category::query()->where('category_id', $category->id)->exists();

        if ($reltaedExists) {
            return  redirect()->back()->withErrors(['این یک دسته بندی والد است و قابل حذف نیست']);
        }

        $category->propertyGroups()->detach();

        $category->delete();

        session()->flash('success', 'دسته بندی با موفقیت حذف شد');

        return redirect(route('categories.index'));
    }
}
