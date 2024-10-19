@extends('dashboard.main')
@section('container')
<div class="card-body">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Update Produk</h3>
        </div>
        <form method="POST" action="{{ route('produks.update', $produk->slug) }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                id="nama_produk" name="nama_produk" placeholder="Nama produk" value="{{ old('nama_produk', $produk->nama_produk) }}">
                @error('nama_produk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control"
                id="slug" name="slug" placeholder="Slug produk" value="{{ old('slug', $produk->slug) }}">
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="text" class="form-control"
                id="stok" name="stok" placeholder="stok produk" value="{{ old('stok', $produk->stok) }}">
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga Produk (dalam angka)" value="{{ old('harga', $produk->harga) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="category">Kategori</label>
                <select class="custom-select rounded-0" id="kategori_id" name="kategori_id">
                    @foreach ($kategori as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="foto_produk">Foto</label>
                <input type="file" class="form-control @error('foto_produk') is-invalid @enderror"
                id="foto_produk" name="foto_produk" value="{{ $produk->foto_produk }}">
                @error('foto_produk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="deskripsi_produk">Deskripsi Produk</label>
                @error('deskripsi_produk')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <textarea id="summernote" name="deskripsi_produk" >{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-outline-warning">Submit</button>
        </div>
        </form>
    </div>
</div>

<script>
    const nama_produk = document.querySelector('#nama_produk');
    const slug = document.querySelector('#slug');
    nama_produk.addEventListener('change', function(){
        fetch('/dashboard/produks/checkSlug?nama_produk='+nama_produk.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    })
</script>
@endsection