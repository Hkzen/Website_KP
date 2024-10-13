@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">           
            <div class="col-sm-12">
                <h1 class="m-0">Katalog Produk</h1>
            </div>  
        </div>
        <div class="card-body">
            @if (session()->has('sukses'))
                <div class="alert alert-success" role="alert">
                    {{ session('sukses') }}
                </div>
            @endif  
            <form action="{{ url('/dashboard/produksFilter') }}" style="margin-bottom: 15px;" method="get">
                @csrf
                <label for="keyword">Cari nama produk : </label>
                <input type="text" name="keyword" placeholder="Masukkan nama produk" style="width: 10cm;">
                <button type="submit" class="btn btn-warning" style="position: relative;">Cari</button>
              </form>
            <a href="/dashboard/produks/create" class="btn btn-outline-warning mb-3">Tambah produk</a>
            <table  id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Stok Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori->nama }}</td>
                        <td style="text-align: center;"><img style="max-width: 5cm; max-height: 5cm;" src="{{ asset('storage/' . $produk->foto_produk) }}"></td>
                        <td style="text-align: center;">{{ $produk->stok }}</td>
                        <td>
                            <a href="/dashboard/produks/{{ $produk->slug }}" class="btn btn-info"><i class="far fa-eye nav-icon"></i></a>
                            <a href="/dashboard/produks/{{ $produk->slug }}/edit" class="btn btn-warning"><i class="far fa-edit nav-icon"></i></a>
                            <form action="/dashboard/produks/{{ $produk->slug }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('yakin akan menghapus data?')"><i class="nav-icon fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
