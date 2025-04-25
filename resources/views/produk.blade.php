@extends('main')
@section('container')
<h1 class="text-center">Produk</h1>
    <section class="p-3">
        <div class="container">
          <div class="row">
            <form id="searchForm" style="margin-bottom: 15px; display: flex; align-items: center;"> 
                <label for="keyword" style="margin-right: 10px;">Cari nama produk: </label> 
                <input type="text" id="keyword" name="keyword" placeholder="Masukkan nama produk" style="width: 67vw; padding: 5px; margin-right: 10px;"> 
                <button type="submit" class="btn btn-primary" style="background-color: rgb(86, 91, 227); border: none; padding: 5px 10px; cursor: pointer; 
                color: #f8f8f8; font-size: 15px; position: relative;">Cari</button>
            </form>
              @if(session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}'/' 
              </div>
            @endif
            @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
            @endif
            <div id="product-container" class="row">
            @foreach ($produk as $deskripsi)                           
               <div class="col-md-4 mb-3" style="display: flex; flex-wrap: wrap;">
                    <div class="card h-100" style="border-color:rgb(86, 91, 227); border-width: 5px; box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
                        <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="card-img-top" alt="Foto" style="outline-style: solid; 
                        outline-width: 2px; outline-color:rgb(86, 91, 227);">
                        <div class="card-body">
                            <h5 class="card-title"><a type="button" data-toggle="modal" data-target="#detailModal{{ $deskripsi->id }}"
                                style="color: rgb(86, 91, 227);">{{ $deskripsi->nama_produk }}</a>
                            </h5>
                            <p style="word-wrap: break-word;">{{ $deskripsi->excerpt }}</p>
                            <div class="text-end">
                                <a href="{{ route('produk.show', $deskripsi->id) }}" class="btn btn-primary" style="position: absolute; bottom: 0; right: 0; width: 120px; height: 32px; font-size:14px;">Detail Produk</a>
                            </div>
                        </div>
                    </div>
              </div>

             <div class="modal fade" id="detailModal{{ $deskripsi->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $deskripsi->id }}" 
                aria-hidden="true">
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
                                  <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="img-fluid" alt="{{ $deskripsi->nama_produk }}" 
                                  style="position: sticky; top: 0;">
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

@section('scripts')
<script>
  $(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
      e.preventDefault();
      
      const keyword = $('#keyword').val();
      
      $.ajax({
          url: 'http://localhost:3000/search',
          method: 'GET',
          data: { keyword: keyword },
          success: function(response) {
              $('#product-container').empty();
              
              if (response.message) {
                  $('#product-container').append('<p style="color: red;">Produk Tidak Ditemukan.</p>');
              } else {
                  response.forEach(function(product) {
                      let productHtml = `
                          <div class="col-md-4 mb-3" style="display: flex; flex-wrap: wrap;">
                            <div class="card h-100" style="border-color:rgb(86, 91, 227); border-width: 5px; box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
                                <img src="{{ asset('storage') }}/${product.foto_produk}" class="card-img-top" alt="Foto">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a type="button" data-toggle="modal" data-target="#detailModal${product.id}" style="color: rgb(86, 91, 227);">
                                                ${product.nama_produk}
                                            </a>
                                        </h5>
                                        <p class="card-text">${product.excerpt}</p>
                                        <div class="text-end">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal${product.id}" style="position: absolute; 
                                        bottom: 0; right: 0; width: 120px; height: 32px; font-size:14px;">Detail Produk</button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                          <div class="modal fade" id="detailModal${product.id}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel${product.id}" 
                          aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document"> <!-- Menambah modal-lg untuk ukuran besar -->
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="detailModalLabel${product.id}">${product.nama_produk}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row">
                                              <div class="col-md-4">
                                                  <img src="{{ asset('storage') }}/${product.foto_produk}" class="img-fluid" alt="${product.nama_produk}">
                                              </div>
                                              <div class="col-md-8">
                                                  <h5>Deskripsi Produk</h5>
                                                  <p>${product.deskripsi_produk.replace(/\n/g, '<br>')}</p>
                                                  <p><strong>Harga: </strong>Rp ${new Intl.NumberFormat().format(product.harga)}</p>
                                                  ${product.stok == 0 ? '<p><strong>Stok: </strong>Stok Habis</p>' : '<p><strong>Stok: </strong>' + product.stok + '</p>'}
                                              </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <form action="{{ route('add.to.cart') }}" method="POST">
                                              @csrf
                                              <input type="hidden" name="produk_id" value="${product.id}">
                                              <input type="number" name="quantity" value="1" min="1" max="${product.stok}">
                                              <button class="btn btn-success" type="submit">Tambah ke Keranjang</button>
                                          </form>
                                          <form action="{{ route('checkout') }}" method="GET">
                                              <input type="hidden" name="produk_id" value="${product.id}">
                                              <input type="number" name="quantity" value="1" min="1" max="${product.stok}">
                                              <button class="btn btn-primary" type="submit">Beli Sekarang</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      `;
                      $('#product-container').append(productHtml);
                  });
              }
          },
          error: function(err) {
              console.error('Error fetching products:', err);
          }
      });
  });
  });
</script>
@endsection
