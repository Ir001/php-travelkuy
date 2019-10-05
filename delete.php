<?php 
	require 'system/config.php';
	// 
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		if ($id=="") {
			header("location:destinasi.php");
		}else{
			$delete = $app->deleteCart($id);
		}
	}
	header("location:cart.php");
 ?>