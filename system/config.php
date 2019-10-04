<?php
//Menjalankan session
session_start();
//setting database koneksi
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWD', 'root'); 
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
			if ($row == 1) {
				$result = $exec->fetch_assoc();
				$data = array(
					'status' => 'success',
					'message' => 'Sukses login',
					'data' => $result,
				);
				$_SESSION['admin'] = $result;
			}else{
				$data = array(
					'status' => 'failed',
					'message' => 'Username tidak tersedia!',
					'data' => null,
				);
			}
		}else{
			$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$exec = $this->query($sql);
			$row = $exec->num_rows;
			if ($row == 1) {
				$result = $exec->fetch_assoc();
				$data = array(
					'status' => 'success',
					'message' => 'Sukses login',
					'data' => $result,
				);
				$_SESSION['user'] = $result;
			}else{
				$data = array(
					'status' => 'failed',
					'message' => 'Username tidak tersedia!',
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
	function addCart($id, $jumlah = 1){
		if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]+=1;
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
	function getDestinasi(){
		$sql = "SELECT * FROM destinasi order by id_destinasi";
		$exec = $this->query($sql);
		$i=0;
		while ($res = $exec->fetch_assoc()) {
			$data[$i] = array(
				'id_destinasi' => $res['id_destinasi'],
				'nama_destinasi' => $res['nama_destinasi'],
				'harga_destinasi' => $res['harga_destinasi'],
				'foto_destinasi' => $res['foto_destinasi'],
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

	function addDestinasi($nama, $harga, $foto, $deskripsi, $jenis){
		$nama = $this->real_escape_string($nama);
		$harga = $this->real_escape_string($harga);
		$foto = $this->real_escape_string($foto);
		$deskripsi = $this->real_escape_string($deskripsi);
		$jenis = $this->real_escape_string($jenis);
		// 
		$sql = "INSERT INTO destinasi (nama_destinasi, harga_destinasi, foto_destinasi, deskripsi_destinasi, jenis) VALUES ('$nama', '$harga', '$foto', '$deskripsi', '$jenis')";
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
}
$app = new Config();