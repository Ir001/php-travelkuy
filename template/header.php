<header id="fh5co-header-section" class="sticky-banner">
			<div class="container">
				<div class="nav-header">
					<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark"><i></i></a>
					<h1 id="fh5co-logo"><a href="index.html"><i class="icon-airplane"></i>Travel</a></h1>
					<!-- START #fh5co-menu-wrap -->
					<nav id="fh5co-menu-wrap" role="navigation">
						<ul class="sf-menu" id="fh5co-primary-menu">
							<li <?php if ($_SERVER['PHP_SELF'] == "/index.php"): ?>
								class="active"
							<?php endif ?>><a href="index.php">Beranda</a></li>
							<li>
								<a href="destinasi.php">Desinasi</a>
							</li>
							<li>
								<a href="#" class="fh5co-sub-ddown">Pemesanan</a>
								<ul class="fh5co-sub-menu">
									<li><a href="cart.php">Keranjang Belanja</a></li>
									<li><a href="history.php">Riwayat Pembelian</a></li>

								</ul>
							</li>
							<li><a href="#">Ketentuan</a></li>
							<li <?php if ($_SERVER['PHP_SELF'] == "/contact.php"): ?>
								class="active"
							<?php endif ?> ><a href="contact.php">Kontak</a></li>
							<li><a href="#">Bantuan</a></li>
							<li><a href="#">Karir</a></li>
							<?php if (isset($_SESSION['user'])): ?>
								<li <?php if ($_SERVER['PHP_SELF'] == "/checkout.php" || $_SERVER['PHP_SELF'] == "/history.php"): ?>
								class="active"
							<?php endif ?>>
								<a href="login.php" class="fh5co-sub-ddown">Akun</a>
								<ul class="fh5co-sub-menu">
									<li><a href="profile.php">Profile</a></li>
									<li><a href="logout.php">Logout</a></li>
								</ul>
							</li>
							<?php else: ?>
							<li <?php if ($_SERVER['PHP_SELF'] == "/login.php" || $_SERVER['PHP_SELF'] == "/register.php"): ?>
								class="active"
							<?php endif ?>>
								<a href="login.php" class="fh5co-sub-ddown">Akun</a>
								<ul class="fh5co-sub-menu">
									<li><a href="login.php">Masuk</a></li>
									<li><a href="register.php">Daftar</a></li>
								</ul>
							</li>	
							<?php endif ?>
							
							
						</ul>
					</nav>
				</div>
			</div>
		</header>