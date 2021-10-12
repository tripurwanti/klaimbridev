<?php
session_start();
function timer(){
	$time=10000000;
	$_SESSION[timeout]=time()+$time;
}
function cek_login(){
	$timeout=$_SESSION[timeout];
	if(time()<$timeout) {
		timer();
		return true;
	} else {
        //mysql_query("UPDATE intrask_user SET ol_intrask_user = '0' WHERE id_intrask_user = '$_SESSION[iduser]'");
		unset($_SESSION[timeout]);
		return false;
	}
}
?>
