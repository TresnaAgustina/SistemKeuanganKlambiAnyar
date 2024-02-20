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
          {{-- <a href="#" class="d-block">{{ auth()->user()->username }}</a> --}}
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

          <li class="nav-item {{ Request::is('mstr/customer*', 'mstr/barang*', 'mstr/jaritan*', 'mstr/pemasukan*', 'mstr/pengeluaran*', 'mstr/pegawai-tetap*', 'mstr/pegawai-rumahan*') ? 'menu-open' : '' }} ">
            <a href="#" class="nav-link {{ Request::is('mstr/customer*', 'mstr/barang*', 'mstr/jaritan*', 'mstr/pemasukan*', 'mstr/pengeluaran*', 'mstr/pegawai-tetap*', 'mstr/pegawai-rumahan*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Request::is('mstr/pegawai-tetap*', 'mstr/pegawai-rumahan*') ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ Request::is('mstr/pegawai-tetap*', 'mstr/pegawai-rumahan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Pegawai
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/mstr/pegawai-tetap/all" class="nav-link {{ Request::is('mstr/pegawai-tetap*') ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pegawai Tetap</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/mstr/pegawai-rumahan/all" class="nav-link {{ Request::is('mstr/pegawai-rumahan*') ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pegawai Rumahan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="/mstr/customer/all" class="nav-link {{ Request::is('mstr/customer*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/mstr/barang/all" class="nav-link {{ Request::is('mstr/barang*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Barang</p>
                </a>
              </li>
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

          <li class="nav-item {{ Request::is('piutang*','hutang*','keuangan*', 'pemasukan*', 'pengeluaran*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('piutang*','hutang*', 'keuangan*', 'pemasukan*', 'pengeluaran*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-money-bill-alt"></i>
              {{-- <i class="nav-icon fas fa-circle"></i> --}}
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/keuangan/all" class="nav-link {{ Request::is('keuangan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Keuangan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pemasukan/all" class="nav-link {{ Request::is('pemasukan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/pengeluaran/all" class="nav-link {{ Request::is('pengeluaran*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/piutang/all" class="nav-link {{ Request::is('piutang*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Piutang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/hutang/all" class="nav-link {{ Request::is('hutang*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hutang</p>
                </a>
              </li>
            </ul>
          </li>
         

          <li class="nav-item {{ Request::is('penjualan-jasa*', 'penjualan-lain*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('penjualan-jasa*', 'penjualan-lain*') ? 'active' : '' }}">
                {{-- <i class="nav-icon fas fa-money-bill-alt"></i> --}}
                <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Penjualan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
 
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="/penjualan-jasa/all" class="nav-link {{ Request::is('penjualan-jasa*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jasa Jahit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/penjualan-lain/all" class="nav-link {{ Request::is('penjualan-lain*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penjualan Lainya</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ Request::is('kasbon-tetap*', 'kasbon-rumahan*') ? 'menu-open' : '' }}">
            <a href="/kasbon-tetap/all" class="nav-link {{ Request::is('kasbon-tetap*', 'kasbon-rumahan*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Kasbon
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
 
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="/kasbon-tetap/all" class="nav-link {{ Request::is('kasbon-tetap*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai Tetap</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kasbon-rumahan/all" class="nav-link {{ Request::is('kasbon-rumahan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai Rumahan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ Request::is('gaji/pegawai-tetap*', 'gaji/pegawai-rumahan*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('gaji/pegawai-tetap*', 'gaji/pegawai-rumahan*') ? 'active' : '' }}">
                {{-- <i class="nav-icon fas fa-shopping-cart"></i> --}}
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Penggajian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
 
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="/gaji/pegawai-tetap/all" class="nav-link {{ Request::is('gaji/pegawai-tetap*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai Tetap</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/gaji/pegawai-rumahan/all" class="nav-link {{ Request::is('gaji/pegawai-rumahan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai Rumahan</p>
                </a>
              </li>
            </ul>
          </li>
          

          <li class="nav-item ">
            <a href="/aktivitas/all" class="nav-link {{ Request::is('aktivitas*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-clock"></i>
              <p>Aktivitas</p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('laporan-pemasukan*', 'laporan-pengeluaran*', 'laporan-keuntungan*', 'laporan-pajak*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('laporan-pemasukan*', 'laporan-pengeluaran*', 'laporan-keuntungan*', 'laporan-pajak*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
              {{-- <i class="nav-icon fas fa-circle"></i> --}}
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/laporan-pemasukan/all" class="nav-link {{ Request::is('laporan-pemasukan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pemasukan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/laporan-pengeluaran/all" class="nav-link {{ Request::is('laporan-pengeluaran*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pengeluaran</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/laporan-keuntungan/all" class="nav-link {{ Request::is('laporan-keuntungan*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Keuntungan</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/laporan-pajak/all" class="nav-link {{ Request::is('laporan-pajak*') ? 'active' : '' }}">
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