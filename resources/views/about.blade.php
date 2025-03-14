@extends('main')
@section('container')
<div class="container">
    <h1 class="text-center my-4">Toko Paramonth</h1>
    <section class="p-3">
        <div class="container py-3">
            <div class="row">
                <!-- Bagian Gambar Toko -->
                <div class="col-12 col-md-6 mb-3">
                    <div class="p-4 shadow" style="box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
                        <img src="paramonth.png" class="img-fluid rounded" alt="Toko Paramonth">
                    </div>
                </div>
                <!-- Deskripsi Toko -->
                <div class="col-12 col-md-6 mb-3 d-flex align-items-center">
                    <div class="p-3">
                        <p class="fs-4 fs-md-3">Toko Paramonth adalah toko elektronik terpercaya yang menyediakan berbagai produk teknologi berkualitas sejak 2019. Berkomitmen untuk memenuhi kebutuhan teknologi pelanggan dengan pelayanan terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h1 class="text-center my-4">Lokasi Toko Paramonth</h1>
        <div class="container py-3">
            <div class="row">
                <!-- Daftar Lokasi -->
                <div class="col-12 col-md-6 mb-3 order-2 order-md-1">
                    <div class="p-4">
                        <div class="fs-5">
                            <div class="mb-4">
                                <h2>Cabang Pertama - Serdam</h2>
                                <p>Beralamat di <strong>Jalan Sungai Raya Dalam, No D20, Kabupaten Kubu Raya, Kalimantan Barat</strong></p>
                                <a href="https://maps.app.goo.gl/aAQ4oYo3V3VVqij76" target="_blank" class="btn btn-primary">Cabang Serdam</a>
                            </div>
                            <div class="mb-4">
                                <h2>Cabang Kedua - Podomoro</h2>
                                <p>Beralamat di <strong>Jl. Putri Candramidi, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat</strong></p>
                                <a href="https://maps.app.goo.gl/FXjKkMGc62fbUbBL9" target="_blank" class="btn btn-primary">Cabang Podomoro</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Gambar Lokasi -->
                <div class="col-12 col-md-6 mb-3 order-1 order-md-2">
                    <div class="p-3">
                        <img src="Loc.png" class="img-fluid rounded shadow" alt="Lokasi Toko" style="max-height: 70vh; width: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection