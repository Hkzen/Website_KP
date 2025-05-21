@extends('main')
@section('container')
<section>
  <section id="hero" class="hero section light-background">
    <div class="container">
      <div class="row justify-content-center align-items-center" style="min-height: 400px;">
        <div class="col-lg-8 text-center" data-aos="zoom-out">
          <div class="hero-content p-4 rounded">
            <h1 class="hero-title">
              Selamat datang di <span>Toko Paramonth</span>
            </h1>
            <p class="hero-tagline">
              Kami menyediakan barang-barang elektronik lengkap dan terjamin
            </p>
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
        <div class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="card h-100 shadow-sm" style="border: 2px solid rgb(86, 91, 227); border-radius: 10px;">
                <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" 
                    class="card-img-top img-fluid" 
                    alt="{{ $deskripsi->nama_produk }}" 
                    style="border-bottom: 2px solid rgb(86, 91, 227); max-height: 300px; object-fit: contain;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center" style="color: rgb(86, 91, 227); font-weight: bold;">
                        <a href="{{ route('produk.show', $deskripsi->id) }}" style="text-decoration: none; color: rgb(86, 91, 227);">
                            {{ $deskripsi->nama_produk }}
                        </a>
                    </h5>
                    <p class="card-text text-center">{{ $deskripsi->excerpt }}</p>

                    <!-- Display Average Rating -->
                    <p class="text-center mb-3">
                        <strong>Rating: </strong>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($deskripsi->review->avg('rating')))
                                <span style="color: gold;">&#9733;</span> {{-- Filled star --}}
                            @else
                                <span style="color: lightgray;">&#9734;</span> {{-- Empty star --}}
                            @endif
                        @endfor
                        ({{ number_format($deskripsi->review->avg('rating'), 1) }} / 5)
                    </p>

                    <div class="mt-auto text-center">
                        <a href="{{ route('produk.show', $deskripsi->id) }}" class="btn btn-primary" style="background-color: rgb(86, 91, 227); border: none;">Detail Produk</a>
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
