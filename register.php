<?php require 'system/config.php'; ?>
<?php
	$data['status'] = ""; 
	if (isset($_POST['role'])) {
		// $role = $_POST['role'];
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$ask = $_POST['ask'];
		$answer = $_POST['answer'];
		$answer = strtolower(trim($answer));
		$register = $app->register($fullname, $email, $password, $repassword, $ask, $answer);
		$data = $register;
		if ($data['status'] == "success") {
			echo "<script>alert('Akun berhasil dibuat silahkan Login');</script>";
			header("location:login.php?page=success");
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
	<title><?php echo $setting['title']; ?> &mdash; Daftar</title>
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
						<h3>Daftar</h3>
					</div>
				</div>
				<form action="" method="post">
					<input type="hidden" name="role" value="register_user">
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
										<input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap" required>
									</div>
								</div>
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
								<div class="col-md-12">
									<div class="form-group">
										<input type="password" name="repassword" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<select name="ask" class="form-control">
											<option value="" selected disabled>Pertanyaan untuk kata sandi cadangan</option>
											<option value="ibu">Nama Ibu?</option>
											<option value="hewan">Hewan Peliharaan Pertama?</option>
											<option value="warna">Warna Favorit?</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="password" name="answer" class="form-control" placeholder="Jawaban dari pertanyaan kata sandi cadangan">
									</div>
								</div>
								<div class="col-md-12 py-0">
								</div>
								<div class="col-md-12">
									<div class="form-group col-6">
										<input type="submit" value="Daftar Akun" class="btn btn-primary">
									</div>
									<div class="col-6">
										<p>Sudah punya akun? <a href="login.php">Login</a></p>
										
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

