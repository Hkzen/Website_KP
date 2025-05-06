<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
        $produk = Produk::with(['review'])
        ->orderBy('created_at', 'desc') // Ensure consistent ordering
        ->paginate(6); // Paginate 6 products per page

        return view('produk', compact('produk'));
     }

    /**
     * Show the form for creating a new resource.
     */

    public function home(produk $produk)
    {
        $latestProducts = produk::orderBy('created_at', 'desc')->take(3)->get();
    
        return view('home', [
            'title' => 'Home',
            'produk' => $latestProducts // kirim data produk terbaru
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = produk::with('review.user')->findOrFail($id);
        
        $averageRating = $produk->review()->avg('rating');

        return view('produkDetail', compact('produk', 'averageRating'));
    }


    public function loadMoreReviews(Request $request, $id)
    {
        $produk = produk::findOrFail($id);

        // Fetch the next set of reviews (e.g., 5 per page)
        $reviews = $produk->review()
            ->with('user')
            ->latest()
            ->skip($request->get('offset', 0))
            ->take(5)
            ->get();

        return response()->json($reviews);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk)
    {
        //
    }
}
