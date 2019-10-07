<?php require 'system/config.php'; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $setting['title']; ?> &mdash; Keranjang Belanja</title>
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
						<h3>Keranjang Pembelian Tiket</h3>
					</div>
				</div>
				<div class="row">
					
					<div class="col-md-12 animate-box">
						<div class="table">
							<table class="table">
								<tr class="text-center">
									<th>No</th>
									<th>Destinasi Wisata</th>
									<th>Harga per tiket</th>
									<th>Jumlah</th>
									<th>Total Harga</th>
									<th>Aksi</th>
								</tr>
								<?php 
									$i=1;
									$cart =  @$_SESSION['cart'];
									$jumlah_pesanan = count($cart);
									if($jumlah_pesanan == 0):
								 ?>
								 <tr>
								 	<td>1</td>
								 	<td>Tidak Ada data</td>
								 	<td>Tidak Ada data</td>
								 	<td>Tidak Ada data</td>
								 	<td>Tidak Ada data</td>
								 	<td>Tidak Ada data</td>
								 </tr>
								 <?php else: ?>
								 	<?php $total_semua =0; ?>
								 <?php foreach ($cart as $id => $jumlah): ?>
								 <?php
								 	$data = $app->showDetail($id);
								 	$total = $data['harga_destinasi']*$jumlah;
								  ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $data['nama_destinasi'] ?></td>
									<td>Rp.<?php echo number_format($data['harga_destinasi'],0,",","."); ?></td>
									<td><?php echo $jumlah; ?></td>
									<td>Rp.<?php echo number_format($total,0,",","."); ?></td>
									<td>
										<a href="detail.php?id=<?php echo $data['id_destinasi']; ?>&page=edit" class="btn btn-sm btn-primary">Ubah</a>
										<a href="delete.php?id=<?php echo $data['id_destinasi']; ?>" class="btn btn-sm btn-danger">Hapus Pesanan</a>
									</td>
								</tr>
								<?php $i++; ?>
								<?php 
								 	$total_semua+=$total;
								 ?>
								 <?php endforeach ?>
								 <tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><b>Total: Rp.<?php echo number_format($total_semua,0,",","."); ?></b></td>
								</tr>
									<?php endif ?>
								

							</table>
						</div>
						<?php if ($jumlah_pesanan >= 1): ?>
							<a href="destinasi.php" class="btn btn-info"><< Beli Tiket Lagi</a>
							<a href="checkout.php" class="btn btn-success pull-right">Checkout >></a>
						<?php else: ?>
						<a href="destinasi.php" class="btn btn-info"><< Beli Tiket Dulu</a>
						<a href="history.php" class="btn btn-success pull-right">Riwayat Belanja >></a>
						<?php endif ?>
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

