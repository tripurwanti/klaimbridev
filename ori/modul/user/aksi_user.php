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
	
	if ($act=='new') {
		$pass = md5($_POST[password]);
		mysql_query("INSERT INTO user (
					 username,
					 namauser,
					 password,
					 level) VALUES (
					 '$_POST[username]',
					 '$_POST[namauser]',
					 '$pass',
					 '$_POST[level]')");
		header('location:../../media.php?module=user&q=data');
	} elseif ($act=='edit') { 
		$pass = md5($_POST[password]);
		$qf = mysql_query("SELECT * FROM user WHERE username = '$_POST[username]'");
		$dqf = mysql_fetch_array($qf); 
		if ($_POST[password]<>'') {
			mysql_query("UPDATE user
						 SET namauser = '$_POST[namauser]',
						 password = '$pass',
						 level = '$_POST[level]'
						 WHERE username = '$_POST[username]';");
		} elseif ($_POST[password]==''){
			mysql_query("UPDATE user
						 SET namauser = '$_POST[namauser]',
						 level = '$_POST[level]'
						 WHERE username = '$_POST[username]';");
		}
		header('location:../../media.php?module=user&q=data');
	} elseif ($act=='delete') {
		mysql_query("DELETE FROM user WHERE username = '$_GET[id]'");
		header('location:../../media.php?module=user&q=data');
	}
}
?>
