<?php 
  require '../system/config.php';
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 1) {
    header("location:index.php");
  }

  // 

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $setting['title']; ?>  | Log in</title>
  <?php include 'template/meta_head.php'; ?>
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="login.php"><b>Admin</b>System</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk sebagai Admin</p>

      <form id="loginform">
        <input type="hidden" name="role" value="admin">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  </div>
</div>
<!-- /.login-box -->
<?php include 'template/meta_footer.php'; ?>
<script type="text/javascript" src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
  $('#loginform').submit(function(e){
    e.preventDefault();
    $.ajax({
      type : 'POST',
      url : 'loginjs.php',
      data : $('#loginform').serialize(),
      success : function(data){
        if (data === 'success') {
          window.location.replace('index.php');
        }else{
          toastr.error('Kombinasi username dan password tidak cocok!');
        }
      }
    })
  })
</script>
</body>
</html>
