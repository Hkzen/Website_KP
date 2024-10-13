@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="card-body" style="margin-top: -4em">
            <article>
                <h4 class="mb-3">{{ $produk->nama_produk }}</h4><hr style="background-color:white">
                <img src="{{ asset('storage/' . $produk->foto_produk) }}" style="display: block;
                margin-left: auto;
                margin-right: auto;">
                <hr style="background-color:white">
                <p align="justify">{!! $produk->deskripsi_produk !!}</p>
                <p>Stok Produk : {{ $produk->stok }}</p>
                <a href="/dashboard/produks" class="btn btn-success">Kembali Ke Katalog Produk</a>
                <a href="/dashboard/produks/{{ $produk->slug }}/edit" class="btn btn-warning">Edit</a>
                <form action="/dashboard/produks/{{ $produk->slug }}" method="POST" class="d-inline" style="float: right; clear: both;">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('yakin akan menghapus data?')">Hapus</button>
                </form>
            </article>
        </div>
    </div>
@endsection