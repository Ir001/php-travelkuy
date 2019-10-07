<?php require 'system/config.php'; ?>
<?php if (!isset($_SESSION['user'])): ?>
<?php header("location:login.php"); ?>
<?php endif ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $setting['title']; ?> &mdash; Riwayat Pembelian</title>
	<?php include 'template/meta_head.php'; ?>
	</head>
	<body>
		<div id="fh5co-wrapper">
		<div id="fh5co-page">

		<?php include 'template/header.php'; ?>

		<div id="fh5co-tours" class="fh5co-section-gray">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center heading-section animate-box">
						<h3>Riwayat Pembelian Tiket</h3>
					</div>
				</div>
				<div class="row">
					
					<div class="col-md-12 animate-box">
						<div class="table">
							<table class="table">
								<tr class="text-center">
									<th>No</th>
									<th>Destinasi Wisata</th>
									<th>Kota</th>
									<th>Status</th>
									<th>Tgl Order</th>
									<th>Aksi</th>
								</tr>
								<?php 
									$i=1;
									$pembelian = $app->getHistory();
									
								 ?>
								 <?php foreach ($pembelian as $data): ?>
								 <?php 
								 	$status = $data['status'];
								  ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $data['nama_destinasi']; ?></td>
									<td><?php echo ucwords($data['kota']); ?></td>
									<?php if ($status == "review"): ?>
									<td><span class="label label-info">
										Sedang ditinjau
									</span></td>
									<?php elseif($status == "valid"): ?>
									<td><span class="label label-success"><?php echo ucwords($status); ?></span></td>
									<?php elseif($status == "invalid"): ?>
									<td><span class="label label-danger">Pembayaran tidak sah</span></td>
									<?php elseif($status == "segera"): ?>
									<td><span class="label label-warning">Segera Lakukan Pembayaran</span></td>
									<?php else: ?>
									<td><span class="label label-danger"><?php echo ucwords($status); ?></span></td>
									<?php endif ?>
									<td><?php echo $data['tgl_pembelian']; ?></td>
									<td>
										<?php if ($status == "review"): ?>
											<a href="kotak.php" target="_blank" class="btn btn-sm btn-primary">Kontak Kami</a>
										<?php elseif($status == "segera"): ?>
											<a href="payment.php?id=<?php echo $data['id_pembelian'] ?>" class="btn btn-sm btn-primary">Bayar</a>
											<a href="#" class="btn btn-sm btn-danger">Hapus Pesanan</a>
										<?php elseif($status == "valid"): ?>
											<a href="ticket.php?id=<?php echo $data['id_pembelian'] ?>" class="btn btn-sm btn-info">Lihat Tiket</a>
										<?php elseif($status == "invalid"): ?>
											<a href="#" class="btn btn-sm btn-primary">Kontak</a>
										<?php else: ?>
											<a href="#" class="btn btn-sm btn-danger">Hapus Tiket</a>
										<?php endif ?>
										

									</td>
								</tr>
									<?php $i++; ?>
								 <?php endforeach ?>
							</table>
						</div>
					</div>
				</div>
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

