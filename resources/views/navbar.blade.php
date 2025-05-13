<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container">
    <a class="navbar-brand text-white" href="#">
      <img src="/1.png" alt="Logo" style="height: 40px;"> Paramonth
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('/')?'active' : '' }}" aria-current="page" href="/">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('produk')?'active' : '' }}" href="/produk">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('about')?'active' : '' }}" href="/about">Tentang Kami</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item">
          <a class="nav-link text-white" href="/review">
              <i class="bi bi-pencil-square"></i> Beri Review
              @auth
                  @php
                      $reviewCount = auth()->user()->reviewableProductsCount();
                  @endphp
                  @if($reviewCount > 0)
                      <span class="badge bg-danger" style="margin-left: 5px; padding: 5px 10px;">
                          {{ $reviewCount }}
                      </span>
                  @endif
              @endauth
          </a>
      </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('view.cart') }}">
              <i class="bi bi-cart"></i> Keranjang 
              <span class="badge bg-danger" style="margin-left: 5px; padding: 5px 10px;">{{ \App\Models\Cart::where('user_id', Auth::id())->count() }}</span>
          </a>
        </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                    Hello, {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  @if(auth()->check() && auth()->user()->role == 'admin')
                    <li><a class="dropdown-item" href="/dashboard"> <i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                  @endif
                  @if(auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'user'))
                    <li><a class="dropdown-item" href="{{ route('transaction.history') }}"> <i class="bi bi-layout-text-sidebar-reverse"></i> Histori Transaksi</a></li>
                  @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        @else 
            <li class="nav-item">
                <a class="nav-link text-white" href="/login">
                    <i class="bi bi-box-arrow-in-right"></i> MASUK
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/register">
                    <i class="bi bi-person-plus"></i> DAFTAR
                </a>
            </li>
        @endauth
    </ul>      
    </div>
  </div>
</nav>
