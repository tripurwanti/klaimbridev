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
	
	if ($act=='replygeneral') {
		mysql_query("UPDATE hubungikami SET jawaban = '$_POST[jawaban]' WHERE id = '$_POST[id]'");
		header('location:../../media.php?module=contact_us_general&q=view');
	} elseif ($act=='delete') {
		mysql_query("DELETE FROM hubungikami WHERE id = '$_GET[id]'");
		header('location:../../media.php?module=contact_us_general&q=view');
	} elseif ($act=='deletewbs') {
		$dq = mysql_fetch_array(mysql_query("SELECT * FROM wbs WHERE id = '$_GET[id]'"));
		if (!empty($dq[image])) {
			$file = "../../../files/image/wbs/$dq[image]";
			unlink($file);
		}
		mysql_query("DELETE FROM wbs WHERE id = '$_GET[id]'");
		header('location:../../media.php?module=contact_us_wbs&q=view');
	}
}
?>
