<?php
error_reporting(1);
include "../../../config/koneksi.php";


$idPengajuanClaimHistory = $_REQUEST['id'];
$q = mssql_query("SELECT a.*, b.* , c.* 
FROM pengajuan_klaim_kur_gen2_history a INNER JOIN jawaban_klaim_kur_gen2_history b ON a.id = b.id_pengajuan_history 
LEFT JOIN pengembalian_dana_batch c ON a.batch_id = c.batch_id WHERE a.id = $idPengajuanClaimHistory");
$d =  mssql_fetch_array($q);
$file = explode(",", $d['file_bukti_pengembalian_dana']);
$exp = explode("/", $file[0]);
$formatFile = explode(";", $exp[1]);
// echo $formatFile[0];
if ($formatFile[0] == "pdf") {
    header("Content-type: application/pdf");
    $data = $file[1];
    echo base64_decode($data);
} else if ($formatFile[0] == 'png' || $formatFile[0] == 'jpg' || $formatFile[0] == 'jpeg') {
    // header("Content-type: image/jpeg");
    // $data = $file[1];
    // echo base64_decode($data);
    echo '<img src="' . $d['file_bukti_pengembalian_dana'] . '" />';
}



// $decoded = base64_decode($base64[1]);
// $file = $d['filename_bukti'];
// file_put_contents($file, $decoded);

// if (file_exists($file)) {
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment; filename="' . basename($file) . '"');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($file));
//     readfile($file);
//     exit;
// }