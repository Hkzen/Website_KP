@extends('dashboard.main')
@section('container')
    <div class="card-body">
        <div class="card card-warning">
            <div class="card-header" style="margin-top: -4em;">
                <h3 class="card-title">Edit Kategori</h3>
            </div>
            <form method="POST" action="/dashboard/kategori/{{ $kategori->slug}}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                    id="nama" name="nama" placeholder="Nama Kategori" value="{{ old('nama', $kategori->nama) }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control"
                    id="slug" name="slug" placeholder="Slug Kategoti" value="{{ old('slug', $kategori->slug) }}">
                </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        const nama = document.querySelector('#nama');
        const slug = document.querySelector('#slug');
        nama.addEventListener('change', function(){
            fetch('/dashboard/kategori/checkSlug?nama='+nama.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        })
    </script>
@endsection