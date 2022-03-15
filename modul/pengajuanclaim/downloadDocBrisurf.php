<?php
error_reporting(0);
include "../../config/koneksi_askred.php";
$q  = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$_GET[no_rek]' AND kode_dokumen = '$_GET[kode]'", $con);
$dq = mssql_fetch_array($q);
$file = $dq['file_name'] . "." . $dq['tipe_dokumen'];
// Initialize a file URL to the variable
$filetemp = str_replace(" ", "%20", $file);
$url = '10.20.10.16:8081/api/claim/downloadDigitalDocument/' . $_GET[no_rek] . '/' . $filetemp;
$headers = array(
    "Content-Type: application/force-download" // or whatever you want
);
$ch = curl_init();
// if the file is too big, it should be streamed
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/force-download"
));
$result = curl_exec($ch);

curl_close($ch);

$decoded = base64_decode($result);

file_put_contents($file, $decoded);

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
