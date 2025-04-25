@extends('main')
@section('container')
    <h1 class="text-center">{{ $produk->nama_produk }}</h1>
    <section class="p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                </div>
                <div class="col-md-8">
                    <h5>Deskripsi Produk</h5>
                    <p>{!! $produk->deskripsi_produk !!}</p>
                    <p><strong>Harga: </strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    @if ($produk->stok == 0)
                        <p><strong>Stok: </strong> Stok Habis</p>
                    @else
                        <p><strong>Stok: </strong>{{ $produk->stok }}</p>
                    @endif
                    <div class="d-flex">
                        <!-- Add to Cart Form -->
                        <form action="{{ route('add.to.cart') }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $produk->stok }}">
                            <button class="btn btn-success" type="submit">Tambah ke Keranjang</button>
                        </form>
                        <!-- Buy Now Form -->
                        <form action="{{ route('checkout') }}" method="GET">
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $produk->stok }}">
                            <button class="btn btn-primary" type="submit">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h5>Comments</h5>
                @foreach ($produk->review as $comment)
                    <div class="border p-3 mb-3">
                        <strong>{{ $comment->user->name }}</strong> 
                        <span>({{ $comment->created_at->format('d M Y') }})</span>
                        <div>Rating: {{ $comment->rating }} / 5</div>
                        <p>{{ $comment->comment }}</p>
                    </div>
                 @endforeach
        </div>
    </section>
@endsection
