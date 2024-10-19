@extends('main')

@section('container')
<h1>Keranjang Belanja</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
@else
<table class="table">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->produk->nama_produk }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->quantity * $item->produk->harga, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('remove.from.cart', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-between">
    <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
    <a href="{{ route('checkout') }}" class="btn btn-primary">Bayar</a>
</div>
@endif
@endsection
