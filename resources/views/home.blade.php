@extends('main')
@section('container')
<section>
  <section id="hero" class="hero section light-background">
  <div class="container">
<div class="row gy-4">
<div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
    <h1 style="color: blue;">Selamat datang di <span>Toko Paramonth</span></h1>
    <p>Kami menyediakan barang-barang elektronik lengkap dan terjamin</p>
    <div class="d-flex">
    </div>
</div>
</div>
  </div>
  </section>    

        <div class="container text-center py-5">
          <h2 class="mb-4">Fitur</h2>
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="card p-4 shadow-sm">
                <i class="bi bi-box-seam display-4 text-primary mb-3"></i>
                <h5>Cari Produk</h5>
                <p>Cari produk terbaik hanya dengan mengetik nama dari nama produk dengan cepat dan efisien!</p>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="card p-4 shadow-sm">
                <i class="bi bi-headphones display-4 text-primary mb-3"></i>
                <h5>Tentang Kami</h5>
                <p>Cari tahu lebih lengkap tentang Toko Paramonth dalam satu tekan!</p>
              </div>
            </div>
          </div>
        </div>

        <div class="container py-5">
          <h2>Produk Yang Baru Ditambahkan!</h2>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($produk as $deskripsi)                           
               <div class="col-md-4 mb-3" style="display: flex; flex-wrap: wrap;">
                    <div class="card h-100" style="border-color:rgb(86, 91, 227); border-width: 5px; box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
                        <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="card-img-top" alt="Foto" style="outline-style: solid; outline-width: 2px; outline-color:rgb(86, 91, 227);">
                        <div class="card-body">
                            <h5 class="card-title"><a type="button" data-toggle="modal" data-target="#detailModal{{ $deskripsi->id }}"
                                style="color: rgb(86, 91, 227);">{{ $deskripsi->nama_produk }}</a>
                            </h5>
                            <p style="word-wrap: break-word;">{{ $deskripsi->excerpt }}</p>
                            <div class="text-end">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal{{ $deskripsi->id }}" style="position: absolute; bottom: 0; right: 0; width: 120px; height: 32px; font-size:14px;">Detail Produk</button>
                            </div>
                        </div>
                    </div>
              </div>

             <div class="modal fade" id="detailModal{{ $deskripsi->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $deskripsi->id }}" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                   <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="detailModalLabel{{ $deskripsi->id }}">{{ $deskripsi->nama_produk }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body" style="max-height:400px; overflow-y: auto; ">
                          <div class="row">
                              <div class="col-md-4" >
                                  <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="img-fluid" alt="{{ $deskripsi->nama_produk }}" style="position: sticky; top: 0;">
                              </div>
                              <div class="col-md-8">
                                  <h5 >Deskripsi Produk</h5>
                                  <p style="word-wrap: break-word; overflow-wrap: break-word;">{!! $deskripsi->deskripsi_produk !!}</p>
                                  <p><strong>Harga: </strong>Rp {{ number_format($deskripsi->harga, 0, ',', '.') }}</p>
                                  @if ($deskripsi->stok == 0)
                                  <p><strong>Stok: </strong> Stok Habis</p>
                                  @else
                                  <p><strong>Stok: </strong>{{ $deskripsi->stok }}</p>
                                  @endif
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <form action="{{ route('add.to.cart') }}" method="POST">
                          @csrf
                          <input type="hidden" name="produk_id" value="{{ $deskripsi->id }}">
                          <input type="number" name="quantity" value="1" min="1" max="{{ $deskripsi->stok }}">
                          <button class="btn btn-success" type="submit">Tambah ke Keranjang</button>
                        </form>
                        
                        <!-- Beli Sekarang form -->
                        <form action="{{ route('checkout') }}" method="GET">
                          <input type="hidden" name="produk_id" value="{{ $deskripsi->id }}">
                          <input type="number" name="quantity" value="1" min="1" max="{{ $deskripsi->stok }}">
                          <button class="btn btn-primary" type="submit">Beli Sekarang</button>
                        </form>
                      </div>
                  </div>
              </div>
            </div>
           @endforeach
          </div>
      </div>
      
      </div>
    </section>
@endsection
