@extends('main')

@section('container')
    <h1>Checkout</h1>
    @if ($isSingleProduct)
    <h3>Produk: {{ $produk->nama_produk }}</h3>
    <p>Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
    <p>Jumlah: {{ $quantity }}</p>
    <form action="/checkout/process" method="POST">
        @csrf
        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">
        <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
    </form>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $cart)
                <tr>
                    <td>{{ $cart->produk->nama_produk }}</td>
                    <td>{{ number_format($cart->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $cart->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="/checkout/process" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
    </form>
@endif
<h3>Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h3>

    
@endsection
