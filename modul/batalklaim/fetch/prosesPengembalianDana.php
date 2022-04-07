<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi.php";
$rootdir = "klaimbridevwanti/klaimbridev";

$file_bukti_temp = $_FILES['bukti_dana']['tmp_name'];
$filename = $_FILES['bukti_dana']['name'];

$type = pathinfo($filename, PATHINFO_EXTENSION);
$data = file_get_contents($file_bukti_temp);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$modifiedDate = date("Y-m-d H:i:s");
$batchIdArr = json_decode($_POST['batchid']);
(explode(",", $_POST['batchid']));

for ($i = 0; $i < count($batchIdArr); $i++) {
    $q = mssql_query("UPDATE pengembalian_dana_batch SET status_dana = '1', modified_date = '$modifiedDate', file_bukti_pengembalian_dana = '$base64', filename_bukti = '$filename'  WHERE batch_id = $batchIdArr[$i]");
}

echo "<script>window.alert('Update Status Pengembalian Dana Berhasil');
window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=pengembaliandana')
</script>";
