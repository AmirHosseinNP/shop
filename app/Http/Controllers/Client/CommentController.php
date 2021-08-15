<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Product $product, CommentRequest $request)
    {
        $product->comments()->create([
           'user_id' => auth()->user()->id,
           'content' => $request->get('content')
        ]);

        return redirect()->back();
    }
}
