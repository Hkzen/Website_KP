@extends('dashboard.main')
@section('container')
    <div class="card-body">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
            </div>
            <form method="POST" action="/dashboard/kategori" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                    id="nama" name="nama" placeholder="Nama Kategori">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control"
                    id="slug" name="slug" placeholder="Slug Kategori">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
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