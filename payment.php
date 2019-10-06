<?php require 'system/config.php'; ?>
<?php
	if (!isset($_GET['id'])) {
		header("location:history.php");
	}else{
		$id = trim($_GET['id']);
		if ($id == "") {
			header("location:history.php");
		}else{
			$getStatus = $app->getStatusPayment($id);
			if ($getStatus == 1) {
				header("location:history.php");
			}else{
				$data = $app->getPayment($id);
			}
		}
	}

	// 

	if (isset($_POST['upload'])) {
		$id = @$_GET['id'];
		$nama = $_POST['nama'];
		$bank = $_POST['bank'];
		$jumlah = $_POST['jumlah'];
		$bukti = $_FILES['bukti']['name'];
		$file_img = $_FILES['bukti']['tmp_name'];
		$rename = date("YmdHis")."_".$bukti;
		move_uploaded_file($file_img, "bukti/$rename");

		// 
		$trx = $app->trx($id, $nama, $bank, $rename, $jumlah);
		$updateStatus = $app->updateStatus($id);
		if ($trx == 1 AND $updateStatus == 1) {
			echo "<script>alert('Pembayaran telah kami terima harap tunggu untuk segera dikonfirmasi');</script>";
			header("location:history.php");

		}else{
			echo "Error ".$rename;
		}

	}
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $setting['title']; ?> &mdash; <?php echo $setting['subtitle']; ?></title>
	<?php include 'template/meta_head.php'; ?>
	</head>
	<body>
		<div id="fh5co-wrapper">
		<div id="fh5co-page">

		<?php include 'template/header.php'; ?>

		<!-- end:header-top -->
	
		
		<div id="fh5co-contact" class="fh5co-section-gray">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center heading-section animate-box">
						<h3>Pembayaran</h3>
					</div>
				</div>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="role" value="users">
					<div class="row animate-box">
						
						<div class="col-md-6 col-md-offset-3 bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="panel">
										<div class="panel-body">
											<p>Segera lakukan pembayaran ke:</p>
											<p>Nama BANK: <b><?php echo $data['nama_bank'] ?></b><br>
											Atas Nama: <b><?php echo $data['atas_nama']; ?></b> <br>
											Kode BANK: <b><?php echo $data['kode_bank'] ?></b><br>
											Nomor Rekening: <b><?php echo $data['norek'] ?></b></p>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Nama Lengkap </label>
										<input type="text" name="nama" class="form-control" placeholder="Nama pemilik akun Bank" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Transfer dari BANK </label>
										<select name="bank" class="form-control" required="">
											<option selected="" disabled="" value="1">Pilih BANK</option>
											<option value="BCA">BCA</option>
											<option value="BRI">BRI</option>
											<option value="BNI">BNI</option>
											<option value="OVO">OVO</option>
											<option value="Mandiri">Mandiri</option>
											<option value="BTPN">BTPN</option>
											<option value="lainnya">Lainnya</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Jumlah yang harus dibayar </label>
										<input type="hidden" name="jumlah" value="<?php echo $data['total_pembelian']; ?>">
										<input type="text" name="xxx" class="form-control" value="Rp.<?php echo number_format( $data['total_pembelian'],0,",",".") ?>" readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Bukti Pembayaran</label>
										<input type="file" name="bukti" class="form-file" required>
									</div>
								</div>
								<div class="col-md-12 py-0">
									<a href="help.php">Butuh bantuan?</a>
									<div class="checkbox">
										<label><input type="checkbox" value="1" required=""> Saya telah menyetujui <a href="#">Syarat & Ketentuan</a> yang berlaku.</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group col-6">
										<input type="submit" value="Upload" name="upload" class="btn btn-primary">
									</div>
									<div class="col-6">
										<p><a href="history.php"><< Kembali</a></p>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		<?php include 'template/footer.php'; ?>
	</div>
	<!-- END fh5co-page -->

	</div>
	<!-- END fh5co-wrapper -->

	<?php include 'template/meta_footer.php'; ?>

	</body>
</html>

