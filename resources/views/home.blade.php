@extends('main')
@section('container')
    <h1>Home</h1>
  <section class="p-5 bg-light" style="background-color:gray;">
    <div class="container">
      <div class="row" >
        <div class="col-md-12 mb-3" >
          <div class="card mb-3" style="outline-style: solid;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="R.jpeg" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Toko Paramonth</h5>
                  <p class="card-text">Toko dengan berbagai macam produk elektronik</p>
                  <a href="/produk" type="button" class="btn btn-warning mb-2" style="position: absolute;
                  bottom: 0;">Next</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <p>TEST</p>
    </div>
  </section>
@endsection