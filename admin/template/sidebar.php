  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['admin']['nama_lengkap']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="#" class="nav-link has-treeview menu-open">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Destinasi
              </p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="destinasi.php" class="nav-link"><i class="far fa-circle nav-icon"></i> Daftar Destinasi</a>
              </li> 
              <li class="nav-item">
                <a href="add_destinasi.php" class="nav-link"><i class="far fa-circle nav-icon"></i> Tambah Destinasi</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pembelian.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Pembelian Tiket
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="page.php" class="nav-link">
              <i class="nav-icon fas fa-th "></i>
              <p>
                Halaman
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="contact.php" class="nav-link">
              <i class="nav-icon fas fa-th "></i>
              <p>
                Kontak Kami
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pelanggan.php" class="nav-link">
              <i class="nav-icon fas fa-th "></i>
              <p>
                Pelanggan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="setting.php" class="nav-link">
              <i class="nav-icon fas fa-th "></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>