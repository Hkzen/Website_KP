@extends('main')
@section('container')
<h1 class="text-center mb-4" style="font-weight: bold; color: rgb(86, 91, 227);">Produk</h1>
<section class="p-3">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Search Bar -->
            <form id="searchForm" class="d-flex mb-4 col-md-8">
                <input type="text" id="keyword" name="keyword" class="form-control me-2" placeholder="Cari Produk..." style="border: 2px solid rgb(86, 91, 227); border-radius: 8px;">
                <button type="submit" class="btn btn-primary" style="background-color: rgb(86, 91, 227); border: none;">Cari</button>
            </form>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Product Listing -->
        <div id="product-container" class="row g-4">
            @include('produk_partial', ['produk' => $produk])
        </div>
        
        <!-- Pagination Links -->
        <div class="pagination-container d-flex justify-content-center mt-4">
            {{ $produk->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Search Handling
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            const keyword = $('#keyword').val();

            // Clear previous results and reset state
            $('#product-container').html('<div class="text-center mt-3">Memuat...</div>');
            $('.pagination-container').html(''); // Clear pagination links

            $.ajax({
                url: '/search',
                method: 'GET',
                data: { keyword: keyword },
                success: function(response) {
                    renderSearchResults(response);
                },
                error: function(err) {
                    console.error('Error:', err);
                    $('#product-container').html('<p class="text-danger">Error dalam pencarian</p>');
                }
            });
        });

        // Handle AJAX Pagination Clicks
        $(document).on('click', '.ajax-pagination a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const keyword = $(this).data('keyword');

            // Clear previous results and reset state
            $('#product-container').html('<div class="text-center mt-3">Memuat...</div>');

            $.ajax({
                url: '/search',
                method: 'GET',
                data: { keyword: keyword, page: page },
                success: function(response) {
                    renderSearchResults(response);
                },
                error: function(err) {
                    console.error('Error:', err);
                    $('#product-container').html('<p class="text-danger">Error dalam pencarian</p>');
                }
            });
        });

        // Render Search Results and Pagination
        function renderSearchResults(response) {
            if (response.products.length > 0) {
                let html = '';
                response.products.forEach(product => {
                    html += `
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card h-100 shadow-sm" style="border: 2px solid rgb(86, 91, 227); border-radius: 10px;">
                                <img src="/storage/${product.foto_produk}" class="card-img-top img-fluid" alt="${product.nama_produk}" style="border-bottom: 2px solid rgb(86, 91, 227); max-height: 300px; object-fit: contain;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center" style="color: rgb(86, 91, 227); font-weight: bold;">
                                        <a href="/produk/${product.id}" style="text-decoration: none; color: rgb(86, 91, 227);">
                                            ${product.nama_produk}
                                        </a>
                                    </h5>
                                    <p class="card-text text-center">${product.excerpt || ''}</p>
                                    <p class="text-center mb-3">
                                        <strong>Rating: </strong>
                                        ${Array.from({ length: 5 }, (_, i) => 
                                            i < Math.floor(product.avg_rating) ? 
                                            '★' : '☆'
                                        ).join('')}
                                        (${product.avg_rating.toFixed(1)} / 5)
                                    </p>
                                    <div class="mt-auto text-center">
                                        <a href="/produk/${product.id}" class="btn btn-primary" style="background-color: rgb(86, 91, 227); border: none;">Detail Produk</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#product-container').html(html);

                // Update pagination links for search results
                let paginationHtml = `
                    <nav>
                        <ul class="pagination justify-content-center ajax-pagination">
                            ${response.currentPage > 1 ? `<li class="page-item"><a class="page-link" href="#" data-page="${response.currentPage - 1}" data-keyword="${response.keyword}">Previous</a></li>` : ''}
                            <li class="page-item"><a class="page-link" href="#" data-page="${response.currentPage}" data-keyword="${response.keyword}">${response.currentPage}</a></li>
                            ${response.hasMore ? `<li class="page-item"><a class="page-link" href="#" data-page="${response.currentPage + 1}" data-keyword="${response.keyword}">Next</a></li>` : ''}
                        </ul>
                    </nav>
                `;
                $('.pagination-container').html(paginationHtml);
            } else {
                $('#product-container').html('<p class="text-muted">Produk tidak ditemukan</p>');
                $('.pagination-container').html('');
            }
        }
    });
</script>
@endsection