@extends('main')
@section('container')
    <h1 class="text-center">{{ $produk->nama_produk }}</h1>
    <section class="p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                </div>
                <div class="col-md-8">
                    <h5>Deskripsi Produk</h5>
                    <p>{!! $produk->deskripsi_produk !!}</p>
                    <p><strong>Harga: </strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    @if ($produk->stok == 0)
                        <p><strong>Stok: </strong> Stok Habis</p>
                    @else
                        <p><strong>Stok: </strong>{{ $produk->stok }}</p>
                    @endif

                    <p><strong>Average Rating: </strong>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($averageRating))
                                <span>&#9733;</span> {{-- Filled star --}}
                            @else
                                <span>&#9734;</span> {{-- Empty star --}}
                            @endif
                        @endfor
                        ({{ number_format($averageRating, 1) }} / 5)
                    </p>

                    <div class="d-flex">
                        <!-- Add to Cart Form -->
                        <form action="{{ route('add.to.cart') }}" method="POST" class="me-2">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $produk->stok }}">
                            <button class="btn btn-success" type="submit">Tambah ke Keranjang</button>
                        </form>
                        <!-- Buy Now Form -->
                        <form action="{{ route('checkout') }}" method="GET">
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $produk->stok }}">
                            <button class="btn btn-primary" type="submit">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>

        <div class="mt-5">
            <h5>Comments</h5>
            <div id="review-container">
                @foreach ($produk->review->take(5) as $comment) {{-- Load the first 5 reviews --}}
                    <div class="border p-3 mb-3">
                        <strong>{{ $comment->user->name }}</strong> 
                        <span>({{ $comment->created_at->format('d M Y') }})</span>
                        <div>Rating: {{ $comment->rating }} / 5</div>
                        <p>{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        
            @if ($produk->review->count() > 5)
                <button id="load-more" class="btn btn-primary mt-3" data-offset="5">Load More</button>
            @endif
        
            <!-- Loading Indicator -->
            <div id="loading-indicator" class="text-center mt-3" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreButton = document.getElementById('load-more');
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function () {
                const button = this;
                const offset = button.getAttribute('data-offset');
                const produkId = {{ $produk->id }}; // Pass the product ID
                const loadingIndicator = document.getElementById('loading-indicator');

                // Show the loading indicator and disable the button
                loadingIndicator.style.display = 'block';
                button.disabled = true;

                fetch(`/produk/${produkId}/load-more-reviews?offset=${offset}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('review-container');

                        data.forEach(comment => {
                            const reviewHtml = `
                                <div class="border p-3 mb-3">
                                    <strong>${comment.user.name}</strong>
                                    <span>(${new Date(comment.created_at).toLocaleDateString()})</span>
                                    <div>Rating: ${comment.rating} / 5</div>
                                    <p>${comment.comment}</p>
                                </div>
                            `;
                            container.insertAdjacentHTML('beforeend', reviewHtml);
                        });

                        // Update the offset
                        const newOffset = parseInt(offset) + data.length;
                        button.setAttribute('data-offset', newOffset);

                        // Hide the button if no more reviews
                        if (data.length < 5) {
                            button.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error loading more reviews:', error))
                    .finally(() => {
                        // Hide the loading indicator and re-enable the button
                        loadingIndicator.style.display = 'none';
                        button.disabled = false;
                    });
            });
        }
    });
</script>
