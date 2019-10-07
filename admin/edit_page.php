<?php 
  require '../system/config.php';
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 0) {
    header("location:login.php");
  }elseif (!isset($_GET['id'])) {
    header("location:destinasi.php");
  }else{
    $id = $_GET['id'];
    if ($id=="") {
      header("location:destinasi.php");
    }else{ 
      $page = $admin->getPagebyId($id);
    }
  }
  $data = array(
    'status' => '',
  );

  // 

  if (isset($_POST['edit'])) {
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $add = $admin->updatePage($id, $subtitle, $content);
    $data = $add;
  }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $setting['title']; ?> &mdash; Edit Destinasi</title>
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
            <h1 class="m-0 text-dark">Dashboard - Edit Halaman</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Halaman</li>
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
                <h3 class="card-title">Edit Halaman</h3>
                <div class="card-tools">
                  <a href="add_destinasi.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Judul:</label>
                    <input type="text" class="form-control" name="subtitle" value="<?php echo $page['subtitle']; ?>" placeholder="Trip Wisata Dufan" required>
                  </div>
                   <div class="form-group">
                    <label>Content:</label>
                    <textarea name="content" class="textarea"><?php echo $page['content']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <div class="col-6">
                      <button type="submit" class="btn btn-info" name="edit">Simpan Perubahan</button>
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
          toastr.error('Error!');
    <?php elseif($data['status'] == "success"): ?>
          toastr.success('Berhasil menyimpan perubahan');
    <?php endif; ?>
  })
</script>
</body>
</html>
