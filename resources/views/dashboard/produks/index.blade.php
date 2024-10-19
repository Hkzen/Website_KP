@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">           
            <div class="col-sm-12">
                <h1 class="m-0">Katalog Produk</h1>
            </div>  
        </div>
        <div class="card-body" style="margin-bottom: 50px;">
            @if (session()->has('sukses'))
                <div class="alert alert-success" role="alert">
                    {{ session('sukses') }}
                </div>
            @endif  
            <!-- Form pencarian -->
            <form id="searchForm" style="margin-bottom: 15px;" method="get">
                @csrf
                <label for="keyword">Cari nama produk : </label>
                <input type="text" id="keyword" name="keyword" placeholder="Masukkan nama produk" style="width: 10cm;">
                <button type="submit" class="btn btn-warning" style="position: relative;">Cari</button>
            </form>

            <a href="/dashboard/produks/create" class="btn btn-outline-warning mb-3">Tambah produk</a>

            <!-- Tabel Produk -->
            <table id="productTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok Barang</th>
                        <th>Foto Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productList">
                    @foreach ($produk as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori->nama }}</td>
                        <td style="text-align: center;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $produk->stok }}</td>
                        <td style="text-align: center;"><img style="max-width: 5cm; max-height: 5cm;" src="{{ asset('storage/' . $produk->foto_produk) }}"></td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Pastikan script ini berada di bawah elemen HTML yang didefinisikan
    document.addEventListener('DOMContentLoaded', () => {
        const searchForm = document.getElementById('searchForm');

        // Menangani submit form pencarian
        searchForm.onsubmit = function(e) {
            e.preventDefault(); // Mencegah submit default

            const keyword = document.getElementById('keyword').value;

            fetch(`http://localhost:3000/dashboard/produks/search?keyword=${encodeURIComponent(keyword)}`)
                .then(response => {
                    if (!response.ok) { // Cek apakah respons dari server tidak OK
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const productList = document.getElementById('productList');
                    productList.innerHTML = ''; // Mengosongkan daftar produk sebelumnya

                    if (data.length === 0) {
                        productList.innerHTML = '<tr><td colspan="7">No products found.</td></tr>';
                    } else {
                        data.forEach((product, index) => {
                            productList.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${product.nama_produk}</td>
                                    <td>${product.kategori_nama || 'N/A'}</td>
                                    <td style="text-align: center;">Rp ${new Intl.NumberFormat().format(product.harga)}</td>
                                    <td style="text-align: center;">${product.stok}</td>
                                    <td style="text-align: center;"><img style="max-width: 5cm; max-height: 5cm;" src="/storage/${product.foto_produk}" /></td>
                                    <td>
                                        <a href="/dashboard/produks/${product.slug}" class="btn btn-info"><i class="far fa-eye nav-icon"></i></a>
                                        <a href="/dashboard/produks/${product.slug}/edit" class="btn btn-warning"><i class="far fa-edit nav-icon"></i></a>
                                        <form action="/dashboard/produks/${product.slug}" method="POST" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger" onclick="return confirm('yakin akan menghapus data?')"><i class="nav-icon fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    document.getElementById('productList').innerHTML = '<tr><td colspan="7">Error fetching products.</td></tr>';
                });
        };
    });
</script>
