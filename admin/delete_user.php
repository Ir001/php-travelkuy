<?php
	require '../system/config.php'; 
 	 $admin = new config();
 	 $loged = $admin->loged();
	 if ($loged == 0) {
	    header("location:login.php");
	  }

	if (!isset($_GET['id'])) {
		header("location:pelangan.php");
	}else{
		$id = $_GET['id'];
		if ($id == "") {
			header("location:pelangan.php");
		}else{
			$delete = $admin->delete_user($id);
			if ($delete == 1) {
				header("location:pelanggan.php?status=success");
			}else{
				header("location:pelanggan.php?status=failed");
			}
		}
	}
 ?>