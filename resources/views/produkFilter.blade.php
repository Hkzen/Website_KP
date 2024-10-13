@extends('main')
@section('container')
<h1>Produk</h1>
    <section class="p-5">
        <div class="container">
          <div class="row">
            <form action="{{ url('/produkFilter') }}" style="margin-bottom: 15px;" method="get">
              @csrf
              <label for="keyword">Cari nama produk : </label>
              <input type="text" name="keyword" placeholder="{{ $keyword }}" style="width: 10cm;">
              <button type="submit" class="btn btn-warning">Cari</button>
            </form>  

            @if (isset($message))
                <p>{{ $message }}</p>
            @endif 
         
            @foreach ($produks as $deskripsi)               
            <div class="col-md-4 mb-3" style="display: flex; flex-wrap: wrap;">
                <div class="card" style="border-color:rgb(228, 161, 37); border-width: 5px;">   
                    <img src="{{ asset('storage/' . $deskripsi->foto_produk) }}" class="card-img-top" alt="Foto">   
                    <div class="card-body">
                      <h5 class="card-title"><a href="/produk/{{ $deskripsi->slug }}"
                      style="color: rgb(32, 150, 110)">{{ $deskripsi->nama_produk }}</a>
                      </h5>
                      <p class="card-text">{{ $deskripsi->excerpt }}</p>
                      <div class="text-end">                
                      <a href="/produk/{{ $deskripsi->slug }}" class="btn btn-primary" style="position: absolute; bottom: 0; right: 0; width: 120px; height: 32px; font-size:14px;">Detail produk</a>
                      </div> 
                    </div>               
                </div>
              </div>  
            @endforeach  
           
            
          </div>
        </div>
    </section>
@endsection