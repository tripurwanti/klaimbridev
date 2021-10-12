<?php
// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');

// definisikan koneksi ke database
$server = "10.10.1.4";
$username = "askrindo";
$password = "p@ssw0rd";
$database = "askrindo_briguna";

// Koneksi dan memilih database di server
$con = mssql_connect($server,$username,$password);
mssql_select_db($database, $con) or die ("Database tidak ditemukan");

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new Lokovalidasi;

?>
