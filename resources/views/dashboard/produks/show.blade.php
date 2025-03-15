@extends('dashboard.main')

@section('container')
<section class="p-2">
    <div class="container-fluid">
        <div class="content-header">
            <div class="card-body">
                <article>
                    <h4 class="mb-3 text-center">{{ $produk->nama_produk }}</h4>
                    <hr>
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                    </div>
                    <hr>
                    <p class="text-justify">{!! $produk->deskripsi_produk !!}</p>
                    <p>Kategori Produk: <strong>{{ $produk->kategori->nama }}</strong></p>
                    <p>Stok Produk: <strong>{{ $produk->stok }}</strong></p>
                    <p>Harga Produk: <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="/dashboard/produks" class="btn btn-success">Kembali Ke Katalog Produk</a>
                            <a href="/dashboard/produks/{{ $produk->slug }}/edit" class="btn btn-warning">Edit</a>
                        </div>
                        <form action="/dashboard/produks/{{ $produk->slug }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('yakin akan menghapus data?')">Hapus</button>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection