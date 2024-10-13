<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.kategori.index', [
            'kategori' => kategori::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.kategori.create', [
            'kategori' => kategori::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'slug' => 'required'
        ]);

        kategori::create($validatedData);

        return redirect('/dashboard/kategori')->with('sukses', 'Kategori Baru Berhasil Ditambahkan!');
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
    public function edit(kategori $kategori)
    {
        return view('dashboard.kategori.edit', [
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kategori $kategori)
    {
        $rules = [
            'nama' => 'required|max:255'
        ];

        if($request->slug != $kategori->slug){
            $rules['slug']='required|unique:kategoris';
        }
        $validatedData = $request->validate($rules);

        kategori::where('id', $kategori->id)->update($validatedData);

        return redirect('/dashboard/kategori')->with('sukses', 'Data Kategori Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kategori $kategori)
    {
        kategori::destroy($kategori->id);

        return redirect('dashboard/kategori')->with('sukses','Data berhasil dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = Str::slug($request->nama);
        return response()->json(['slug' => $slug]);
    }

}

