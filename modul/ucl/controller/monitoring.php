<?php
require_once('../../../model/Ucl.php');
$ucl = new Ucl;

$status = $_POST['status'];
$jenisBG = $_POST['jenisBG'];
$noSP3 = $_POST['noSP3'];
$global = $_POST['global'];

$payload = json_encode(array(
    "statusData" => $status,
    "jenisBG" => $jenisBG,
    "noSP3" => $noSP3,
    "global" => $global
));
$response = $ucl->curl($payload, "/ucl/monitoringUCL?page=1&size=30", "POST");
echo $response;
// echo json_encode($response['content']);
