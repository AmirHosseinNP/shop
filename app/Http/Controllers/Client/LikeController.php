<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('client.profile.wishList', [
            'likedProducts' => auth()->user()->likedProducts
        ]);
    }

    public function store(Product $product, Request $request)
    {
        if (!auth()->user()->hasLiked($product)) {
            auth()->user()->like($product);

            return response(['msg' => 'The product has been liked.', 'likes_count' => auth()->user()->likedProducts()->count()], 200);
        } else {
            auth()->user()->dislike($product);

            return response(['msg' => 'The product has been disliked.', 'likes_count' => auth()->user()->likedProducts()->count()], 200);
        }
    }

    public function destroy(Product $product, Request $request)
    {
        if ($request->ajax()) {
            auth()->user()->dislike($product);

            return response(
                [
                    'msg' => 'The product has been disliked.',
                    'likes_count' => auth()->user()->likedProducts()->count()
                ],
                200
            );
        }
    }
}
