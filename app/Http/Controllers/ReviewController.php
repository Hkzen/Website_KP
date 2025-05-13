<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ReviewController extends Controller
{

    public function index()
    {
        $purchasedProducts = auth()->user()->purchasedProducts();

        $productsToReview = $purchasedProducts->filter(function ($product) {
            return !Review::where('produk_id', $product['id'])
                ->where('user_id', auth()->id())
                ->exists();
        });

    return view('review', ['products' => $productsToReview]);
    }

    public function store(Request $request, $produkId)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'produk_id' => $produkId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect('review')->with('success', 'Your comment has been added!');
    }

}
