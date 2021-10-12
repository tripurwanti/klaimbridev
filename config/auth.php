<?php
//include "koneksi.php";
function authentic($param){
	$x = mysql_query("SELECT * FROM login WHERE username = '$param'");
	$dx = mysql_fetch_array($x);
	return $dx['password'];
}
?>