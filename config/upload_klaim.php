    <?php
    define('SITE_ROOT', dirname(__FILE__));

    include 'excel_reader2.php';
    include 'SpreadsheetReader.php';
    // include 'koneksi.php';
    include "fungsi_indotgl.php";
    include 'library.php';

    $target_dir = "\uploads/";
    $target_file = $target_dir . basename($_FILES['fileToUpload']['name']); //destination
    $uploadOk = 1;
    $file_excel = basename($_FILES['fileToUpload']['name']);
    $file_name = $_FILES['fileToUpload']['name'];
    $file_path = "uploads/" . $file_name;
    $FileType = pathinfo($target_file, PATHINFO_EXTENSION); //returns extension of file
    $bank_name = $_POST['bank'];
    $date = date("Y-m-d");
    $noRekeningRc = "";
    $nominalRc = "";
    $tglRekKoran = "";
    $rcId = 0;
    $remark = "";

    //koneksi DB AOS PROD sementara
    // $server     = "10.20.10.16";
    // $user         = "askrindo";
    // $password     = "p@ssw0rd";
    // $database     = "aos_kur_bri";
    // $db1 = mssql_connect($server, $user, $password, true);
    // mssql_select_db($database, $db1) or die("Database tidak ditemukan");

    //koneksi DB AOS DEV sementara
    $server2     = "10.20.10.16";
    $user2         = "askrindo";
    $password2     = "p@ssw0rd";
    $database2     = "aos_kur_bri_dev";
    $con2 = mssql_connect($server2, $user2, $password2, true);
    mssql_select_db($database2, $con2) or die("Database tidak ditemukan");

    //function query cabang
    function queryCabang($noRek, $con2)
    {
        return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $con2);
    }
    function queryCabang2($noRek, $con2)
    {
        return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = (SELECT top 1 no_rekening FROM pengajuan_spr_kur_gen2 WHERE no_rek_suplesi = '$noRek'
		UNION
		SELECT no_rekening FROM sp2_kur2015 WHERE no_rekening = '$noRek'))", $con2);
    }


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
        echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    } else if ($FileType != "xlsx") {
        echo "
        <script>
        alert('File yang di upload harus berextensi .xlsx');
        </script>
        ";
        echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    } else {
        // Build validation from directory
        $myfile = "test.xlsx";
        // $headerTable = array();
        $lenghtTable = array();
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
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file

            // ================================================== test =============================================
        } else {
            // upload file to db, for get id
            mssql_query("INSERT INTO file_rc VALUES('$file_name', '$date', NULL, '$bank_name', NULL, NULL, NULL, NULL, NULL, NULL, '0')", $con2);

            if ($file_excel) {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], SITE_ROOT . $target_file)) {
                    try {
                        $Spreadsheet = new SpreadsheetReader(SITE_ROOT . $target_file);
                        $BaseMem = memory_get_usage();

                        $Sheets = $Spreadsheet->Sheets();
                        // get id
                        $selectId =  mssql_query("SELECT id FROM file_rc WHERE documen_name = '$file_name'");
                        $getId = mssql_fetch_array($selectId);
                        $rcId = $getId['id'];

                        //count total record of file excel
                        foreach ($Sheets as $Index => $Name) {
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

                                    //if file excel match with template, insert data to file_rc_data
                                    if ($Key >= 10) {
                                        if ($Row) {
                                            if ($status == 1) {
                                                array_push($lenghtTable, $Row[2]);
                                                // $totalRecord = count($lenghtTable) - 2;
                                                // $num = (float)$Row[6];
                                                // $sum = $sum + $num;
                                                $remark = $Row[2];

                                                if (strpos($remark, 'BRISURF') !== false) {
                                                    $split = explode('_',  $remark);
                                                    $noRekeningRc = $split[3];
                                                } else if (strpos($remark, 'BRIJAMIN') !== false) {
                                                    $split = explode(' ',  $remark);
                                                    $split2 = explode('_', $split[0]);
                                                    $noRekeningRc = $split2[2];
                                                } else {
                                                    $noRekeningRc = null;
                                                }

                                                $nominalRc = $Row[6];
                                                $tglRekKoran = $Row[0];

                                                $queryCabang = queryCabang($noRekeningRc, $db1);
                                                $cabang = mssql_fetch_array($queryCabang);
                                                if ($cabang == NULL) {
                                                    $queryCabang2 = queryCabang2($noRekeningRc, $db1);
                                                    $cabang = mssql_fetch_array($queryCabang2);
                                                }
                                                $ktrCabang = $cabang['kantor'];
                                                $created_date = date("Y-m-d H:i:s");
                                                // $insertToDb = mssql_query("INSERT INTO file_rc_data VALUES('$file_name', '$noRekeningRc', '$nominalRc', '$tglRekKoran')");
                                                if ($nominalRc != 0) {
                                                    if (strpos($remark, 'BRISURF') !== false || strpos($remark, 'BRIJAMIN') !== false) {
                                                        if ($noRekeningRc != null) {
                                                            $insertToDb2 = mssql_query("INSERT INTO mapping_rc_bri VALUES('$rcId', NULL, '$noRekeningRc', '$nominalRc', '3', NULL, '$file_name', NULL, NULL, NULL, NULL,'$ktrCabang', '$tglRekKoran', NULL, '$remark', NULL, '$created_date', NULL, '0')", $con2);
                                                            $totalRecord = $totalRecord + 1;
                                                            $sum = $sum + $nominalRc;
                                                            // echo "INSERT INTO mapping_rc_bri VALUES('$rcId', NULL, '$noRekeningRc', '$nominalRc', '3', NULL, '$file_name', NULL, NULL, NULL, NULL,'$ktrCabang', '$tglRekKoran', NULL, '$remark')";

                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "
                                                    <script>
                                                    alert('file excel tidak sesuai');
                                                    </script>
                                                    ";
                                                mssql_query("DELETE FROM file_rc WHERE id = $rcId");
                                                unlink(SITE_ROOT . $target_file);
                                                echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
                                            }
                                        }
                                    }
                                }
                                $CurrentMem = memory_get_usage();
                            }
                        }

                        // save file rc excel to file_rc
                        if ($status == 1) {
                            echo "
                                <script>
                                alert('file berhasil di upload');
                                </script>
                                ";
                            $query = mssql_query("UPDATE file_rc SET total_record = '$totalRecord', total_amount = '$sum' WHERE id = '$rcId'", $con2);
                            echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
                        }
                    } catch (Exception $E) {
                        echo $E->getMessage();
                    }
                }
                // unlink(SITE_ROOT . $target_file);
            } else {
                echo "Sorry, there was an error uploading your file."; // this error arising in my program
            }
            // exit();
        }
    }




    // ================================================= test =============================================

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "
    //                 <script>
    //                 alert('file sudah ada');
    //                 </script>
    //                 ";
    //     $uploadOk = 0;
    // }
    // Check file size
    // if ($_FILES["fileToUpload"]["size"] > 50000000) {
    //     echo "
    //                 <script>
    //                 alert('ukuran file terlalu besar');
    //                 </script>
    //                 ";
    //     $uploadOk = 0;
    // }
    //checks whether file is excel or not
    //    if($FileType != "xlsx" ) {
    //        echo "
    //        <script>
    //        alert('harus upload file excel');
    //        </script>
    //        ";
    //        $status = 3;
    //        echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //    } if($FileType !="xls"){
    //         echo "
    //         <script>
    //         alert('harus upload file excel');
    //         </script>
    //         ";
    //         $status = 3;
    //         echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //    }
    // header("location:media.php?module=upload&status=" . $status);
    // header("Location:http://10.10.1.247:81/klaimbridev/media.php?module=upload&status=" . $status);


    //push data to database
    // foreach ($Sheets as $Index => $Name) {
    //     $Time = microtime(true);
    //     $Spreadsheet->ChangeSheet(14);
    //     foreach ($Spreadsheet as $Key => $Row) {
    //         if ($FileType == "xlsx") {
    //             if ($Key == 9) {
    //                 if ($Row) {
    //                     if ($Row == $headerTable) {
    //                         print_r($Row);
    //                         print_r($testArray);
    //                         if($Row == $testArray){
    //                             echo "headernya sama";
    //                         } else {
    //                             echo "header nya tidak sama";
    //                         }
    //                         // echo '<br>';
    //                         // print_r($headerTable);
    //                         // echo $date;
    //                         // echo $sum;
    //                         $status = 1;
    //                         echo "
    //                 <script>
    //                 alert('file berhasil di upload');
    //                 </script>
    //                 ";
    //                         $query = mssql_query("INSERT INTO file_rc VALUES('$file_name', '$date', NULL, '$bank_name', '$totalRecord', '$sum', NULL, NULL, NULL, NULL)");
    //                         echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //                     } else {
    //                         // print_r($Row);
    //                         echo '<br>';
    //                         // print_r($headerTable);
    //                         echo "
    //                 <script>
    //                 alert('file excel tidak sesuai');
    //                 </script>
    //                 ";
    //                         unlink(SITE_ROOT . $target_file);
    //                         echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //                     }
    //                 } else {
    //                     var_dump($Row[2]);
    //                     echo '<br>';
    //                 }
    //             }
    //         } else {
    //             if ($Key == 13) {
    //                 if ($Row) {
    //                     if ($Row == $headerTable) {

    //                         echo "
    //                 <script>
    //                 alert('file berhasil di upload');
    //                 </script>
    //                 ";
    //                         $query = mssql_query("INSERT INTO file_rc VALUES('$file_name', '$date', NULL, '$bank_name', '$totalRecord', $sum, 'no_bk', 'no_mm', NULL, NULL)");
    //                         echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //                     } else {
    //                         echo '<br>';
    //                         echo "
    //                 <script>
    //                 alert('file excel tidak sesuai');
    //                 </script>
    //                 ";
    //                         unlink(SITE_ROOT . $target_file);
    //                         echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=upload'</script>";
    //                     }
    //                 } else {
    //                     var_dump($Row[2]);
    //                     echo '<br>';
    //                 }
    //             }
    //         }
    //         $CurrentMem = memory_get_usage();
    //     }
    // }

    // ini buat baca header tabel template, kalau ga sama gajadi di olah
    // if ($myfile) {
    //     try {
    //         $Spreadsheet = new SpreadsheetReader($myfile);
    //         $BaseMem = memory_get_usage();

    //         $Sheets = $Spreadsheet->Sheets();
    //         foreach ($Sheets as $Index => $Name) {
    //             $Time = microtime(true);
    //             $Spreadsheet->ChangeSheet(14);
    //             foreach ($Spreadsheet as $Key => $Row) {

    //                 if ($Key == 9) {
    //                     if ($Row) {
    //                         // print_r($Row);
    //                         foreach ($Row as $a) {
    //                             array_push($headerTable, $a);
    //                         }
    //                         echo '<br>';
    //                     } else {
    //                         var_dump($Row);
    //                         // print_r($Row[6]);
    //                         echo '<br>';
    //                     }
    //                 }
    //                 $CurrentMem = memory_get_usage();
    //             }
    //         }
    //     } catch (Exception $E) {
    //         echo $E->getMessage();
    //     }
    // }

    ?>