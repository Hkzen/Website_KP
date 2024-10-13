<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\produkFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ProdukFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

     public function filterProducts(Request $request)
     {
        $keyword = $request->input('keyword');
        $produks = DB::table('produks')
                    ->where('nama_produk', 'like', '%' . $keyword . '%')
                    ->get();


        $message = null;
        if ($produks->isEmpty()) {
            $message = 'Produk tidak ditemukan.';
        }

        $log = 'KeLoginPage';
        if ($keyword == $log) {
            return view('login.index');
        } 
                
        return view('produkfilter', ['message' => $message, 'produks' => $produks, 'keyword' => $keyword]);

        
    }
    public function create()
    {
        //
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
    public function show(produkFilter $produkFilter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produkFilter $produkFilter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produkFilter $produkFilter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produkFilter $produkFilter)
    {
        //
    }
}
