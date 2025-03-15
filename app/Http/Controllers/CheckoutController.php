<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
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
    public function index(Request $request) {
        
        $isSingleProduct = $request->has('produk_id');
        if ($isSingleProduct) {
            $produk = Produk::findOrFail($request->produk_id);
            $quantity = $request->input('quantity', 1); // Default quantity is 1
            $totalPrice = $produk->harga * $quantity;
            return view('checkout.index', [
                'isSingleProduct' => true,
                'produk' => $produk,
                'quantity' => $quantity,
                'totalPrice' => $totalPrice
            ]);
        } else {
            $carts = Cart::where('user_id', Auth::id())->get();
            $totalPrice = $carts->sum(function ($cart) {
                return $cart->produk->harga * $cart->quantity;
            });
            return view('checkout.index', [
                'isSingleProduct' => false,
                'carts' => $carts,
                'totalPrice' => $totalPrice
            ]);
        }
    }
    
    public function process(Request $request) {
        if ($request->has('produk_id')) {
            // Handle single product checkout
            $produk = Produk::find($request->produk_id);
            $quantity = $request->input('quantity', 1); // Default quantity is 1
            $totalPrice = $produk->harga * $quantity;
            
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            
            $params = [
                'transaction_details' => [
                    'order_id' => uniqid() . '-' . $produk->id,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $produk->id,
                        'price' => $produk->harga,
                        'quantity' => $quantity,
                        'name' => $produk->nama_produk
                    ]
                ],
            ];
            
            Log::info('Midtrans Params (Single Product): ', $params);
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token: ' . $snapToken);
            
            return view('checkout.payment', compact('snapToken', 'totalPrice'));
        } else {
            // Handle cart checkout
            $carts = Cart::where('user_id', Auth::id())->get();
            if ($carts->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang kosong.');
            }
            $totalPrice = $carts->sum(function ($cart) {
                return $cart->produk->harga * $cart->quantity;
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
                ],
                'item_details' => $carts->map(function ($cart) {
                    return [
                        'id' => $cart->produk->id,
                        'price' => $cart->produk->harga,
                        'quantity' => $cart->quantity,
                        'name' => $cart->produk->nama_produk
                    ];
                })->toArray(),
            ];
            
            Log::info('Midtrans Params (Cart): ', $params);
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token: ' . $snapToken);
            
            return view('checkout.payment', compact('snapToken', 'totalPrice'));
        }
    }
    

    public function callback(Request $request) {
        // Log seluruh data request untuk investigasi
        Log::info('Midtrans Callback Request:', $request->all());
        
        // Asumsikan data sudah berbentuk array
        $data = json_decode($request->input('result'), true); 
        Log::info('Decoded Result:', $data);
        if (isset($data['item_details'])) {
            Log::info('Item Details in Callback: ', $data['item_details']);
        }
        // Pastikan signature key dikirim oleh Midtrans
        if (!$data) {
            Log::error('Callback data missing or failed to decode.');
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $serverKey = config('services.midtrans.serverKey');
        $order_id = $data['order_id'];
        $gross_amount = $data['gross_amount'];

        // Buat signature key yang sesuai
        $calculatedSignature = hash("sha512", $order_id . $data['status_code'] . $gross_amount . $serverKey);

        // Jika transaksi berhasil (capture atau settlement)
        if ($data['transaction_status'] == 'capture' || $data['transaction_status'] == 'settlement') {
            $user = Auth::user();

            // Mendapatkan informasi produk dari order_id jika diperlukan
            // Misalnya: order_id dapat mencakup produk_id jika Anda sudah menambahkannya sebelumnya
            $produk_id = explode('-', $order_id)[1] ?? null; // Jika Anda menggunakan metode ini
            $produk = Produk::find($produk_id);

            if ($produk) {
                $quantity = $request->input('quantity', 1); // Jika Anda ingin menggunakan nilai default atau mendefinisikan kuantitas dengan cara lain

                // Cek stok produk dan kurangi stoknya
                if ($produk->stok >= $quantity) {
                    $produk->stok -= $quantity;
                    $produk->save();
                    
                    // Simpan data transaksi
                    Transaction::create([
                        'user_id' => $user->id,
                        'order_id' => $order_id,
                        'gross_amount' => $gross_amount,
                        'status' => $data['transaction_status'],
                        'payment_type' => $data['payment_type'],
                        'item_details' => json_encode([
                                        [
                                            'id' => $produk->id,
                                            'name' => $produk->nama_produk,
                                            'quantity' => $quantity,
                                            'price' => $produk->harga,
                                        ]
                                    ]),
                    ]);

                    return redirect('/produk')->with('success', 'Pembayaran berhasil, produk akan segera dikirim.');
                } else {
                    Log::error('Stok tidak cukup untuk produk.', [
                        'produk_id' => $produk_id,
                        'stok' => $produk->stok,
                        'quantity' => $quantity,
                    ]);
                }
            }

            // Proses checkout untuk keranjang belanja
            $carts = Cart::where('user_id', $user->id)->get();
            if ($carts->isNotEmpty()) {
                foreach ($carts as $cart) {
                    $produk = Produk::find($cart->produk->id);
                    if ($produk && $produk->stok >= $cart->quantity) {
                        $produk->stok -= $cart->quantity;
                        $produk->save();
                    } else {
                        Log::error('Stok tidak cukup untuk produk di keranjang.', [
                            'produk_id' => $cart->produk->id,
                            'stok' => $produk ? $produk->stok : 'null',
                            'quantity' => $cart->quantity,
                        ]);
                    }
                }
            
                // Simpan transaksi dan kosongkan keranjang
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order_id,
                    'gross_amount' => $gross_amount,
                    'status' => $data['transaction_status'],
                    'payment_type' => $data['payment_type'],
                    'item_details' => json_encode($carts->map(function ($cart) {
                                return [
                                    'id' => $cart->produk->id,
                                    'name' => $cart->produk->nama_produk,
                                    'quantity' => $cart->quantity,
                                    'price' => $cart->produk->harga,
                                ];
                            })->toArray()),
                ]);

                Cart::where('user_id', $user->id)->delete(); // Kosongkan keranjang
                return redirect('/produk')->with('success', 'Pembayaran berhasil, produk akan segera dikirim.');
            }
        }

        // Jika transaksi gagal atau dibatalkan
        Log::error('Transaksi gagal atau dibatalkan.', ['data' => $data]);
        return redirect('/checkout')->with('error', 'Transaksi gagal atau dibatalkan.');
    }

    public function transactionHistory() {
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('created_at')->paginate(10);  

        if ($transactions->isEmpty()) {
            Log::info('Tidak ada transaksi untuk pengguna dengan ID: ' . Auth::id());
        } else {
            Log::info('Transaksi ditemukan: ', $transactions->toArray());
        }
        return view('history', compact('transactions'));
    }
    
}
