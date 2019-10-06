<?php 
  require '../system/config.php';
  $data = array(
    'status' => '',
  );
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 0) {
    header("location:login.php");
  }elseif (!isset($_GET['id'])) {
    header("location:pembelian.php");
  }else{
    $id = $_GET['id'];
    if ($id=="") {
      header("location:pembelian.php");
    }else{ 
      $pembelian = $admin->showPembelian($id);
      $id_destinasi = $pembelian['id_destinasi'];
      $destinasi = $admin->showDetail($id_destinasi);

      // 
      $alamat = $pembelian['alamat']." ,".$pembelian['kota'].", ".$pembelian['provinsi']."(".$pembelian['kode_pos'].")";
    }
  }
  

  // 

  if (isset($_POST['simpan'])) {
    $id_pembelian = $pembelian['id_pembelian'];
    $status = $_POST['status'];
    $updateStatus = $admin->updateStatus($id_pembelian, $status);
    if ($updateStatus == 1) {
      header("location:edit_pembelian.php?id=$id&status=success");
    }else{
      header("location:edit_pembelian.php?id=$id&status=failed");

    }
  }

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Title | Destinasi</title>
  <?php include 'template/meta_head.php'; ?>
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
   <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include 'template/navbar.php'; ?>
<?php include 'template/sidebar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard - Edit Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Tambah Destinasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Detail Pembelian</h3>
                <div class="card-tools">
                  <a href="add_iklan.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <form action="" method="POST">
                  <div class="form-group">
                    <label>Bukti Pembayaran:</label>
                    <div class="col-2">
                      <a href="../bukti/<?php echo $pembelian['bukti']; ?>" target="_blank"><img src="../bukti/<?php echo $pembelian['bukti']; ?>" class="img img-fluid"></a>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Nama Penyetor:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo $pembelian['nama'] ?>" placeholder="Nama Lengkap" readonly>
                  </div>
                  <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo $pembelian['email'] ?>" placeholder="Nama Lengkap" readonly>
                  </div>
                  <div class="form-group">
                    <label>Alamat:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo $alamat; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>Destinasi Wisata:</label>
                    <input type="text" class="form-control" name="destinasi" value="<?php echo $destinasi['nama_destinasi']; ?>" placeholder="Destinasi" readonly>
                  </div>
                  <div class="form-group">
                    <label>Total Harga:</label>
                    <input type="text" class="form-control" min="0" name="harga" value="Rp.<?php echo number_format($pembelian['total_pembelian'],0,",",".") ?>" placeholder="Harga Tiket" readonly>
                  </div>
                  <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                      <option value="review" <?php if ($pembelian['status'] == "review"): ?>
                        selected
                      <?php endif ?>>Ditinjau</option>
                      <option value="valid" <?php if ($pembelian['status'] == "valid"): ?>
                        selected
                      <?php endif ?>>Pembayaran diterima</option>
                      <option value="invalid" <?php if ($pembelian['status'] == "invalid"): ?>
                        selected
                      <?php endif ?>>Pembayaran tidak sah</option>
                      <option value="expired" <?php if ($pembelian['status'] == "expired"): ?>
                        selected
                      <?php endif ?>>Tiket Hangus</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="col-6">
                      <button type="submit" name="simpan" class="btn btn-info">Simpan</button>

                    </div>
                  </div>
                      <a href="pembelian.php"><< Kembali</a>

                </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include 'template/footer.php'; ?>
</div>
<!-- ./wrapper -->

<?php include 'template/meta_footer.php'; ?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
    <?php if (isset($_GET['status']) AND $_GET['status'] == "failed"):?>
          toastr.error('Error!');
    <?php elseif(isset($_GET['status']) AND $_GET['status'] == "success"): ?>
          toastr.success('Berhasil menyimpan data baru');
    <?php endif; ?>
  })
</script>
</body>
</html>
