<?php
error_reporting(0);
include "config/koneksi.php";
$q 	= mssql_query("SELECT * FROM dbo.bni_dokumen_dev WHERE no_fasilitas = '$_GET[no_rek]' AND kode_dokumen = '$_GET[kode]';", $con);
$dq = mssql_fetch_array($q);
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
//header("Content-type: ".$dq[type]);
header("Content-Disposition: attachment; filename=".$dq[no_fasilitas]." ".$dq[kode_dokumen].$dq[type]);
//echo '<img src="data:'.$dq[type].';base64,' . $dq[dokumen] . '" />';
//readfile("data:'".$dq[type]."';base64,'".base64_decode($dq[dokumen])."'");
echo base64_decode($dq[dokumen]);
?>