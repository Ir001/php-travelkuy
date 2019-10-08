<?php
//Menjalankan session
session_start();
//setting database koneksi
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWD', ''); 
define('DB_NAME', 'db_pariwisata'); 

$conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

class Config extends mysqli{
	function __construct(){
		parent::__construct(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
	}
	function getSetting(){
		$exec = $this->query("SELECT * FROM setting");
		$data = $exec->fetch_assoc();	
		return $data;
	}
	function login($username , $password, $role = "user"){
		$data = array();
		$username = $this->real_escape_string($username);
		$password = $this->real_escape_string($password);
		//$password = $this->real_escape_string(md5($password)); //Konsep Enkripsi
		if ($role == "admin") {
			$sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
			$exec = $this->query($sql);
			$row = $exec->num_rows;
			$result = $exec->fetch_assoc();
			if ($row == 1 AND $result['password'] == $password) {
				$data = array(
					'status' => 'success',
					'message' => 'Sukses login',
					'data' => $result,
				);
				$_SESSION['admin'] = $result;
			}elseif($row == 1 AND $result['password'] != $password){
				$data = array(
					'status' => 'failed',
					'message' => 'Kata sandi salah!',
					'data' => $result,
				);
			}else{
				$data = array(
					'status' => 'failed',
					'message' => 'Username tidak tersedia!',
					'data' => null,
				);
			}
		}else{
			$sql = "SELECT * FROM users WHERE email = '$username'";
			$exec = $this->query($sql);
			$row = $exec->num_rows;
			$result = $exec->fetch_assoc();
			if ($row == 1 AND $result['password'] == $password) {
				$data = array(
					'status' => 'success',
					'message' => 'Sukses login',
					'data' => $result,
				);
				$_SESSION['user'] = $result;
			}elseif($row == 1 AND $result['password'] != $password){
				$data = array(
					'status' => 'failed',
					'message' => 'Kata Sandi Salah!',
					'data' => $result,
				);
			}else{
				$data = array(
					'status' => 'failed',
					'message' => 'Email tidak terdaftar!',
					'data' => null,
				);
			}

		}
		return @$data;

	}
	function register($nama, $email, $password, $repassword, $ask_hint=null, $hint=null ){
		$nama = $this->real_escape_string($nama);
		$email = $this->real_escape_string($email);
		$password = $this->real_escape_string($password);
		$repassword = $this->real_escape_string($repassword);
		//
		$sql_cek = $this->query("SELECT email FROM users WHERE email = '$email'");
		$cek = $sql_cek->num_rows; //Mengecek Email tersedia
		if ($cek == 0 AND $password == $repassword) {
			$sql = "INSERT INTO users (nama_pelanggan, email, password, ask_hint, hint) VALUES ('$nama', '$email', '$password', '$ask_hint', '$hint')";
			$exec = $this->query($sql);
			$data = array(
				'status' => 'success',
				'message' => 'Akun Anda berhasil dibuat!'
			);
		}elseif($cek == 0 AND $password != $repassword){
			$data = array(
				'status' => 'failed',
				'message' => 'Kata sandi dan konfirmasi tidak cocok!'
			);

		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Email sudah tersedia!'
			);

		}
		return @$data;

	}
	function logout(){
		session_destroy();
		return 1;
	}
	function contactUs($fullname, $email, $message){
		$fullname = $this->real_escape_string($fullname);
		$email = $this->real_escape_string($email);
		$message = $this->real_escape_string($message);
		//
		$sql = "INSERT INTO kontak (fullname, email, message, tgl) VALUES ('$fullname', '$email', '$message', NOW())";
		if ($exec= $this->query($sql)) {
			return 1;
		}else{
			return 0;
		}

	}
	function getPage($permalink){
		$permalink = trim($this->real_escape_string($permalink));
		$sql = "SELECT * FROM page WHERE permalink ='$permalink'";
		$exec = $this->query($sql);
		$data = $exec->fetch_assoc();
		return @$data;
	}
	function getPagebyId($id){
		$id = trim($this->real_escape_string($id));
		$sql = "SELECT * FROM page WHERE id ='$id'";
		$exec = $this->query($sql);
		$data = $exec->fetch_assoc();
		return @$data;
	}

	function addCart($id, $jumlah=1, $cond="plus"){
			if (isset($_SESSION['cart'][$id])) {
				if ($cond == "plus") {
					$_SESSION['cart'][$id]+=$jumlah;
				}elseif($cond == "minus"){
					$_SESSION['cart'][$id]-=$jumlah;
				}else{
					$_SESSION['cart'][$id]=$jumlah;
				}
			}else{
				$_SESSION['cart'][$id]=$jumlah;
			}
		return 1;
	}
	function deleteCart($id){
		unset($_SESSION['cart'][$id]);
		return 1;
	}
	function showDetail($id){
		$id = $this->real_escape_string($id);
		$sql = "SELECT * FROM destinasi WHERE id_destinasi = $id";
		$exec = $this->query($sql);
		$row = $exec->num_rows;
		if ($row >= 1) {
			$data = $exec->fetch_assoc();
			$data['status'] = "success";
		}else{
			$data['status'] = "failed";
		}
		return @$data;
	}
	function getAllBank(){
		$sql = "SELECT * FROM payment_method";
		$exec = $this->query($sql);
		$i=0;
		while ($result = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_payment' => $result['id_payment'],
				'nama_bank' => $result['nama_bank'],
				'norek' => $result['norek'],
			);
			$i++;
		}
		return @$data;
	}

	// Checkout
	function checkout($id_user, $id_destinasi, $id_payment, $nama, $email, $no_hp, $alamat, $kota, $provinsi, $kode_pos, $total, $jumlah){
		$id_user = $this->real_escape_string($id_user);
		$id_destinasi = $this->real_escape_string($id_destinasi);
		$id_payment = $this->real_escape_string($id_payment);
		$nama = $this->real_escape_string($nama);
		$email = $this->real_escape_string($email);
		$no_hp = $this->real_escape_string($no_hp);
		$alamat = $this->real_escape_string($alamat);
		$kota = $this->real_escape_string($kota);
		$provinsi = $this->real_escape_string($provinsi);
		$kode_pos = $this->real_escape_string($kode_pos);
		$a = rand(1000,9999);
		$b = rand(10000,99999);
		$c = rand(100000,999999);
		$tiket = $a."-".$b."-".$c;
		// 
		$sql = "INSERT INTO pembelian (id_users, id_destinasi, id_payment, nama_lengkap, email, no_hp, alamat, kota, provinsi, kode_pos, total_pembelian, jumlah, tiket, tgl_pembelian) VALUES ('$id_user', '$id_destinasi', '$id_payment', '$nama', '$email',' $no_hp', '$alamat', '$kota', '$provinsi', '$kode_pos', '$total','$jumlah', '$tiket', NOW())";
		if ($exec = $this->query($sql)) {
			return 1;
		}else{
			return 0;
		}

	}

	// 
	function getPembelian($id="all"){
		if ($id == "all") {
			$sql = "SELECT * FROM pembayaran JOIN pembelian ON pembayaran.id_pembelian = pembelian.id_pembelian WHERE pembelian.status != 'segera'";
		}else{
			$id = @$_SESSION['user']['id_users'];
			$sql = "SELECT * FROM pembelian WHERE id_users = $id";
		}
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_pembayaran' => $res['id_pembayaran'],
				'id_pembelian' => $res['id_pembelian'],
				'id_destinasi' => $res['id_destinasi'],
				'id_payment' => $res['id_payment'],
				'nama_lengkap' => $res['nama_lengkap'],
				'email' => $res['email'],
				'no_hp' => $res['no_hp'],
				'alamat' => $res['alamat'],
				'kota' => $res['kota'],
				'provinsi' => $res['provinsi'],
				'kode_pos' => $res['kode_pos'],
				'jumlah' => $res['jumlah'],
				'total_pembelian' => $res['total_pembelian'],
				'tgl_pembelian' => $res['tgl_pembelian'],
				'status' => $res['status'],
			);
			$i++;
		}
		return @$data;
	}
	function showPembelian($id){
		$id = $this->real_escape_string($id);
		$sql = "SELECT * FROM pembayaran JOIN pembelian ON pembayaran.id_pembelian = pembelian.id_pembelian WHERE pembayaran.id_pembayaran = $id";
		$exec = $this->query($sql);
		$row = $exec->num_rows;
		if ($row >= 1) {
			$data = $exec->fetch_assoc();
		}else{
			$data['status'] = "failed";
		}
		return @$data;

	}
	function ushowPembelian($id){
		$id = $this->real_escape_string($id);
		$sql = "SELECT * FROM pembayaran JOIN pembelian ON pembayaran.id_pembelian = pembelian.id_pembelian WHERE pembayaran.id_pembelian = $id";
		$exec = $this->query($sql);
		$row = $exec->num_rows;
		if ($row >= 1) {
			$data = $exec->fetch_assoc();
		}else{
			$data['status'] = "failed";
		}
		return @$data;

	}
	function detailPembelian($id){
		$id = $this->real_escape_string($id);
		$sql = "SELECT * FROM pembelian JOIN users ON pembelian.id_users = users.id_users WHERE pembelian.id_pembelian = $id";
		$exec = $this->query($sql);
		$row = $exec->num_rows;
		if ($row >= 1) {
			$data = $exec->fetch_assoc();
		}else{
			$data['status'] = "failed";
		}
		return @$data;

	}
	function getHistory(){
		$id = @$_SESSION['user']['id_users'];
		$sql = "SELECT * FROM pembelian JOIN destinasi ON pembelian.id_destinasi = destinasi.id_destinasi  WHERE pembelian.id_users = $id";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_pembelian' => $res['id_pembelian'],
				'nama_destinasi' => $res['nama_destinasi'],
				'kota' => $res['kota'],
				'foto_destinasi' => $res['foto_destinasi'],
				'harga_destinasi' => $res['harga_destinasi'],
				'jumlah' => $res['jumlah'],
				'total_pembelian' => $res['total_pembelian'],
				'status' => $res['status'],
				'tgl_pembelian' => $res['tgl_pembelian'],				
			);
			$i++;
		}
		return @$data;

	}
	function getPayment($id){
		$sql = "SELECT id_pembelian, total_pembelian, atas_nama, norek, nama_bank, kode_bank FROM pembelian JOIN payment_method ON pembelian.id_payment = payment_method.id_payment ";
		$exec = $this->query($sql);
		$data = $exec->fetch_assoc();
		return $data;
	}
	function getStatusPayment($id){
		$exec = $this->query("SELECT id_pembelian FROM pembayaran WHERE id_pembelian = $id");
		$row = $exec->num_rows;
		if ($row == 1) {
			return 1;
		}else{
			return 0;
		}
	}
	function trx($id_pembelian, $nama, $bank, $bukti, $jumlah){
		$nama = $this->real_escape_string($nama);
		$bank = $this->real_escape_string($bank);
		$bukti = $this->real_escape_string($bukti);
		$jumlah = $this->real_escape_string($jumlah);
		// 
		$sql = "INSERT INTO pembayaran (id_pembelian, nama, bank, bukti, jumlah, tgl) VALUES('$id_pembelian', '$nama', '$bank', '$bukti', '$jumlah', NOW())";
		if ($exec = $this->query($sql)) {
			return 1;
		}else{
			return 0;
		}
	}
	function updateStatus($id, $status="review"){
		$sql = "UPDATE pembelian SET status = '$status' WHERE id_pembelian =$id";
		if ($exec = $this->query($sql)) {
			return 1;
		}else{
			return 0;

		}
	}
	function updateSetting($title, $subtitle, $description){
		$sql = "UPDATE setting SET title = '$title', subtitle = '$subtitle', description='$description'";
		if ($exec = $this->query($sql)) {
			$data['status'] = "success";
		}else{
			$data['status'] = "failed";
		}
		return @$data;

	}




	/*
		System Untuk Admin
	*/


	function loged(){
		if (isset($_SESSION['admin'])) {
			return 1;
		}else{
			return 0;
		}
	}
	function getDestinasi($limit=999){
		$sql = "SELECT * FROM destinasi order by id_destinasi DESC LIMIT 0, $limit";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_destinasi' => $res['id_destinasi'],
				'nama_destinasi' => $res['nama_destinasi'],
				'harga_destinasi' => $res['harga_destinasi'],
				'foto_destinasi' => $res['foto_destinasi'],
				'deskripsi_destinasi' => $res['deskripsi_destinasi'],
				'kota' => $res['kota'],
			);
			$i++;
		}
		return @$data;
	}
	function showDestinasi($id){
		$exec = $this->query("SELECT * FROM destinasi WHERE id_destinasi = $id");
		$data = $exec->fetch_assoc();
		return @$data;
	}
	function getPelanggan(){
		$sql = "SELECT * FROM users order by id_users";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_users' => $res['id_users'],
				'nama_pelanggan' => $res['nama_pelanggan'],
				'email' => $res['email'],
			);
			$i++;
		}
		return @$data;

	}
	function addAdmin($nama, $uname, $password, $repassword){
		$nama = $this->real_escape_string($nama);
		$uname = $this->real_escape_string($uname);
		$password = $this->real_escape_string($password);
		$repassword = $this->real_escape_string($repassword);
		//
		$sql_cek = $this->query("SELECT username FROM admin WHERE username = '$uname'");
		$cek = $sql_cek->num_rows; //Mengecek Username tersedia
		if ($cek == 0 AND $password == $repassword) {
			$sql = "INSERT INTO admin (username, password, nama_lengkap) VALUES ('$uname', '$password', '$nama')";
			$exec = $this->query($sql);
			$data = array(
				'status' => 'success',
				'message' => 'Akun Anda berhasil dibuat!'
			);
		}elseif($cek == 0 AND $password != $repassword){
			$data = array(
				'status' => 'failed',
				'message' => 'Kata sandi dan konfirmasi tidak cocok!'
			);

		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Username sudah tersedia!'
			);
		}
		return @$data;
	}
	function editSetting($title, $subtitle, $desc, $logo){
		$title = $this->real_escape_string($title);
		$subtitle = $this->real_escape_string($subtitle);
		$desc = $this->real_escape_string($desc);
		$logo = $this->real_escape_string($logo);
		//
		$sql = "UPDATE setting SET title = '$title', subtitle = '$subtitle', description = '$desc', logo = '$logo'";
		if ($exec = $this->query($sql)) {
			$data = array(
				'status' => 'success',
				'message' => 'Data berhasil disimpan!'
			);
		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Data gagal disimpan!'
			);
		}
		return @$data;
	}

	function addDestinasi($nama, $harga, $foto, $deskripsi, $kota){
		$nama = $this->real_escape_string($nama);
		$harga = $this->real_escape_string($harga);
		$foto = $this->real_escape_string($foto);
		$deskripsi = $this->real_escape_string($deskripsi);
		$kota = $this->real_escape_string($kota);
		$kota = strtolower($kota);
		// 
		$sql = "INSERT INTO destinasi (nama_destinasi, harga_destinasi, foto_destinasi, deskripsi_destinasi, kota) VALUES ('$nama', '$harga', '$foto', '$deskripsi', '$kota')";
		if ($exec = $this->query($sql)) {
			$data = array(
				'status' => 'success',
				'message' => 'Berhasil menambahkan destinasi baru'
			);
		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Error!'
			);
		}
		return @$data;
	}
	function updateDestinasi($id, $nama, $harga, $foto, $deskripsi, $kota){
		$nama = $this->real_escape_string($nama);
		$harga = $this->real_escape_string($harga);
		$foto = $this->real_escape_string($foto);
		$deskripsi = $this->real_escape_string($deskripsi);
		$kota = $this->real_escape_string($kota);
		$kota = strtolower($kota);
		// 
		$sql = "UPDATE destinasi SET nama_destinasi='$nama', harga_destinasi='$harga',foto_destinasi= '$foto', deskripsi_destinasi='$deskripsi',kota='$kota' WHERE id_destinasi = $id";
		if ($exec = $this->query($sql)) {
			$data = array(
				'status' => 'success',
				'message' => 'Berhasil menambahkan destinasi baru'
			);
		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Error!'
			);
		}
		return @$data;
	}
	function delete_user($id){
		if ($exec = $this->query("DELETE FROM users WHERE id_users = $id")) {
			return 1;
		}else{
			return 0;
		}

	}
	function grabPage(){
		$sql = "SELECT * FROM page";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id' => $res['id'],
				'permalink' => $res['permalink'],
				'subtitle' => $res['subtitle'],
				'content' => $res['content'],
			);
			$i++;
		}
		return @$data;
	}
	function updatePage($id, $subtitle, $content){
		$subtitle = $this->real_escape_string($subtitle);
		$content = $this->real_escape_string($content);
		
		// 
		$sql = "UPDATE page SET subtitle='$subtitle', content='$content' WHERE id = $id";
		if ($exec = $this->query($sql)) {
			$data = array(
				'status' => 'success',
				'message' => 'Berhasil menambahkan destinasi baru'
			);
		}else{
			$data = array(
				'status' => 'failed',
				'message' => 'Error!'
			);
		}
		return @$data;
	}
	function grabContact(){
		$sql = "SELECT * FROM kontak";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_saran' => $res['id_saran'],
				'fullname' => $res['fullname'],
				'email' => $res['email'],
				'message' => $res['message'],
				'tgl' => $res['tgl'],
			);
			$i++;
		}
		return @$data;
	}
}
$app = new Config();
$setting = $app->getSetting();