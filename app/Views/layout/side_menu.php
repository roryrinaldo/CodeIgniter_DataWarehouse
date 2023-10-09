 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
      <img src="<?= base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Data Warehouse</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Menu</li> <!-- Tambahkan baris ini -->
          <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Grafik
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('grafik/staf') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Staf
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/bank') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Bank
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/cabang') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Cabang
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/sektorUsaha') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Sektor Usaha
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/penyebabKlaim') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Penyebab Klaim
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/produk') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Produk
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('grafik/status') ?>" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Status
                  </p>
                </a>
              </li>
            </ul>
          </li>

          
          <?php if (session()->get('user')['level'] == 0): ?>
          <li class="nav-header">Data Master</li> <!-- Tambahkan baris ini -->
          <li class="nav-item">
            <a href="<?= base_url('data') ?>" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Data Store
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('fact_nasabah') ?>" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Table Fact Nasabah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('user') ?>" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Management User
              </p>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->


    </div>
    <!-- /.sidebar -->
  </aside>