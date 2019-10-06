<?php 
  require '../system/config.php';
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 0) {
    header("location:login.php");
  }
  $data = array(
    'status' => '',
  );

  // 

  if (isset($_POST['add'])) {
    $nama = $_POST['nama_destinasi'];
    $harga = $_POST['harga'];
    $deskripsi= $_POST['deskripsi_destinasi'];
    $kota = $_POST['kota'];
    $foto = $_FILES['foto']['name'];
    $file_img = $_FILES['foto']['tmp_name'];
    $rename = date("YmdHis")."_".$foto;
    move_uploaded_file($file_img, "../images/$rename");
    $add = $admin->addDestinasi($nama, $harga, $rename, $deskripsi, $kota);
    $data = $add;
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
            <h1 class="m-0 text-dark">Dashboard - Tambah Destinasi</h1>
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
                <h3 class="card-title">Tambah Destinasi Wisata</h3>
                <div class="card-tools">
                  <a href="add_iklan.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Nama Destinasi:</label>
                    <input type="text" class="form-control" name="nama_destinasi" placeholder="Trip Wisata Dufan" required>
                  </div>
                  <div class="form-group">
                    <label>Kota:</label>
                    <input type="text" class="form-control" name="kota" placeholder="Jakarta" required>
                  </div>
                  <div class="form-group">
                    <label>Harga:</label>
                    <input type="number" class="form-control" min="0" name="harga" placeholder="1.000.000" required>
                  </div>
                  <div class="form-group">
                    <label>Foto:</label>
                    <input type="file" class="form-control" name="foto" required>
                  </div>
                   <div class="form-group">
                    <label>Deskripsi Wisata:</label>
                    <textarea name="deskripsi_destinasi" class="textarea"></textarea>
                  </div>
                  <div class="form-group">
                    <div class="col-6">
                      <button type="submit" class="btn btn-info" name="add">Tambah Destinasi</button>
                    </div>
                  </div>

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
    <?php if ($data['status'] == "failed"):?>
          toastr.error('Erro!');
    <?php elseif($data['status'] == "success"): ?>
          toastr.success('Berhasil menambahkan destinasi wisata baru');
    <?php endif; ?>
  })
</script>
</body>
</html>
