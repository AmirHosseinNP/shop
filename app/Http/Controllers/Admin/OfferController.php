<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Helpers\MakeDate;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.offers.index', ['offers' => Offer::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewOfferRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewOfferRequest $request)
    {
        $starts_at = MakeDate::makeGregorianDate($request->get('starts_at'));
        $expires_at = MakeDate::makeGregorianDate($request->get('expires_at'));

        if ($starts_at >= $expires_at) {
            return redirect()->back()->withErrors(['starts_at' => 'تاریخ آغاز باید کوچکتر از تاریخ پایان باشد']);
        }

        Offer::query()->create([
            'code' => $request->get('code'),
            'starts_at' => $starts_at,
            'expires_at' => $expires_at
        ]);

        session()->flash('success', 'کد تخفیف جدید با موفقیت ایجاد شد');

        return redirect(route('offers.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', [
            'offer' => $offer,
            'starts_at' => Verta::instance($offer->starts_at),
            'expires_at' => Verta::instance($offer->expires_at)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $starts_at = MakeDate::makeGregorianDate($request->get('starts_at'));
        $expires_at = MakeDate::makeGregorianDate($request->get('expires_at'));
        $offerExists = Offer::query()
            ->where('code', $request->get('code'))
            ->where('id', '!=', $offer->id)
            ->exists();

        if ($starts_at >= $expires_at) {
            return redirect()->back()->withErrors(['starts_at' => 'تاریخ آغاز باید کوچکتر از تاریخ پایان باشد']);
        }

        if ($offerExists) {
            return redirect()->back()->withErrors(['code' => 'این کد تخفیف وجود دارد']);
        }

        $offer->update([
           'code' => $request->get('code'),
           'starts_at' => $starts_at,
           'expires_at' => $expires_at
        ]);

        session()->flash('success', 'کد تخفیف با موفقیت ویرایش شد');

        return redirect(route('offers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        session()->flash('success', 'کد تخفیف با موفقیت حذف شد');

        return redirect(route('offers.index'));
    }
}
