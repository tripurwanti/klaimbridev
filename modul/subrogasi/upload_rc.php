<?php

include '../../config/excel_reader2.php';
include '../../config/SpreadsheetReader.php';
include '../../config/library.php';
include '../../config/koneksi_askred.php';

error_reporting(0);
define('SITE_ROOT', dirname(__FILE__));

function queryCabang($noRek, $db1)
{
    return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $db1);
}
function queryCabang2($noRek, $db1)
{
    return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = (SELECT top 1 no_rekening FROM pengajuan_spr_kur_gen2 WHERE no_rek_suplesi = '$noRek'
    UNION
    SELECT no_rekening FROM sp2_kur2015 WHERE no_rekening = '$noRek'))", $db1);
}

function querySubroFlag($noRekeningRc, $urutanTemp, $db1)
{
    return mssql_query("SELECT * FROM askred_subrogation_flag WHERE nomor_peserta = '" . $noRekeningRc . "' AND urutan_pengajuan_subrogasi =" . $urutanTemp, $db1);
}


$target_dir = "\upload/";
$target_file = $target_dir . basename($_FILES['fileToUpload']['name']); //destination
$uploadOk = 1;
$file_excel = basename($_FILES['fileToUpload']['name']);
$file_name = $_FILES['fileToUpload']['name'];
$file_path = "upload/" . $file_name;
$FileType = pathinfo($target_file, PATHINFO_EXTENSION); //returns extension of file
$bank_name = $_POST['bank'];
$date = date("Y-m-d");
$idFileRc = null;
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
    echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=subroUploadRC'</script>";
} else {
    if ($FileType != "xlsx") {
        echo "
        <script>
        alert('File yang di upload harus berextensi .xlsx');
        </script>
        ";
        echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=subroUploadRC'</script>";
    } else {
        // Build validation from directory
        $myfile = "test.xlsx";
        $headerTable = array();
        $lengthTable = array();
        $ListDataRC = array();
        $totalRecord = 0;
        $sum = 0;
        $status = 0;
        $headerTable = array(
            0 => 'DATE',
            1 => 'TIME',
            2 => 'REMARK',
            3 => '',
            4 => '',
            5 => '',
            6 => 'DEBET',
            7 => '',
            8 => '',
            9 => 'CREDIT',
            10 => '',
            11 => 'Ledger',
            12 => '',
            13 => '',
            14 => 'TELLER ID',
            15 => '',
            16 => '',
            17 => '',
            18 => '',
            19 => ''
        );

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // die("xxxxx: Sorry, your file was not uploaded.");
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file

            // ================================================== test =============================================
        } else {
            $noRekeningRc = null;
            $urutanTemp = null;
            if ($file_excel) {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], SITE_ROOT . $target_file)) {
                    $insertfileRC = mssql_query("INSERT INTO askred_file_rc_subrogasi
                                            (documen_name, upload_date, update_date, bank_name, status)
                                            VALUES('$file_name', '$created_date', NULL, 'BRI', '0')");


                    try {
                        $Spreadsheet = new SpreadsheetReader(SITE_ROOT . $target_file);
                        $BaseMem = memory_get_usage();

                        $Sheets = $Spreadsheet->Sheets();
                        $fileRCObj = mssql_query("SELECT TOP 1 * FROM askred_file_rc_subrogasi ORDER BY id DESC");
                        $dFileRCObj = mssql_fetch_array($fileRCObj);
                        $idFileRc =  $dFileRCObj['id'];
                        foreach ($Sheets as $Index => $Name) {
                            $headerTemp = null;
                            $Time = microtime(true);
                            $Spreadsheet->ChangeSheet(14);
                            foreach ($Spreadsheet as $Key => $Row) {

                                if ($FileType == "xlsx") {
                                    if ($Key == 9) {
                                        if ($Row) {
                                            if ($Row == $headerTable) {
                                                $status = 1;
                                            } else {
                                                $status = 0;
                                            }
                                        }
                                    }

                                    // if ($headerTemp == $headerTable) {
                                    if ($Key >= 10) {
                                        if ($Row) {
                                            if ($status == 1) {
                                                // echo $Row[2];
                                                if (!empty($Row[2])) {
                                                    $totalRecord++;
                                                }

                                                $num = (float)str_replace(',', '', $Row[6]);
                                                $sum = $sum + $num;
                                                // echo "totalRecord : " . $totalRecord;
                                                // echo "<br>";

                                                $split2 = explode('_', $Row[2]);
                                                $noRekeningRc = $split2[3];
                                                $urutanTemp = ltrim($split2[4], '0');
                                                $ktrCabang = NULL;

                                                $dateRC = str_replace('/', '-', $Row[0]);
                                                $dateTemp = explode("-", $dateRC);
                                                $dateRC = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
                                                $newDateRC =  date("Y-m-d H:i:s", strtotime($dateRC));
                                                $briFlagDate = NULL;

                                                if (strlen((string)$noRekeningRc) <= 16) {
                                                    $subroFlagObj = mssql_query("SELECT * FROM askred_subrogation_flag WHERE nomor_peserta = '" . $noRekeningRc . "' AND urutan_pengajuan_subrogasi =" . $urutanTemp);
                                                    $rSubroFlagObj =  mssql_num_rows($subroFlagObj);
                                                    $dSubroFlagObj = mssql_fetch_array($subroFlagObj);
                                                    $briFlagDate = $dSubroFlagObj['created_date'];
                                                    $queryCabang = queryCabang($noRekeningRc, $db1);
                                                    $cabang = mssql_fetch_array($queryCabang);
                                                    if ($cabang == NULL) {
                                                        $queryCabang2 = queryCabang2($noRekeningRc, $db1);
                                                        $cabang = mssql_fetch_array($queryCabang2);
                                                    }
                                                    $ktrCabang = $cabang['kantor'];
                                                    if ($rSubroFlagObj <= 0) {
                                                        $noRekeningRc = NULL;
                                                        $urutanTemp = NULL;
                                                        $ktrCabang = NULL;
                                                    }
                                                } else {
                                                    $noRekeningRc = NULL;
                                                    $urutanTemp = NULL;
                                                    $ktrCabang = NULL;
                                                }
                                                $created_date = date("Y-m-d H:i:s");
                                                mssql_query("INSERT INTO askred_mapping_rc_bri_subrogasi
                                                    (date_data_rc, 
                                                    remark, 
                                                    debet, 
                                                    credit, 
                                                    ledger, 
                                                    teller_id,
                                                    askrindo_branch, 
                                                    ismatch, 
                                                    create_date, 
                                                    update_date, 
                                                    correction_date, 
                                                    urutan_pengajuan,
                                                    nomor_rekening,
                                                    bri_flag_date, isposting, description,
                                                    id_file_rc)
                                                    VALUES('" . $newDateRC . "', 
                                                    '" . $Row[2] . "', 
                                                    " . str_replace(',', '', $Row[6]) . ", 
                                                    " . str_replace(',', '', $Row[9]) . ",  
                                                    " . str_replace(',', '', $Row[11]) . ", 
                                                    '" .  $Row[14] . "',
                                                    '" . $ktrCabang . "', 
                                                    '3', 
                                                    '" . $created_date . "',  
                                                    NULL, 
                                                    NULL, 
                                                    '" . $urutanTemp . "',
                                                    '" . $noRekeningRc . "',
                                                    '" . $briFlagDate . "','0', NULL,
                                                    " .  $idFileRc . ")");
                                            } else {
                                                unlink(SITE_ROOT . $target_file);
                                                mssql_query("DELETE FROM askred_file_rc_subrogasi  WHERE id = " . $idFileRc);
                                                echo "
                                                <script>
                                                alert('Format tidak sesuai');
                                                </script>";
                                                echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=subroUploadRC'</script>";
                                                exit;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        // $totalRecord = count($lengthTable) - 2;
                        // echo "total Record : " . $totalRecord;
                        // var_dump($lengthTable);
                        // $totalRecord = $totalRecord - 2;

                        mssql_query("UPDATE askred_file_rc_subrogasi SET total_record = " . $totalRecord . ", total_amount=" . $sum . " WHERE id=$idFileRc");
                        // echo "<br>";

                        // echo "UPDATE askred_file_rc_subrogasi
                        //             SET total_record =" . $totalRecord . ", total_amount=" . $sum . "
                        //            WHERE id=$idFileRc";
                        echo "
                        <script>
                        alert('file berhasil di upload');
                        </script>";
                        echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=subroUploadRC'</script>";
                    } catch (Exception $E) {
                        echo $E->getMessage();
                    }
                }
                // unlink(SITE_ROOT . $target_file);
            } else {
                // die(" xxxxx: Sorry, there was an error uploading your file");
                echo "Sorry, there was an error uploading your file."; // this error arising in my program
                // }
            }
            // exit();
        }
    }
}