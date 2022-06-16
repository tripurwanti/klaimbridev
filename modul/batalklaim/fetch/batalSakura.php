<?php
error_reporting(1);
include "../../../config/koneksi.php";
$rootdir = "klaimbridevwanti/klaimbridev";
$msg = '';
$noRekening = $_REQUEST['noRekening'];
$ketTolak = $_REQUEST['ketTolak'];
$noKlaim = $_REQUEST['noKlaim'];
// echo $ketTolak;
$isKolek = false;
$status_batal = '2';
$updateDate = date("Y-m-d H:i:s");
if (strpos($ketTolak, "olektabilitas bergeser membaik")) {
    $isKolek = true;
} else {
    $isKolek = false;
}
// echo $isKolek;

$url = 'http://10.20.10.5:8081/api/op/klaim/cancel';
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
$data = array(
    'noKlaim' => $noKlaim,
    'noRekening' => $noRekening,
    'reason' => $ketTolak,
    'perbaikanKolek' => $isKolek
);
$payloadRequest = json_encode($data);
print_r($payloadRequest);
die();
// var_dump($payloadRequest);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payloadRequest);
// }
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// // EXECUTE:
$resultcurl = curl_exec($curl);
if (!$resultcurl) {
    die("Connection Failure");
}
$response = json_decode($resultcurl, true);
// var_dump($response);
// echo $response["status"];
$msgresponse = $response["message"];
if ($response["status"] == '01') {
    $status_batal = '2';
    $msg = 'Rehit batal klaim ke sakura gagal.' . $msgresponse . '.  Hubungi administrator.';
} else if ($response["status"] == '00') {
    $status_batal = '1';
    $msg = 'Rehit batal klaim ke sakura  berhasil.';
} else {
    $msg = $response['error'];
}

$q = mssql_query("UPDATE pengajuan_klaim_kur_gen2_history SET status_batal = $status_batal,  update_date = '$updateDate' WHERE no_rekening = $noRekening");
// echo "UPDATE pengajuan_klaim_kur_gen2_history SET status_batal = $status_batal,  update_date = '$updateDate' WHERE no_rekening = $noRekening";
curl_close($curl);

echo "<script>window.alert('" . $msg . "');
window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=batalklaim')
</script>";
