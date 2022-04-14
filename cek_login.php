<?php
// error_reporting(0);
include "config/koneksi.php";
include "config/library.php";

function anti_injection($data)
{
	$filter = mssql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}

//$username	= anti_injection($_POST['username']);
//$pass     	= anti_injection(md5($_POST['password']));

$username	= $_POST['username'];
$pass     	= strtoupper(md5($_POST['password']));

$login	= mssql_query("SELECT * FROM r_user WHERE username = '$username' AND password = '$pass'");
$ketemu	= mssql_num_rows($login);
$r		= mssql_fetch_array($login);

if ($ketemu > 0) {
	session_start();
	include "timeout.php";

	$_SESSION[username]		= $r[username];
	$_SESSION[namauser]  	= $r[nama];
	$_SESSION[password]     = $r[password];
	$_SESSION[id_kantor]    = $r[id_kantor];
	$_SESSION[db]    		= $db;

	$_SESSION[login] = 1;
	timer();

	$tgl_sekarang = date("Y-m-d H:i:s");
	mssql_query("UPDATE r_user SET last_login = '$tgl_sekarang' WHERE username = '$_SESSION[username]'");

	header('location:home');
} else {
	echo "<script>window.alert('LOGIN GAGAL! Username atau Password tidak benar.');
            window.location=(href='index.php')</script>";
}