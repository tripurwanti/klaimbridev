<?php
//error_reporting(0);
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])) {
	header('location:error');
} else {
	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	
	$act=$_GET[act];
	$date = $_POST[date]." ".date("H:i:s");
	
	if ($act=='new') {
		$lokasi_file 	= $_FILES['fupload']['tmp_name'];
		$nama_file   	= md5($tgl_sekarang).".JPG";
		$tipe_file   	= $_FILES['fupload']['type'];
		$direktori_file = "../../../files/image/article/$nama_file";
		UploadImage($nama_file, "article");
		mysql_query("INSERT INTO _post (
					 post_id,
					 en_title,
					 id_title,
					 en_content,
					 id_content,
					 create_time,
					 user_id,
					 image,
					 category_id) VALUES (
					 '',
					 '$_POST[en_title]',
					 '$_POST[id_title]',
					 '$_POST[en_content]',
					 '$_POST[id_content]',
					 '$date',
					 '$_SESSION[iduser]',
					 '$nama_file',
					 '$_POST[category]')");
		header('location:../../media.php?module=article&q=view');
	} elseif ($act=='edit') { 
		$qf = mysql_query("SELECT * FROM _post WHERE post_id = '$_POST[post_id]'");
		$dqf = mysql_fetch_array($qf); 
		$lokasi_file 	= $_FILES['fupload']['tmp_name'];
		$nama_file   	= md5($date).".JPG";
		$tipe_file   	= $_FILES['fupload']['type'];
		$direktori_file = "../../../files/image/article/$nama_file";
		if ($lokasi_file<>'') {
			UploadImage($nama_file, "article");
			$file = "../../../files/image/article/$dqf[image]";
			$sfile = "../../../files/image/article/small_$dqf[image]";
			$mfile = "../../../files/image/article/medium_$dqf[image]";
			unlink($file);
			unlink($sfile);
			unlink($mfile);
			mysql_query("UPDATE _post
						 SET en_title = '$_POST[en_title]',
						 id_title = '$_POST[id_title]',
						 en_content = '$_POST[en_content]',
						 id_content = '$_POST[id_content]',
						 update_time = '$date',
						 user_id = '$_SESSION[iduser]',
						 image = '$nama_file',
						 category_id = '$_POST[category]'
						 WHERE post_id = '$_POST[post_id]';");
		} else {
			mysql_query("UPDATE _post
						 SET en_title = '$_POST[en_title]',
						 id_title = '$_POST[id_title]',
						 en_content = '$_POST[en_content]',
						 id_content = '$_POST[id_content]',
						 update_time = '$date',
						 user_id = '$_SESSION[iduser]',
						 category_id = '$_POST[category]'
						 WHERE post_id = '$_POST[post_id]';");
		}
		header('location:../../media.php?module=article&q=view');
	} elseif ($act=='delete') {
		$dq = mysql_fetch_array(mysql_query("SELECT * FROM _post WHERE post_id = '$_GET[id]'"));
		if (!empty($dq[image])) {
			$file = "../../../files/image/article/$dq[image]";
			$sfile = "../../../files/image/article/small_$dq[image]";
			$mfile = "../../../files/image/article/medium_$dq[image]";
			unlink($file);
			unlink($sfile);
			unlink($mfile);
		}
		mysql_query("DELETE FROM _post WHERE post_id = '$_GET[id]'");
		header('location:../../media.php?module=article&q=view');
	}
}
?>
