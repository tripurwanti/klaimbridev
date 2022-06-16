<?php
require_once('../../../model/Ucl.php');
$ucl = new Ucl;

function setResponse($code, $response)
{
    $result = array(
        "code" => $code,
        "response" => $response
    );
    return $result;
}

$noPP = $_POST['noPP'];
$response = $ucl->curl(null, "/ucl/bookingUCL?noSP3=" . $noPP, "POST");
$json = json_decode($response);
if ($json->responseStatus == 1) {
    echo json_encode(setResponse($json->responseCode, $json->responseObject));
} else {
    echo json_encode(setResponse($json->responseCode, $json->responseMessage));
}
