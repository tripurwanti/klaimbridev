<?php

include '../../config/excel_reader2.php';
include '../../config/SpreadsheetReader.php';
include '../../config/library.php';
include '../../config/koneksi_askred.php';
// include "subroModel.php";

error_reporting(0);
define('SITE_ROOT', dirname(__FILE__));

$target_dir = "\upload/";
$target_file = $target_dir . basename($_FILES['fileToUpload']['name']); //destination
$uploadOk = 1;
$file_excel = basename($_FILES['fileToUpload']['name']);
$file_name = $_FILES['fileToUpload']['name'];
$file_path = "upload/" . $file_name;
$FileType = pathinfo($target_file, PATHINFO_EXTENSION); //returns extension of file
$bank_name = $_POST['bank'];
$date = date("Y-m-d");
$lengthTable = array();

// coba jalankan
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
}

if (file_exists($file_path)) {
    echo "
        <script>
        alert('file sudah pernah di upload');
        </script>
        ";
    echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=claimUploadRC'</script>";
} else {
    // Build validation from directory
    $myfile = "test.xlsx";
    $headerTable = array();
    $lengthTable = array();
    $ListDataRC = array();
    $totalRecord = 0;
    $sum = 0;
    $status = 0;
    $created_date = date("Y-m-d H:i:s");

    if ($myfile) {
        try {
            $Spreadsheet = new SpreadsheetReader($myfile);
            $BaseMem = memory_get_usage();

            $Sheets = $Spreadsheet->Sheets();
            foreach ($Sheets as $Index => $Name) {
                $Time = microtime(true);
                $Spreadsheet->ChangeSheet(14);
                foreach ($Spreadsheet as $Key => $Row) {

                    if ($Key == 9) {
                        if ($Row) {
                            foreach ($Row as $a) {
                                array_push($headerTable, $a);
                            }
                        } else {
                            var_dump($Row);
                        }
                    }
                    $CurrentMem = memory_get_usage();
                }
            }
        } catch (Exception $E) {
            echo $E->getMessage();
        }
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if ($file_excel) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], SITE_ROOT . $target_file)) {


                try {
                    $Spreadsheet = new SpreadsheetReader(SITE_ROOT . $target_file);
                    $BaseMem = memory_get_usage();

                    $Sheets = $Spreadsheet->Sheets();

                    foreach ($Sheets as $Index => $Name) {
                        $headerTemp = null;
                        $Time = microtime(true);
                        $Spreadsheet->ChangeSheet(14);
                        foreach ($Spreadsheet as $Key => $Row) {
                            if ($FileType == "xlsx") {
                                if ($Key == 9) {
                                    $headerTemp = $Row;
                                };
                                if ($Key >= 10) {
                                    array_push($lengthTable, $Row[2]);
//                                    $ListDataRC[] = array(
//                                        'dateDataRC' => $Row[0],
//                                        'remark' =>  $Row[2],
//                                        'debet' =>  $Row[6],
//                                        'credit' =>  $Row[9],
//                                        'ledger' => $Row[11],
//                                        'teller_id' => $Row[14]
//                                    );
                                    $totalRecord = count($lengthTable) - 2;
                                    $num = (float)$Row[6];
                                    $sum = $sum + $num;

                                    // var_dump($ListDataRC);
                                }
                            }
                        }
                    }
                    $insertfileRC = mssql_query("INSERT INTO askred_file_rc_claim
                    (documen_name, upload_date, update_date, bank_name, total_record, total_amount)
                    VALUES('$file_name', '$created_date', NULL, 'BRI', $totalRecord, $sum)");

//                    $remarkDB = array();
//
//                    $listDataSubroFlag = mssql_query("SELECT * FROM askred_claim_confirmation WHERE status_klaim = 1 AND remark is not NULL");
//                    $rListDataSubroFlag = mssql_num_rows($listDataSubroFlag);
//                    $dListDataSubroFlag = mssql_fetch_array($listDataSubroFlag);
//
//                    while ($dq = mssql_fetch_array($listDataSubroFlag)) {
//                        array_push($remarkDB, $dq['remark']);
//                    }
//                    $datafileRC = mssql_query("SELECT TOP 1 * FROM skred_file_rc_claim ORDER BY upload_date DESC");
//                    $dDatafileRC = mssql_fetch_array($datafileRC);
//                    $ismatch = NULL;
//
//                    for ($i = 0; $i < count($ListDataRC); $i++) {
//                        $dateRC = str_replace('/', '-', $ListDataRC[$i]['dateDataRC']);
//                        $dateTemp = explode("-", $dateRC);
//                        $dateRC = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
//                        $newDateRC =  date("Y-m-d H:i:s", strtotime($dateRC));
//
//                        $cekDataMatch = mssql_query("SELECT * FROM askred_claim_confirmation WHERE status_klaim = 1 AND remark ='" . $ListDataRC[$i]['remark'] . "'");
//                        $rCekDataMatch = mssql_num_rows($cekDataMatch);
//
//                        $cekDataRCDouble = mssql_query("SELECT * FROM askred_mapping_rc_bri_claim WHERE remark = '" . $ListDataRC[$i]['remark'] . "'");
//                        $rCekDataRCDouble = mssql_num_rows($cekDataRCDouble);
//
//                        if ($rCekDataMatch > 0) {
//                            if ($rCekDataRCDouble > 0) {
//                                $ismatch = 2;
//                                mssql_query("UPDATE asf
//                                            SET asf.is_match = '2'
//                                            from askred_claim_feedback asf,  askred_claim_confirmation asv
//                                            WHERE asf.nomor_peserta = asv.nomor_peserta
//                                            AND asf.urutan_pengajuan = asv.urutan_pengajuan
//                                            AND asv.remark = '" . $ListDataRC[$i]['remark'] . "'");
//                            } else {
//                                $ismatch = 1;
//                                mssql_query("UPDATE asf
//                                            SET asf.is_match = '1'
//                                            from askred_claim_feedback asf, askred_claim_confirmation asv
//                                            WHERE asf.nomor_peserta = asv.nomor_peserta
//                                            AND asf.urutan_pengajuan  = asv.urutan_pengajuan
//                                            AND asv.remark = '" . $ListDataRC[$i]['remark'] . "'");
//                            }
//                        } else {
//                            $ismatch = 0;
//                        }
//
//                        mssql_query("INSERT INTO askred_mapping_rc_bri_claim
//                                    (date_data_rc,
//                                    remark, debet,
//                                    credit,
//                                    ledger,
//                                    teller_id,
//                                    askrindo_branch,
//                                    ismatch,
//                                    create_date,
//                                    update_date,
//                                    correction_date,
//                                    id_file_rc)
//                                    VALUES('" . $newDateRC . "',
//                                    '" . $ListDataRC[$i]['remark'] . "',
//                                    " . $ListDataRC[$i]['debet'] . ",
//                                    " . $ListDataRC[$i]['credit'] . ",
//                                    " . $ListDataRC[$i]['ledger'] . ",
//                                    '" . $ListDataRC[$i]['teller_id'] . "',
//                                    'ASKRINDO_KCU',
//                                    " . $ismatch . ",
//                                    '" . $created_date . "',
//                                    NULL,
//                                    NULL,
//                                    " . $dDatafileRC['id'] . ")");
//                    }

                    echo "
                        <script>
                        alert('file berhasil di upload');
                        </script>";
                    echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=claimUploadRC'</script>";
                } catch (Exception $E) {
                    echo $E->getMessage();
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file."; // this error arising in my program
        }
    }
}