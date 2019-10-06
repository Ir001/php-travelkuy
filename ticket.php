<?php require 'system/config.php'; ?>
<?php 
	if (!isset($_GET['id'])) {
		header("location:history.php");
	}else{
		$id = $_GET['id'];
		if($id == ""){
			header("location:history.php");
		}else{
			$data = $app->detailPembelian($id);
			$pembelian = $app->ushowPembelian($id);
			$destinasi = $app->showDetail($pembelian['id_destinasi']);
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<style type="text/css">
	*,
	*:after,
	*:before{
		margin:0;
		padding: 0;
	}
	body{
		background: #bbb;
	}
	.box{
		background:#fff;
		margin: 0px auto;
		padding: 10px 15px;
	}
	.box h3{
		font-family: Tahoma;
		padding-bottom: 20px;
	}
	.box-body{
		margin-top: 20px;
	}
	.box p{

	}
</style>
<body>
	<!-- <center> -->
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<h4 class="text-center">Cetak tiket ini untuk masuk Destinasi</h4>
					<hr>
					<div class="box-body">
						<p style="text-align: center;">ID Ticket: <b><?php echo $data['tiket']; ?></b></p>
						<div class="detail">
							<p>Nama Lengkap: <b><?php echo $data['nama_pelanggan']; ?></b></p>
							<p>Email: <b><?php echo $data['email']; ?></b></p>
							<p>Status: 
								<?php if ($data['status'] == "valid"): ?>
								<span class="label label-success">Valid</span>
								<?php elseif($data['status'] == "invalid"): ?>
								<span class="label label-danger">Tidak dapat digunakan</span>
								<?php elseif($data['status'] == "expired"): ?>
								<span class="label label-danger">Masa Berlaku Habis</span>
								<?php endif ?>
							</p>
							<p>Tanggal Pembelian: <b><?php echo $data['tgl_pembelian']; ?></b></p>
							<div class="table">
								<table class="table">
									<tr>
										<th>No</th>
										<th>Nama Destinasi</th>
										<th>Harga per tiket</th>
										<th>Jumlah</th>
										<th>Subtotal</th>
									</tr>
									<tr>
										<td>1</td>
										<td><?php echo $destinasi['nama_destinasi']; ?></td>
										<td>Rp.<?php echo number_format($destinasi['harga_destinasi'],0,",",".");?></td>
										<td><?php echo $data['jumlah']; ?></td>
										<td>Rp.<?php echo number_format($pembelian['total_pembelian'],0,",",".");?></td>
									</tr>
									<tr>
										<td>Total:</td>
										<td></td>
										<td></td>
										<td></td>
										<td><b>Rp.<?php echo number_format($pembelian['total_pembelian'],0,",",".");?></b></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- </center> -->
</body>
</html>