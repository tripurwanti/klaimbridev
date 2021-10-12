<?php

include '../../config/koneksi_askred.php';

$correctionDate = $_POST['correctiondate'];
$description = $_POST['description'];
$idDataRC =  $_REQUEST['idDataRC'];
mssql_query("UPDATE askred_mapping_rc_bri_subrogasi SET correction_date = '" . $correctionDate . "', description = '" . $description . "', ismatch  = '4' , isposting  = '1'  WHERE id = " . $idDataRC . "");
echo "<script>
    alert('Data Berhasil Dikoreksi');
     </script>";
echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=correction&idDataRC=" . $idDataRC . "'</script>";