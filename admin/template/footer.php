<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Xixixi</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
     <p><?php echo  $_SESSION['admin']['nama_lengkap']; ?> | <a href="index.php?logout">Logout</a></p>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo  date("Y"); ?> <a href="#">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>