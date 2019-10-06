<?php require 'system/config.php'; ?>
<?php 
	if (!isset($_SESSION['cart'])) {
		header("location:cart.php");
	}
	//
	if (isset($_POST['checkout'])) {
		//
		$id_user = $_SESSION['user']['id_users'];
		// $id_destinasi = $_POST['id_destinasi'];
		$id_payment = $_POST['payment'];
		$name = $_POST['nama'];
		$email = $_POST['email'];
		$no_hp = $_POST['no_hp'];
		$alamat = $_POST['alamat'];
		$kota = $_POST['kota'];
		$provinsi = $_POST['provinsi'];
		$kode_pos = $_POST['kode_pos'];
		//
		foreach ($_SESSION['cart'] as $id => $jumlah) {
			$id_destinasi = $id;
			$data = $app->showDetail($id);
			$total = $data['harga_destinasi']*$jumlah;
			$checkout = $app->checkout($id_user, $id_destinasi, $id_payment, $name, $email, $no_hp, $alamat, $kota, $provinsi, $kode_pos, $total, $jumlah);
			if ($checkout == 1) {
				unset($_SESSION['cart']);
				header("location:history.php");
			}else{
				header("location:checkout.php?return=failed");
			}
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
						<h3>Checkout</h3>
					</div>
				</div>
				<form action="" method="post">
					<?php 
						$profile = $_SESSION['user'];
						$nama = $profile['nama_pelanggan'];
						$pisah = explode(" ", $nama);
						$nama_depan = $pisah[0];
						$nama_belakang = @$pisah[1]?$pisah[1]:" ";
					 ?>
					<div class="row animate-box">
						
						<div class="col-md-6">
							<h3 class="section-title">Billing Address</h3>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="hidden" name="nama" value="<?php echo $nama; ?>">
										<input type="text" class="form-control" placeholder="Nama Depan" value="<?php echo $nama_depan; ?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Nama Belakang" value="<?php echo $nama_belakang; ?>">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="email" name="email" class="form-control" placeholder="Email Aktif" value="<?php echo $profile['email']; ?>" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" name="no_hp" class="form-control" maxlength="14" placeholder="Nomor HP Aktif" value="62" autofocus="" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" name="alamat" class="form-control" placeholder="Alamat" >
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" name="kota" class="form-control" placeholder="Kota/Kabupaten" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" name="provinsi" class="form-control" placeholder="Provinsi" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="number" name="kode_pos" class="form-control" maxlength="5" placeholder="Kode Pos" required="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="panel" style="margin-top: 55px;">
								<div class="panel-body">
									<h3 class="section-title">Pesanan Anda</h3>
									<p>Hallo kak, <b><?php echo $_SESSION['user']['nama_pelanggan']; ?></b>. Berikut adalah detail pesanan Anda.</p>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6"><h3 class="section-title">Tiket</h3></div>
										<div class="col-md-6 col-sm-6 col-xs-6 text-right"><h3 class="section-title">Subtotal</h3></div>
										<!-- 
											List Tiket
										 -->
										 <?php $total_semua = 0; ?>
										 <?php foreach ($_SESSION['cart'] as $id => $jumlah): ?>
										 <?php 
										 	$data = $app->showDetail($id);
								 			$total = $data['harga_destinasi']*$jumlah;
										  ?>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<p><?php echo $data['nama_destinasi']; ?> <b>x <?php echo $jumlah ?></b></p>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6 text-right">
											<p>Rp.<?php echo number_format($total,0,",","."); ?></p>
										</div>
										<?php $total_semua+=$total; ?>
										 <?php endforeach ?>
										<div class="col-md-6 col-sm-6 col-xs-6"><h3 class="section-title">Total Belanja:</h3></div>
										<div class="col-md-6 col-sm-6 col-xs-6 text-right"><h3 class="section-title">Rp.<?php echo number_format($total_semua,0,",",".") ?></h3></div>


										 <div class="col-md-12">
										 	<h4 class="section-title">Pilih Metode Pembayaran</h4>
										 	<div class="form-group">
										 		<select name="payment" class="form-control" required> 
											 		<option value="" selected disabled>Pilih Metode Pembayaran</option>
											 <?php 
											 	$i=1;
											 	$getbank = $app->getAllBank();
											  ?>
											  <?php foreach ($getbank as $data): ?>

											 		<option value="<?php echo $data['id_payment'] ?>"><?php echo $data['nama_bank']; ?></option>
											 	<?php $i++; ?>		
											  <?php endforeach ?>
											 	</select>
										 	</div>
										 </div>


										<div class="col-md-12" style="margin-top: 20px;">
											<div class="checkbox">
												<label><input type="checkbox" value="1" required> Saya telah setuju dengan <a href="#">Ketentuan Layanan</a> situs <?=$setting['title'];?></label>
											</div>
											<a href="cart.php"><< Kembali</a>
											<button type="submit" name="checkout" class="btn btn-primary pull-right">Buat Pesanan</button>
										</div>
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

