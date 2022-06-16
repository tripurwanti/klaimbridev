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
$response = $ucl->curl(null, "/ucl/inquirySP3?noSP3=" . $noPP, "GET");
$json = json_decode($response);
if ($json->responseStatus == 1) {
    echo json_encode(setResponse("200", $json->responseObject));
} else {
    echo json_encode(setResponse("400", null));
}
