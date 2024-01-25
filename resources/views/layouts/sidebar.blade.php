<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('template/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">UD Klambi Anyar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->username }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-header">MAIN NAVIGATION</li>

          <li class="nav-item ">
            <a href="/" class="nav-link {{ Request::is('/', 'dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('mstr/jaritan*', 'mstr/pemasukan*', 'mstr/pengeluaran*') ? 'menu-open' : '' }} ">
            <a href="#" class="nav-link {{ Request::is('mstr/jaritan*', 'mstr/pemasukan*', 'mstr/pengeluaran*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
              <p>
                Data Master
                <i class="nav-icon right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/mstr/jaritan/all" class="nav-link {{ Request::is('mstr/jaritan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jaritan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/mstr/pemasukan/all" class="nav-link {{ Request::is('mstr/pemasukan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/mstr/pengeluaran/all" class="nav-link {{ Request::is('mstr/pengeluaran*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item {{ Request::is('test', 'test2') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('test', 'test2') ? 'active' : '' }}">
                <i class="nav-icon fas fa-money-bill-alt"></i>
              {{-- <i class="nav-icon fas fa-circle"></i> --}}
              <p>
                Transaksi
                <i class="nav-icon right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/test2" class="nav-link {{ Request::is('test2') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gaji</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/test" class="nav-link {{ Request::is('test') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
              {{-- <i class="nav-icon fas fa-circle"></i> --}}
              <p>
                Laporan
                <i class="nav-icon right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pemasukan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pengeluaran</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Keuntungan</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pajak</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>