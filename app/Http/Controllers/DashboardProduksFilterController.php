<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardProduksFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.produks.create', [
            'kategori' => kategori::all()
        ]);
    }

    public function filterProducts(Request $request)
    {
        $keyword = $request->input('keyword');
        if ($keyword) {
            $produk = Produk::where('nama_produk', 'like', '%' . $keyword . '%')->get();
         } else {
            $produk = Produk::all();
         }

        if ($produk->isEmpty()) {
            return view('dashboard.produks.produksFilter', ['message' => 'No products found.']);
        } else {
            return view('dashboard.produks.produksFilter', ['produk' => $produk ], ['keyword' => $keyword]);
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
