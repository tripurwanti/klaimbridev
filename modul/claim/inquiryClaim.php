<?php

$norekPinjaman = $_POST['nomor_rekening'];

$url = 'localhost:8081/api/claim/inquiryClaim';
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);

$payload = json_encode(array("nomorPeserta" => $norekPinjaman));
if ($payload) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
}
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// EXECUTE:
$resultcurl = curl_exec($curl);
// if (!$resultcurl) {
//     die("Connection Failure");
// }
curl_close($curl);

$result = json_decode($resultcurl, true);
if($result['dataClaim'][0]['claimStatus'] == 7){
        echo 'Status claim : '.$result['dataClaim'][0]['claimStatusDesc'].'. Data telah dibatalkan, mohon cek menu batal klaim';
} else {
        echo 'Status claim :'. $result['dataClaim'][0]['claimStatusDesc'].'.';
}
?>