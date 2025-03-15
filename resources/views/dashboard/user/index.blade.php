@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid">           
            <div class="col-sm-12">
                <h1 class="m-0">User</h1>
            </div>  
        </div>
        <div class="card-body" style="margin-bottom: 50px;">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif  
            <a href="/dashboard/user/create" class="btn btn-outline-warning mb-3">Tambah User</a>

            <!-- Tabel Produk -->
            <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productList">
                    @foreach ($user as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->username}}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="/dashboard/user/{{ $user->id }}/edit" class="btn btn-warning"><i class="far fa-edit nav-icon"></i></a>
                            <form action="/dashboard/user/{{ $user->id }}" method="POST" class="d-inline">
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
    </div>
@endsection
