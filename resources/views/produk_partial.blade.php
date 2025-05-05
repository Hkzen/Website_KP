{{-- Hanya berisi loop produk tanpa layout --}}
@foreach ($produk as $deskripsi)
<div class="col-md-4 mb-3">
    <div class="card h-100" style="border-color:rgb(86, 91, 227); border-width: 5px; box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
        <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="card-img-top" alt="{{ $deskripsi->nama_produk }}" style="outline-style: solid; outline-width: 2px; outline-color:rgb(86, 91, 227);">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('produk.show', $deskripsi->id) }}" style="color: rgb(86, 91, 227);">
                    {{ $deskripsi->nama_produk }}
                </a>
            </h5>
            <p style="word-wrap: break-word;">{{ $deskripsi->excerpt }}</p>
            <p>
                <strong>Rating: </strong>
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($deskripsi->review->avg('rating')))
                        <span>&#9733;</span>
                    @else
                        <span>&#9734;</span>
                    @endif
                @endfor
                ({{ number_format($deskripsi->review->avg('rating'), 1) }} / 5)
            </p>
            <div class="d-flex justify-content-end">
                <a href="{{ route('produk.show', $deskripsi->id) }}" class="btn btn-primary" style="position: absolute; bottom: 10px; right: 10px;">
                    Detail Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach