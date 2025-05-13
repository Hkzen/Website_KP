@extends('main')

@section('container')
<h1 class="text-center mb-4" style="font-weight: bold; color: rgb(86, 91, 227);">Add a Review</h1>
<section class="p-3">
    <div class="container">
        @if($products->isEmpty())
            <p class="text-center">You have no products to review.</p>
        @else
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm" style="border: 2px solid rgb(86, 91, 227); border-radius: 10px;">
                            
                            <div class="card-body">
                                <h5 class="card-title text-center" style="color: rgb(86, 91, 227); font-weight: bold;">
                                    {{ $product['name'] }}
                                </h5>
                                <form action="{{ route('review.store', $product['id']) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <select name="rating" id="rating" class="form-select" required>
                                            <option value="5">★★★★★</option>
                                            <option value="4">★★★★</option>
                                            <option value="3">★★★</option>
                                            <option value="2">★★</option>
                                            <option value="1">★</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="background-color: rgb(86, 91, 227); border: none;">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection