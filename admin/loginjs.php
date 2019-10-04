<?php 
  require '../system/config.php';
  $admin = new config();
  $loged = $admin->loged();
  if ($loged == 1) {
    header("location:index.php");
  }
  if(isset($_POST['role'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    //

    $login = $admin->login($username, $password, $role);
    if ($login['status'] == "success") {
      echo "success";
    }else{
      echo "failed";
    }
  }else{
    
  }
 ?>