<?php
error_reporting(0);
include "config/koneksi.php";

session_start();

if ($_SESSION[username] == 'admin') {
	$q = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '0'";
} else {
	$q = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '0' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]'";
}

$dq = mssql_fetch_array(mssql_query($q));

if ($dq['banyak_data'] > 0) {
	echo "<span class='nav-badge-btm'>".$dq['banyak_data']."</span>";
} 

?>
