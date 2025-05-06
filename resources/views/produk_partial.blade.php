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