<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sliders.index', ['sliders' => Slider::query()->latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SliderRequest $request)
    {
        if ($request->ajax()) {
            $path = $request->file('image')
                ->storeAs('public/images/sliders', $request->file('image')->getClientOriginalName());

            $slider = Slider::query()->create([
                'image' => $path,
                'link' => $request->get('link')
            ]);

            return response()->json([
                'slider' => $slider,
                'success' => 'اسلاید با موفقیت ایجاد شد'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit',  ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $path = $slider->image;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->storeAs('public/images/sliders', $request->file('image')->getClientOriginalName());
        }

        $slider->update([
            'image' => $path,
            'link' => $request->get('link')
        ]);

        session()->flash('success', 'اسلاید با موفقیت ویرایش شد');

        return redirect(route('sliders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        Storage::delete($slider->image);

        $slider->delete();

        return response([
            'success' => 'اسلاید با موفقیت حذف شد'
            ], 200);
    }
}
