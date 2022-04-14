<?php
require_once('../../../model/Ucl.php');
$ucl = new Ucl;
$noPP = $_POST['noPP'];
$response = $ucl->curl(null, "/ucl/inquirySP3/" . $noPP);
if ($response == "200") {
    echo "200";
} else {
    echo "401";
}
