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

    // Tambahkan baris berikut:
    $reviews = Review::where('user_id', auth()->id())->with('produk')->latest()->get();

    return view('review', [
        'produk' => $productsToReview,
        'reviews' => $reviews // <-- pastikan ini dikirim ke view
    ]);
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

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('review.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]));
        return redirect()->route('review.index')->with('success', 'Review updated!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('review.index')->with('success', 'Review deleted!');
    }
    }
