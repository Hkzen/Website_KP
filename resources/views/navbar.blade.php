<nav class="navbar navbar-expand-lg bg-warning">
    <div class="container">
      <a class="navbar-brand" href="#">Paramonth</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/')?'active' : '' }}" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('produk')?'active' : '' }}" href="/produk">Produk</a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('view.cart') }}">
                <i class="bi bi-cart"></i> Keranjang 
                <span class="badge bg-danger">{{ \App\Models\Cart::where('user_id', Auth::id())->count() }}</span>
            </a>
        </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                      Hello, {{ auth()->user()->name }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @if(auth()->check() && auth()->user()->role == 'admin')
                      <li><a class="dropdown-item" href="/dashboard"> <i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>
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
                  <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">
                      <i class="bi bi-box-arrow-in-right"></i> LOGIN
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="/register">
                      <i class="bi bi-person-plus"></i> REGISTER
                  </a>
              </li>
          @endauth
      </ul>      
      </div>
    </div>
  </nav>