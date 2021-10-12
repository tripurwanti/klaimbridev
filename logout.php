<?php
//include "configurasi/koneksi.php";
session_start();
//mysql_query("UPDATE online SET online='T' WHERE id_siswa = '$_SESSION[idsiswa]'");
//mysql_query("UPDATE intrask_user SET ol_intrask_user = '0' WHERE id_intrask_user = '$_SESSION[iduser]'");
session_destroy();
header ('location:login');
?>
