<?php
	include "config/library.php";
	include "config/fungsi_indotgl.php";
	
	$waktu_skrg = date("Y-m-d");
	$tgl_jalan = tgl_indo($waktu_skrg);
	echo $hari_ini.", ".$tgl_jalan." - ";
	echo $jam_sekarang;
?>