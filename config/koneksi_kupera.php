<?php
// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');

// definisikan koneksi ke database
$server = "localhost";
$username = "sa";
$password = "p@ssw0rd";
$database = "aos_kur_bri";

// Koneksi dan memilih database di server
$con = mssql_connect($server,$username,$password);
mssql_select_db($database, $con) or die ("Database tidak ditemukan");

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new Lokovalidasi;

?>
