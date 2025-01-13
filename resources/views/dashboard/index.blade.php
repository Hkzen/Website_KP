@extends('dashboard.main')
@section('container')
    <div class="content-header">
        <div class="container-fluid" style="margin-top: -4em">
            <div class="col-sm-12 mb-4 text-center">
              <h1 class="m-0">Selamat Datang - {{ auth()->user()->name }}</h1>
            </div>
            <div class="row mb-2">
              <div class="col-sm-8">
                <div class="alert alert-info" role="alert">
                  * Halaman ini digunakan untuk mengelola <a href="/dashboard/produks" class="alert-link">Katalog Produk</a>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="alert alert-success" role="alert">
                  * Mengelola <a href="/dashboard/kategori" class="alert-link">Kategori Produk</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="alert alert-primary" role="alert">
                  * Halaman ini digunakan untuk mengelola <a href="/dashboard/user" class="alert-link">User</a>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection