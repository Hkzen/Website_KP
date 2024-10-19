<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        $totalPrice = $carts->sum(function ($cart) {
            return $cart->produk->harga * $cart->quantity;
        });

        return view('checkout.index', compact('carts', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number, 
            ],
            'item_details' => $carts->map(function ($cart) {
                return [
                    'id' => $cart->produk->id,
                    'price' => $cart->produk->price,
                    'quantity' => $cart->quantity,
                    'name' => $cart->produk->name
                ];
            })->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('checkout.payment', compact('snapToken', 'totalPrice'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        // Verifikasi apakah signature_key valid
        if ($hashed !== $request->signature_key) {
            return response(['message' => 'Invalid signature'], 403);
        }

        // Jika transaksi sukses
        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            // Ambil item di keranjang pengguna
            $carts = Cart::where('user_id', Auth::id())->get();

            // Kurangi stok produk berdasarkan jumlah yang dibeli
            foreach ($carts as $cart) {
                $produk = Produk::find($cart->product->id);
                if ($produk->stock >= $cart->quantity) {
                    $produk->stock -= $cart->quantity;
                    $produk->save();
                } else {
                    return response(['message' => 'Stock not sufficient'], 400);
                }
            }

            // Simpan transaksi ke database
            Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,
                'gross_amount' => $request->gross_amount,
                'status' => $request->transaction_status,
                'payment_type' => $request->payment_type,
            ]);

            // Kosongkan keranjang setelah pembayaran sukses
            Cart::where('user_id', Auth::id())->delete();

            return redirect('/')->with('success', 'Pembayaran berhasil, produk akan segera dikirim.');
        }

        return redirect('/checkout')->with('error', 'Transaksi gagal atau dibatalkan.');
    }
}
