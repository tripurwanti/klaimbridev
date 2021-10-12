<?php
$server 	= "10.20.10.16";
$user 		= "askrindo";
$password 	= "p@ssw0rd";
$database 	= "aos_kur_bri";

$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con) or die ("Database tidak ditemukan");
?>