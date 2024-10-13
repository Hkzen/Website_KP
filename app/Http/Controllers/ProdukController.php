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
    public function index()
    {
        return view('produk', [
            "title" => "Produk",
            "produk" => produk::all()
        ]);
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

                    $log = 'KeLoginPage';
        if ($keyword->$log) {
            return view('login');
        }
        
        if ($produks->isEmpty()) {
            return view('produkFilter', ['message' => 'No products found.']);
        } else {
            return view('produkFilter', ['produks' => $produks], ['keyword' => $keyword]);
        }
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
    public function show(produk $produk)
    {
        
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
