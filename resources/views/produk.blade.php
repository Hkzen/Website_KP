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

        <!-- Product Cards -->
        <div id="product-container" class="row g-4">
            @include('produk_partial', ['produk' => $produk])
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
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

            $.ajax({
                url: 'http://localhost:3000/search',
                method: 'GET',
                data: { keyword: keyword },
                success: function(response) {
                    $('#product-container').html(response.html); // Use the `html` key from the JSON response
                },
                error: function(err) {
                    console.error('Error:', err);
                    $('#product-container').html('<p class="text-danger">Error dalam pencarian</p>');
                }
            });
        });
    });
</script>
@endsection