@extends('main')
@section('container')
<h1>Produk</h1>
    <section class="p-1">
        <div class="container">
          <div class="row">
            <form action="{{ url('/produkFilter') }}" style="margin-bottom: 15px;" method="get">
              @csrf
              <label for="keyword">Cari nama produk : </label>
              <input type="text" name="keyword" placeholder="Masukkan nama produk" style="width: 10cm;">
              <button type="submit" class="btn btn-warning" style="position: relative;">Cari</button>
            </form>                

            @foreach ($produk as $deskripsi)               
            <div class="col-md-4 mb-3" style="display: flex; flex-wrap: wrap;">
                <div class="card" style="border-color:rgb(228, 161, 37); border-width: 5px;">   
                    <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="card-img-top" alt="Foto">   
                    <div class="card-body">
                      <h5 class="card-title"><a href="/produk/{{ $deskripsi->slug }}"
                      style="color: rgb(32, 150, 110)">{{ $deskripsi->nama_produk }}</a>
                      </h5>
                      <p class="card-text">{{ $deskripsi->excerpt }}</p>
                      <div class="text-end">                
                        <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal{{ $deskripsi->id }}" style="position: absolute; bottom: 0; right: 0; width: 120px; height: 32px; font-size:14px;">Detail Produk</button>
                      </div> 
                    </div>               
                </div>
              </div> 
                      <!-- Modal Detail Produk -->
            <div class="modal fade" id="detailModal{{ $deskripsi->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $deskripsi->id }}" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> <!-- Menambah modal-lg untuk ukuran besar -->
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="detailModalLabel{{ $deskripsi->id }}">{{ $deskripsi->nama_produk }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <!-- Gambar Produk di Kiri -->
                              <div class="col-md-4">
                                  <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="img-fluid" alt="{{ $deskripsi->nama_produk }}">
                              </div>

                              <!-- Informasi Produk di Kanan -->
                              <div class="col-md-8">
                                  <h5>{{ $deskripsi->nama_produk }}</h5>
                                  <p>{{ $deskripsi->deskripsi_produk }}</p>
                                 
                                  <p><strong>Stok: </strong>{{ $deskripsi->stok }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-success" onclick="addToCart({{ $deskripsi->id }})">Tambah ke Keranjang</button>
                          <a class="btn btn-primary">Beli Sekarang</a>
                      </div>
                  </div>
              </div>
            </div>


            @endforeach    

          </div>
        </div>
    </section>
@endsection