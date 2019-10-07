<?php 
  require '../system/config.php';
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 0) {
    header("location:login.php");
  }
  $pelanggan = $admin->getPelanggan();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $setting['title']; ?> &mdash; Pelanggan</title>
  <?php include 'template/meta_head.php'; ?>
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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
            <h1 class="m-0 text-dark">Dashboard - Pelanggan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Pelanggan</li>
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
                <h3 class="card-title">Destinasi</h3>
                <div class="card-tools">
                  <a href="add_destinasi.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <table id="pelanggan" class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $i=0;
                      foreach ($pelanggan as $data) {
                     ?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>
                    <td>
                      <?php echo $data['nama_pelanggan']; ?> 
                    </td>
                     <td>
                      <?php echo $data['email']; ?> 
                    </td>
                    <td>
                    	<a href="delete_user.php?id=<?php echo $data['id_users']; ?>" class="btn btn-sm btn-danger" onclick="var status = confirm('Apakah Anda yakin? data yang sudah dihapus tidak dapat dikembalikan'); if (status == true) {return true} else{return false}">Delete</a>
                    </td>
                  </tr>
                  <?php $i++; } ?>
                  </tbody>
                </table>
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
<script type="text/javascript">
  $(function(){
    $('#pelanggan').DataTable();
  })
  var realy = function(){
   var ask = confirm('Apakah anda yakin?');
   if (ask == true) {
    return true;
   }else{
    return false;
   }
  }
   <?php if (isset($_GET['status']) AND $_GET['status'] == "failed"):?>
          toastr.error('Error!');
    <?php elseif(isset($_GET['status']) AND $_GET['status'] == "success"): ?>
          toastr.success('Berhasil menghapus user');
    <?php endif; ?>
</script>
</body>
</html>
