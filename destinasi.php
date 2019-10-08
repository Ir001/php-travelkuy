<?php require 'system/config.php'; ?>
<?php 
	$destinasi = $app->getDestinasi();
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $setting['title']; ?> &mdash; Destinasi Wisata</title>
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
						<h3>Destinasi Wisata Di Indonesia</h3>
					</div>
				</div>
				<div class="row">
					<?php foreach ($destinasi as $data): ?>
						
					<div class="col-md-4 col-sm-6 fh5co-tours animate-box" data-animate-effect="fadeIn">
						<div href="detail.php?id=<?php echo $data['id_destinasi']; ?>"><img src="images/<?php echo $data['foto_destinasi']; ?>" alt=" " class="img-responsive" style="height:280px">
							<div class="desc">
								<span></span>
								<h3><?php echo $data['nama_destinasi']; ?></h3>
								<span><?php echo ucwords($data['kota']); ?></span>
								<span class="price">Rp.<?php echo number_format($data['harga_destinasi'], 0, ",", "."); ?></span>
								<div class="row">
									<div class="col-md-6">
										<a href="buy.php?id=<?php echo $data['id_destinasi']; ?>" class="btn btn-sm" style="border:none;">Booking</a>
									</div>
									<div class="col-md-6">
										<a href="detail.php?id=<?php echo $data['id_destinasi']; ?>" class="btn btn-sm pull-right" style="border:none;">Detail</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div id="fh5co-testimonial" style="background-image:url(images/img_bg_1.jpg);">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<h2>Kritik dan Saran</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box-testimony animate-box">
						<blockquote>
							<span class="quote"><span><i class="icon-quotes-right"></i></span></span>
							<p>&ldquo;Sangat menarik.&rdquo;</p>
						</blockquote>
						<p class="author">Anthonio</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-testimony animate-box">
						<blockquote>
							<span class="quote"><span><i class="icon-quotes-right"></i></span></span>
							<p>&ldquo;Wah, keren sih ini bisa ngelihat destinasi wisata yang lengkap.&rdquo;</p>
						</blockquote>
						<p class="author">Ardhanta</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-testimony animate-box">
						<blockquote>
							<span class="quote"><span><i class="icon-quotes-right"></i></span></span>
							<p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.&rdquo;</p>
						</blockquote>
						<p class="author">Aimar</p>
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

