<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\produks;
use App\Models\kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class DashboardProduksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.produks.index', [
            'produk' => produk::all()
        ]);
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|max:255',
            'slug' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'kategori_id' => 'required',
            'deskripsi_produk' => 'required',
            'foto_produk' => 'image|file|max:1024'
        ]);

        $validatedData['excerpt'] = Str::limit(strip_tags($request->deskripsi_produk), 100);

        $validatedData['foto_produk'] = $request->file('foto_produk')->store('storage');

        produk::create($validatedData);

        return redirect('/dashboard/produks')->with('sukses', 'produk Baru Berhasil Ditambahkan!');
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
            return view('dashboard.produks.produksFilter', ['produk' => $produk], ['keyword' => $keyword]);
        }
    }
    
    public function show(produk $produk)
    {
        return view('dashboard.produks.show', [
            'produk' => $produk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit($slug)
    {
        // Retrieve the product by slug
        $produk = Produk::where('slug', $slug)->first();
        
        // Check if the product exists
        if (!$produk) {
            return redirect()->route('produks.index')->with('error', 'Product not found');
        }

        return view('dashboard.produks.edit', compact('produk'), [
            'kategori' => kategori::all()
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
{
    // Define validation rules
    $rules = [
        'nama_produk' => 'required|max:255',
        'stok' => 'required|numeric',
        'harga' => 'required|numeric',
        'kategori_id' => 'required',
        'deskripsi_produk' => 'required',
        'foto_produk' => 'image|file|max:1024'
    ];

    // If slug is changed, ensure the new slug is unique
    if ($request->slug != $produk->slug) {
        $rules['slug'] = 'required|unique:produks';
    }

    // Validate the request
    $validatedData = $request->validate($rules);

    // Generate excerpt for the product description
    $validatedData['excerpt'] = Str::limit(strip_tags($request->deskripsi_produk), 120);

    // If a new file is uploaded, handle the file upload
    if ($request->file('foto_produk')) {
        // Delete old photo if it exists
        if ($request->foto_lama) {
            Storage::delete($request->foto_lama);
        }
        // Store the new photo
        $validatedData['foto_produk'] = $request->file('foto_produk')->store('produk-foto');
    }

    // Update the product in the database
    Produk::where('id', $produk->id)->update($validatedData);

    // Redirect with a success message
    return redirect('/dashboard/produks')->with('sukses', 'Data Produk Berhasil di Update');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk)
    {
        if($produk->foto_produk){
            Storage::delete($produk->foto_produk);
        }

        produk::destroy($produk->id);

        return redirect('/dashboard/produks')->with('sukses', 'Produk berhasil dihapus!');
    }

    public function checkSlug(Request $request)
{
    $slug = Str::slug($request->nama_produk);
    return response()->json(['slug' => $slug]);
}

}
