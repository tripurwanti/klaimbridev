<?php
// panggil fungsi validasi xss dan injection
// require_once('fungsi_validasi.php');

// definisikan koneksi ke database
// $server2 	= "10.10.1.90";
// $user2 		= "pti2019";
// $password2 	= "Askrindo321#";
// $database2 	= "askrindo_op";

//dummy90
$server2 	= "10.10.1.173";
$user2 		= "pti01";
$password2 	= "Askrindo@1234";
$database2 	= "dummy90";


// // Koneksi dan memilih database di server
$con2 = sybase_connect($server2, $user2, $password2);
sybase_select_db($database2, $con2) or die ("Database tidak ditemukan");

//echo "eok";
// // buat variabel untuk validasi dari file fungsi_validasi.php
// $val = new Lokovalidasi;