<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // Pastikan model Cart ada
use App\Models\Produk; // Jika Anda menggunakan model produk
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menambahkan produk ke keranjang
    public function addToCart(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login atau registrasi terlebih dahulu untuk menambahkan produk ke keranjang!!');
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($request->produk_id);

        if ($request->quantity > $produk->stok) {
            return redirect()->back()->with('error', 'Jumlah produk yang diminta melebihi stok yang tersedia.');
        }

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
            ],
            [
                'quantity' => $request->quantity,
                
            ]
        );

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Melihat isi keranjang
    public function viewCart()
    {
        $cartItems = Cart::with('produk') // Pastikan Anda memiliki relasi di model Cart
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->produk->harga;
        });

        return view('cart', compact('cartItems'), compact('total'));
    }

    // Menghapus produk dari keranjang (opsional)
    public function removeFromCart($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        return redirect('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
