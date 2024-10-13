<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="/1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Halaman Admin</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/dashboard" class="nav-link {{ Request::is('dashboard')?'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/dashboard/produks" class="nav-link {{ Request::is('dashboard/produks*')?'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Katalog
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/dashboard/kategori" class="nav-link {{ Request::is('dashboard/kategori*')?'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Kategori Produk
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>