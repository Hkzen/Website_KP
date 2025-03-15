@extends('dashboard.main')

@section('container')
<section class="p-2">
    <div class="container-fluid">
        <h1 class="m-0">Katalog Produk</h1>
        @if (session()->has('sukses'))
            <div class="alert alert-success" role="alert">
                {{ session('sukses') }}
            </div>
        @endif  
        <!-- Form pencarian -->
        <form id="searchForm" class="mb-3" method="get">
            @csrf
            <label for="keyword">Cari nama produk : </label>
            <input type="text" id="keyword" name="keyword" class="form-control d-inline-block" style="width: 300px;" placeholder="Masukkan nama produk">
            <button type="submit" class="btn btn-warning">Cari</button>
        </form>

        <a href="/dashboard/produks/create" class="btn btn-outline-warning mb-3">Tambah produk</a>

        <!-- Tabel Produk -->
        <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-hover">
                <thead class="thead-dark">
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
                        <td class="text-center">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $produk->stok }}</td>
                        <td class="text-center"><img class="img-fluid" style="max-width: 100px;" src="{{ asset('storage/' . $produk->foto_produk) }}"></td>
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
</section>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                        productList.innerHTML = '<tr><td colspan="7">Produk Tidak Ditemukan.</td></tr>';
                    } else {
                        data.forEach((product, index) => {
                            productList.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${product.nama_produk}</td>
                                    <td>${product.kategori_nama || 'N/A'}</td>
                                    <td class="text-center">Rp ${new Intl.NumberFormat().format(product.harga)}</td>
                                    <td class="text-center">${product.stok}</td>
                                    <td class="text-center"><img class="img-fluid" style="max-width: 100px;" src="/storage/${product.foto_produk}" /></td>
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