@extends('main')

@section('container')
<h1 class="text-center mb-4" style="font-weight: bold; color: rgb(86, 91, 227);">Add a Review</h1>
<section class="p-3">
    <div class="container">
        @if($produk->isEmpty())
            <p class="text-center">You have no products to review.</p>
        @else
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="row g-4">
                @foreach($produk as $product)
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

@if(isset($reviews) && !$reviews->isEmpty())
<hr class="my-5">
<h2 class="text-center mb-4" style="font-weight: bold; color: rgb(86, 91, 227);">Your Review History</h2>
<div class="container">
    <div class="row g-4">
        @foreach($reviews as $review)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm" style="border: 2px solid #e0e0e0; border-radius: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: rgb(86, 91, 227); font-weight: bold;">
                            {{ $review->produk->nama_produk ?? '-' }}
                        </h5>
                        <p>
                            <strong>Rating:</strong>
                            @for($i = 0; $i < $review->rating; $i++)
                                ★
                            @endfor
                            @for($i = $review->rating; $i < 5; $i++)
                                ☆
                            @endfor
                        </p>
                        <p><strong>Comment:</strong> {{ $review->comment }}</p>
                        <div class="d-flex justify-content-between">
                            <button type="button"
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editReviewModal"
                                data-id="{{ $review->id }}"
                                data-rating="{{ $review->rating }}"
                                data-comment="{{ $review->comment }}"
                                data-action="{{ route('review.update', $review->id) }}">
                                Edit
                            </button>
                            <form action="{{ route('review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                        <small class="text-muted">Reviewed on {{ $review->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Modal Edit Review -->
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editReviewForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_rating" class="form-label">Rating</label>
            <select name="rating" id="edit_rating" class="form-select" required>
              <option value="5">★★★★★</option>
              <option value="4">★★★★</option>
              <option value="3">★★★</option>
              <option value="2">★★</option>
              <option value="1">★</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_comment" class="form-label">Comment</label>
            <textarea name="comment" id="edit_comment" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Review</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editReviewModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var action = button.getAttribute('data-action');
        var rating = button.getAttribute('data-rating');
        var comment = button.getAttribute('data-comment');
        var form = document.getElementById('editReviewForm');
        form.action = action;
        form.querySelector('#edit_rating').value = rating;
        form.querySelector('#edit_comment').value = comment;
    });
});
</script>

@endsection