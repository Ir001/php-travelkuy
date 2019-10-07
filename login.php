<?php require 'system/config.php'; ?>
<?php
	$data['status'] = ""; 
	if (isset($_POST['role'])) {
		$role = $_POST['role'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$login = $app->login($email, $password);
		$data = $login;
		if ($data['status'] == "success") {
			$cart = count($_SESSION['cart']);
			if ($cart >= 1) {
				header("location:checkout.php");
			}else{
				header("location:cart.php");
			}
		}
	}elseif (isset($_SESSION['user'])) {
		header("location:index.php");
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
	<title><?php echo $setting['title']; ?> &mdash; Masuk</title>
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
						<h3>Masuk</h3>
					</div>
				</div>
				<form action="" method="post">
					<input type="hidden" name="role" value="users">
					<div class="row animate-box">
						
						<div class="col-md-6 col-md-offset-3 bg-white">
							<div class="row">
								<?php if ($data['status'] == "failed"): ?>
									<div class="col-md-12">
										<p class="alert alert-danger"><?=$data['message'];?></p>
									</div>
								<?php endif ?>
								
								<div class="col-md-12">
									<div class="form-group">
										<input type="email" name="email" class="form-control" placeholder="Email Anda" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
									</div>
								</div>
								<div class="col-md-12 py-0">
									<a href="">Lupa Password?</a>
									<div class="checkbox">
										<label><input type="checkbox" value="1"> Ingatkan Saya</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group col-6">
										<input type="submit" value="Masuk" class="btn btn-primary">
									</div>
									<div class="col-6">
										<p>Belum punya akun? <a href="register.php">Daftar</a></p>
										
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

