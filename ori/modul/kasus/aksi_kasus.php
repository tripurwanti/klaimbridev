<?php
//error_reporting(0);
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])) {
	header('location:error');
} else {
	include "../../config/koneksi.php";
	include "../../config/library.php";
	include "../../config/fungsi_thumb.php";
	
	$act=$_GET[act];
	$date = $_POST[date]." ".date("H:i:s");
	
	if ($act=='new') {
		$lokasi_file 	= $_FILES['fupload']['tmp_name'];
		$nama_file   	= md5($date).".PDF";
		$tipe_file   	= $_FILES['fupload']['type'];
		UploadFile($nama_file);
		mysql_query("INSERT INTO kasus (
					 id_kasus,
					 judul,
					 file,
					 penerima_jaminan,
					 penjamin,
					 obligee,
					 principal,
					 produk_penjaminan,
					 pekerjaan,
					 nilai_jaminan,
					 deskripsi,
					 pendapat,
					 jangka_waktu,
					 baca) VALUES (
					 '',
					 '$_POST[judul]',
					 '$nama_file',
					 '$_POST[penerima_jaminan]',
					 '$_POST[penjamin]',
					 '$_POST[obligee]',
					 '$_POST[principal]',
					 '$_POST[produk_penjaminan]',
					 '$_POST[pekerjaan]',
					 '$_POST[nilai_jaminan]',
					 '$_POST[deskripsi]',
					 '$_POST[pendapat]',
					 '$_POST[jangka_waktu]','0')");
		header('location:../../media.php?module=kasus&q=data');
	} elseif ($act=='edit') { 
		$qf = mysql_query("SELECT * FROM kasus WHERE id_kasus = '$_POST[id_kasus]'");
		$dqf = mysql_fetch_array($qf); 
		$lokasi_file 	= $_FILES['fupload']['tmp_name'];
		$nama_file   	= md5($date).".PDF";
		$tipe_file   	= $_FILES['fupload']['type'];
		if ($lokasi_file<>'') {
			UploadFile($nama_file);
			$file = "../../databank/$dqf[file]";
			unlink($file);
			mysql_query("UPDATE kasus
						 SET judul = '$_POST[judul]',
						 file = '$nama_file',
						 penerima_jaminan = '$_POST[penerima_jaminan]',
						 penjamin = '$_POST[penjamin]',
						 obligee = '$_POST[obligee]',
						 principal = '$_POST[principal]',
						 produk_penjaminan = '$_POST[produk_penjaminan]',
						 pekerjaan = '$_POST[pekerjaan]',
						 nilai_jaminan = '$_POST[nilai_jaminan]',
						 deskripsi = '$_POST[deskripsi]',
						 pendapat = '$_POST[pendapat]',
						 jangka_waktu = '$_POST[jangka_waktu]'
						 WHERE id_kasus = '$_POST[id_kasus]';");
		} else {
			mysql_query("UPDATE kasus
						 SET judul = '$_POST[judul]',						 
						 penerima_jaminan = '$_POST[penerima_jaminan]',
						 penjamin = '$_POST[penjamin]',
						 obligee = '$_POST[obligee]',
						 principal = '$_POST[principal]',
						 produk_penjaminan = '$_POST[produk_penjaminan]',
						 pekerjaan = '$_POST[pekerjaan]',
						 nilai_jaminan = '$_POST[nilai_jaminan]',
						 deskripsi = '$_POST[deskripsi]',
						 pendapat = '$_POST[pendapat]',
						 jangka_waktu = '$_POST[jangka_waktu]'
						 WHERE id_kasus = '$_POST[id_kasus]';");
		}
		header('location:../../media.php?module=kasus&q=data');
	} elseif ($act=='delete') {
		$dq = mysql_fetch_array(mysql_query("SELECT * FROM kasus WHERE id_kasus = '$_GET[id]'"));
		if (!empty($dq[file])) {
			$file = "../../databank/$dq[file]";
			unlink($file);
		}
		mysql_query("DELETE FROM kasus WHERE id_kasus = '$_GET[id]'");
		header('location:../../media.php?module=kasus&q=data');
	}
}
?>
