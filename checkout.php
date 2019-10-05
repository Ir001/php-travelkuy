<?php require 'system/config.php'; ?>
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
				<form action="#">
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
										<input type="email" class="form-control" placeholder="Email" value="<?php echo $profile['email']; ?>" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Alamat" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Kota/Kabupaten" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Provinsi" required="">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="number" class="form-control" placeholder="Kode Pos" required="">
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
										<div class="col-md-6 col-sm-6 col-xs-6 text-right"><h3 class="section-title">Total</h3></div>
										<!-- 
											List Tiket
										 -->
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
										 <?php endforeach ?>

										 <div class="col-md-12">
										 	<h4 class="section-title">Pilih Metode Pembayaran</h4>
										 	<div class="form-group">
										 		<select name="payment" class="form-control" required> 
											 		<option value="" selected disabled>Pilih Metode Pembayaran</option>
											 		<option value="bri">Bank BRI (Dicek manual)</option>
											 		<option value="bri">Bank BCA (Dicek manual)</option>
											 		<option value="bri">Bank BNI (Dicek manual)</option>
											 		<option value="bri">OVO (Dicek manual)</option>
											 	</select>
										 	</div>
										 </div>


										<div class="col-md-12" style="margin-top: 20px;">
											<div class="checkbox">
												<label><input type="checkbox" value="1" required> Saya telah setuju dengan <a href="#">Ketentuan Layanan</a> situs <?=$setting['title'];?></label>
											</div>
											<a href="cart.php"><< Kembali</a>
											<button class="btn btn-primary pull-right">Buat Pesanan</button>
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

