<?php require 'system/config.php'; ?>
<?php 
	if (!isset($_GET['permalink'])) {
		header("location:index.php");
	}else{
		$permalink = trim($_GET['permalink']);
		if ($permalink == "") {
			header("location:index.php");
		}else{
			$detail = $app->getPage($permalink);
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
	<title><?php echo $setting['title']; ?> &mdash; <?php echo $detail['subtitle']; ?></title>
	<?php include 'template/meta_head.php'; ?>

	</head>
	<body>
		<div id="fh5co-wrapper">
		<div id="fh5co-page">

		<?php include 'template/header.php'; ?>

		<div id="fh5co-blog-section" class="fh5co-section-gray">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center heading-section animate-box">
						<h3><?php echo $detail['subtitle']; ?></h3>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row row-bottom-padded-md">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="fh5co-blog animate-box">
							
							<div class="blog-text">
								<div class="prod-title">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<?php echo $detail['content']; ?>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 20px">
										<a href="index.php"><< Beranda</a>
									</div>
								</div>
							</div> 
						</div>
					</div>
					<div class="clearfix visible-md-block"></div>
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

