@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h1 class="m-0">Halaman Kategori</h1>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('sukses'))
                <div class="alert alert-success" role="alert">
                    {{ session('sukses') }}
                </div>
            @endif  
            <a href="/dashboard/kategori/create" class="btn btn-outline-primary mb-3">Tambah Kategori</a>
            <table  id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="/dashboard/kategori/{{ $kategori->slug }}/edit" class="btn btn-warning">Edit  <i class="far fa-edit nav-icon"></i></a>
                            <form action="/dashboard/kategori/{{ $kategori->slug }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('yakin akan menghapus data?')">Hapus  <i class="nav-icon fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection