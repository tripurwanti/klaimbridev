<?php
include '../../config/koneksi_askred.php';

$idFile = $_GET['id'];
$noBk = $_POST['no_bk'];
$noBd = $_POST['no_bd'];
$noMmSubrogasi = $_POST['no_mm_subrogasi'];
$noMmCollectingFee = $_POST['no_mm_collecting_fee'];
$tglBk = $_POST['tgl_bk'];
$tglBd = $_POST['tgl_bd'];
$update_date = date("Y-m-d H:i:s");

$batchDate = date("Y-m-d");
$batchDate = str_replace("-", "", "$batchDate");

$counter = 1;
$dataLatestCounter = mssql_query("SELECT TOP 1 * FROM askred_counter_subrogasi ORDER BY id DESC", $con);
$dDataLatestCounter = mssql_fetch_array($dataLatestCounter);
if ($dDataLatestCounter['date'] == $batchDate) {
    $counter = $dDataLatestCounter['counter'] + 1;
}

$counterpad = str_pad($counter, 5, "0", STR_PAD_LEFT);
$batchID = $batchDate . "" . $counterpad;

$listDataSubro = array();

$dataRCMatch = mssql_query("SELECT * FROM askred_mapping_rc_bri_subrogasi
WHERE ismatch = '1' AND id_file_rc=" . $idFile, $con);

while ($dDataRCMatch  = mssql_fetch_array($dataRCMatch)) {
    $splitCl = explode(".", $dDataRCMatch['no_cl']);
    $idKantor = $splitCl[1];
    $originalDate = $dDataRCMatch['bri_flag_date'];
    $old_date_timestamp = strtotime($originalDate);
    $new_date = date('Y-m-d', $old_date_timestamp);
    $dataSubro = array(
        "noKlaim" => $dDataRCMatch['no_cl'],
        "noRekening" => $dDataRCMatch['nomor_rekening'],
        "urutanPengajuan" => $dDataRCMatch['urutan_pengajuan'],
        "idKantorAsk" => $idKantor,
        "nilaiRecoveries" => $dDataRCMatch['credit'],
        "collectingFeeNet" => $dDataRCMatch['debet'],
        "remarkRC" => $dDataRCMatch['remark'],
        "tglPenerimaan" => $new_date
    );
    array_push($listDataSubro, $dataSubro);
}

$payloadRequest = array(
    "batchID" => $batchID,
    "listRecoveries" => $listDataSubro
);
$payloadRequest = json_encode($payloadRequest);

$url = '10.20.10.5:8081/api/op/trxpembayaran/recoveries/create/bulk';
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
$data = $payloadRequest;
if ($data) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
}
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// EXECUTE:
$resultcurl = curl_exec($curl);
// if (!$resultcurl) {
//     die("Connection Failure");
// }
// print_r($resultcurl);
curl_close($curl);
$saveNewCounter = mssql_query("INSERT INTO askred_counter_subrogasi
(date, counter, create_date)
VALUES('" . $batchDate . "', " . $counter . ", '" . $update_date . "')", $con);

mssql_query("UPDATE askred_file_rc_subrogasi
SET update_date='" . $update_date . "', 
posting_date='" . $update_date . "', 
bd_subrogation_date='" . $tglBd . "', 
bk_collecting_fee_date='" . $tglBk . "', 
no_bd_subrogasi='" . $noBd . "', 
no_mm_subrogasi='" . $noMmSubrogasi . "', 
no_bk_collecting_fee='" . $noBk . "', 
no_mm_collecting_fee='" . $noMmCollectingFee . "', 
status='2'
WHERE id=" . $idFile, $con);