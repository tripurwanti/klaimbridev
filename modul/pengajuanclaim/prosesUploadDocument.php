<?php
error_reporting(0);
define('SITE_ROOT', dirname(__FILE__));
date_default_timezone_set('Asia/Jakarta');

include '../../config/koneksi_askred.php';

$nomorRekening = $_POST['no_rekening_pinjaman'];
$hostFtp = "10.20.10.16";
$userFtp = "ask-bri";
$passFtp = "Askrindo123";

//mengambil data gambar dan menyimpannya kedalam variabel
$filenameDokLkn = $_FILES['dok_lkn']['name'];
$sizeDokLkn = $_FILES['dok_lkn']['size'];
$tipeDokLkn = $_FILES['dok_lkn']['type'];
$filenameDokLkn_temp = $_FILES['dok_lkn']['tmp_name'];

$filenameDokSph = $_FILES['dok_sph']['name'];
$sizeDokSph = $_FILES['dok_sph']['size'];
$tipeDokSph = $_FILES['dok_sph']['type'];
$filenameDokSph_temp = $_FILES['dok_sph']['tmp_name'];

$filenameDokKtp = $_FILES['ktp']['name'];
$sizeDokSphKtp = $_FILES['ktp']['size'];
$tipeDokSphKtp = $_FILES['ktp']['type'];
$filenameDokKtp_temp = $_FILES['ktp']['tmp_name'];

$filenameDokSlik = $_FILES['dok_slik']['name'];
$sizeDokSphSlik = $_FILES['dok_slik']['size'];
$tipeDokSphSlik = $_FILES['dok_slik']['type'];
$filenameDokSlik_temp = $_FILES['dok_slik']['tmp_name'];

$filenameDokSku = $_FILES['dok_sku']['name'];
$sizeDokSphSku = $_FILES['dok_sku']['size'];
$tipeDokSphSku = $_FILES['dok_sku']['type'];
$filenameDokSku_temp = $_FILES['dok_sku']['tmp_name'];

$filenameDokRC = $_FILES['dok_rc']['name'];
$sizeDokSphRC = $_FILES['dok_rc']['size'];
$tipeDokSphRC = $_FILES['dok_rc']['type'];
$filenameDokRC_temp = $_FILES['dok_rc']['tmp_name'];

$filenameDokAdditional = $_FILES['dok_additional']['name'];
$sizeDokSphAdditional = $_FILES['dok_additional']['size'];
$tipeDokSphAdditional = $_FILES['dok_additional']['type'];
$filenameDokAdditional_temp = $_FILES['dok_additional']['tmp_name'];



$targetfilenameLkn = "lkn";
$targetfilenameSph = "sph";
$targetfilenameKtp = "ktp";
$targetfilenameSlik = "slik";
$targetfilenameSku = "sku";
$targetfilenameRc = "rc";
$targetfilenameAdditional = $_POST['dokumenname'];

$target_dir = "\upload/";
$target_file_lkn = $target_dir . $nomorRekening . "/" . $targetfilenameLkn . ".pdf"; //destination
$target_file_sph = $target_dir . $nomorRekening . "/" . $targetfilenameSph . ".pdf"; //destination
$target_file_ktp = $target_dir . $nomorRekening . "/" . $targetfilenameKtp . ".pdf"; //destination
$target_file_slik = $target_dir . $nomorRekening . "/" . $targetfilenameSlik . ".pdf"; //destination
$target_file_sku = $target_dir . $nomorRekening . "/" . $targetfilenameSku . ".pdf"; //destination
$target_file_rc = $target_dir . $nomorRekening . "/" . $targetfilenameRc . ".pdf"; //destination
$target_file_additional = $target_dir . $nomorRekening . "/" . $targetfilenameAdditional . ".pdf"; //destination

$destinationFtpDirSph = "/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf";
$destinationFtpDirLkn = "/" . $nomorRekening . "/" . $targetfilenameLkn . ".pdf";
$destinationFtpDirKtp = "/" . $nomorRekening . "/" . $targetfilenameKtp . ".pdf";
$destinationFtpDirSlik = "/" . $nomorRekening . "/" . $targetfilenameSlik . ".pdf";
$destinationFtpDirSku = "/" . $nomorRekening . "/" . $targetfilenameSku . ".pdf";
$destinationFtpDirRc = "/" . $nomorRekening . "/" . $targetfilenameRc . ".pdf";
$destinationFtpDirAdditional = "/" . $nomorRekening . "/" . $targetfilenameAdditional . ".pdf";

$dir_ftp =  "/DEV\/" . $nomorRekening . "/";
$dir =  SITE_ROOT . $target_dir . $nomorRekening;
$rootdir = "klaimbridev";

if (!file_exists($dir) && !is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$conn = ftp_connect($hostFtp) or die("Cannot initiate connection to host");
ftp_login($conn, $userFtp, $passFtp) or die("Cannot login");

ftp_pasv($conn, true) or die("Unable switch to passive mode");
$created_date = null;
$upload = null;
$sql = null;
$result = "";

if (ftp_mkdir($conn, $dir_ftp) || !ftp_mkdir($conn, $dir_ftp)) {
    if (move_uploaded_file($filenameDokLkn_temp, SITE_ROOT . $target_file_lkn)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameLkn . ".", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameLkn . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'lkn', '" . $targetfilenameLkn . "', 'portal', '" . $dir_ftp .  $targetfilenameLkn . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            if ($result == "") {
                $result = "Dokumen LKN sukses di upload";
            } else {
                $result = $result . ", Dokumen LKN sukses di upload";
            }
        } else {
            if ($result == "") {
                $result = "Dokumen LKN gagal di upload";
            } else {
                $result = $result . ", Dokumen LKN gagal di upload";
            }
        }
    } else {
        if ($result == "") {
            $result = "Dokumen LKN gagal di upload (local)";
        } else {
            $result = $result . ", Dokumen LKN gagal di upload (local)";
        }
    }
    if (move_uploaded_file($filenameDokSph_temp, SITE_ROOT . $target_file_sph)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSph . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'sph', '" . $targetfilenameSph . "', 'portal', '" . $dir_ftp .  $targetfilenameSph . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            if ($result == "") {
                $result = "Dokumen SPH sukses di upload";
            } else {
                $result = $result . ", Dokumen SPH sukses di upload";
            }
        }
        //     else {
        //         $result = "Dokumen SPH gagal di upload";
        //     }
        // } else {
        //     $result = "Dokumen SPH gagal di upload";
    }



    if (move_uploaded_file($filenameDokKtp_temp, SITE_ROOT . $target_file_ktp)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameKtp . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameKtp . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'ktp', '" . $targetfilenameKtp . "', 'portal', '" . $dir_ftp .  $targetfilenameKtp . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            if ($result == "") {
                $result = "KTP sukses di upload";
            } else {
                $result = $result . ", KTP sukses di upload";
            }
        }
        //     else {
        //         $result += ", KTP gagal di upload";
        //     }
        // } else {
        //     $result += ", KTP gagal di upload";
    }

    if (move_uploaded_file($filenameDokSlik_temp, SITE_ROOT . $target_file_slik)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSlik . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
            . $nomorRekening . "/" . $targetfilenameSlik . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'slik', '" . $targetfilenameSlik . "', 'portal', '" . $dir_ftp .  $targetfilenameSlik . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            if ($result == "") {
                $result = "Dokumen SLIK sukses di upload";
            } else {
                $result = $result . ", Dokumen SLIK sukses di upload";
            }
        }
        //     else {
        //         $result += ", Dokumen SLIK gagal di upload";
        //     }
        // } else {
        //     $result += ", Dokumen SLIK gagal di upload";
    }

    if (move_uploaded_file($filenameDokSku_temp, SITE_ROOT . $target_file_sku)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSku . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
            . $nomorRekening . "/" . $targetfilenameSku . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'data_usaha', '" . $targetfilenameSku . "', 'portal', '" . $dir_ftp .  $targetfilenameSku . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            $result = $result . ", Dokumen SKU sukses di upload";
        }
        //     else {
        //         $result += ", Dokumen SKU gagal di upload";
        //     }
        // } else {
        //     $result += ", Dokumen SKU gagal di upload";
    }

    if (move_uploaded_file($filenameDokRC_temp, SITE_ROOT . $target_file_rc)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameRc . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
            . $nomorRekening . "/" . $targetfilenameRc . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'rc', '" . $targetfilenameRc . "', 'portal', '" . $dir_ftp .  $targetfilenameRc . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            $result = $result . ", Dokumen RC sukses di upload";
        }
        //     else {
        //         $result += ", Dokumen RC gagal di upload";
        //     }
        // } else {
        //     $result += ", Dokumen RC gagal di upload";
    }

    if (move_uploaded_file($filenameDokAdditional_temp, SITE_ROOT . $target_file_additional)) {
        $upload = ftp_put($conn, $dir_ftp .  $targetfilenameAdditional . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
            . $nomorRekening . "/" . $targetfilenameAdditional . ".pdf", FTP_BINARY);
        if ($upload) {
            $created_date = date("Y-m-d H:i:s");
            $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'additional', '" . $targetfilenameAdditional . "', 'portal', '" . $dir_ftp .  $targetfilenameAdditional . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
            $result = $result . ", Dokumen " + $targetfilenameAdditional + " sukses di upload";
        }

        //     else {

        //         $result += ", Dokumen " + $targetfilenameAdditional + " gagal di upload";
        //     }
        // } else {

        //     $result += ", Dokumen " + $targetfilenameAdditional + " gagal di upload";
    }
    // echo $result;
    echo "<script>
            alert('" . $result . "');
            </script>";
    echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
    // exit;
}






// =================================================================== upload 2 file lkn dan sph =======================================================================================

// if ($tipeDokLkn == "application/pdf") {
//     if ($tipeDokSph == "application/pdf") {
//         if ($sizeDokLkn <= 1000000) {
//             if ($sizeDokSph  <= 1000000) {
//                 if (move_uploaded_file($filenameDokLkn_temp, SITE_ROOT . $target_file_lkn)) {
//                     if (move_uploaded_file($filenameDokSph_temp, SITE_ROOT . $target_file_sph)) {
//                         $conn = ftp_connect($hostFtp) or die("Cannot initiate connection to host");
//                         ftp_login($conn, $userFtp, $passFtp) or die("Cannot login");

//                         ftp_pasv($conn, true) or die("Unable switch to passive mode");

//                         if (ftp_mkdir($conn, $dir_ftp)) {
//                             $uploadSph = ftp_put($conn, $dir_ftp .  $targetfilenameSph . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf", FTP_BINARY);
//                             $uploadLkn = ftp_put($conn, $dir_ftp . $targetfilenameLkn . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" .  $targetfilenameLkn . ".pdf", FTP_BINARY);

//                             if ($uploadSph) {
//                                 if ($uploadLkn) {
//                                     $created_date_sph = date("Y-m-d H:i:s");
//                                     $sqlsph = mssql_query("INSERT INTO askred_dokumen_info
//                                     (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
//                                     VALUES('" . $nomorRekening . "', 'sph', '" . $targetfilenameSph . "', 'portal', '" . $destinationFtpDirSph . "', 'pdf', '" . $created_date_sph . "', NULL, '-')", $con);
//                                     $created_date_lkn = date("Y-m-d H:i:s");
//                                     $sqllkn = mssql_query("INSERT INTO askred_dokumen_info
//                                     (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
//                                     VALUES('" . $nomorRekening . "', 'lkn', '" . $targetfilenameLkn . "', 'portal', '" . $destinationFtpDirLkn . "', 'pdf', '" . $created_date_lkn . "', NULL, '-')", $con);
//                                     if ($sqllkn && $sqlsph) {
//                                         echo "<script>
//                                     alert('File Berhasil di Upload');
//                                     </script>";
//                                         echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                         exit;
//                                     }
//                                 } else {
//                                     echo "<script>
//                                 alert('Maaf, File gagal untuk diupload.1');
//                                 </script>";
//                                     echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                     exit;
//                                 }
//                             } else {
//                                 echo "<script>
//                             alert('Maaf, File gagal untuk diupload.2');
//                             </script>";
//                                 echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                 exit;
//                             }
//                         } else {
//                             $uploadSph = ftp_put($conn, $dir_ftp .  $targetfilenameSph . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf", FTP_BINARY);
//                             $uploadLkn = ftp_put($conn, $dir_ftp . $targetfilenameLkn . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" .  $targetfilenameLkn . ".pdf", FTP_BINARY);

//                             if ($uploadSph) {
//                                 if ($uploadLkn) {
//                                     $created_date_sph = date("Y-m-d H:i:s");
//                                     $sqlsph = mssql_query("INSERT INTO askred_dokumen_info
//                                 (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
//                                 VALUES('" . $nomorRekening . "', 'sph', '" . $targetfilenameSph . "', 'portal', '" . $destinationFtpDirSph . "', 'pdf', '" . $created_date_sph . "', NULL, '-')", $con);
//                                     $created_date_lkn = date("Y-m-d H:i:s");
//                                     $sqllkn = mssql_query("INSERT INTO askred_dokumen_info
//                                 (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
//                                 VALUES('" . $nomorRekening . "', 'lkn', '" . $targetfilenameLkn . "', 'portal', '" . $destinationFtpDirLkn . "', 'pdf', '" . $created_date_lkn . "', NULL, '-')", $con);
//                                     if ($sqllkn && $sqlsph) {
//                                         echo "<script>
//                                         alert('File Berhasil di Upload');
//                                         </script>";
//                                         echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                         exit;
//                                     }
//                                 } else {
//                                     echo "<script>
//                                     alert('Maaf, File gagal untuk diupload.1');
//                                     </script>";
//                                     echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                     exit;
//                                 }
//                                 ftp_close($conn);
//                             } else {
//                                 echo "<script>
//                                 alert('Maaf, File gagal untuk diupload.2');
//                                 </script>";
//                                 echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                                 exit;
//                             }
//                         }
//                     } else {
//                         unlink(SITE_ROOT . $target_file_lkn);

//                         echo "<script>
//                         alert('Maaf, File gagal untuk diupload.3');
//                         </script>";
//                         echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                         exit;
//                     }
//                 } else {
//                     echo "<script>
//                     alert('Maaf, File gagal untuk diupload.4');
//                     </script>";
//                     echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                     exit;
//                 }
//             } else {
//                 echo "<script>
//                 alert('Maaf, Ukuran Dokumen SPH yang diupload tidak boleh lebih dari 10MB');
//                 </script>";
//                 echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//                 exit;
//             }
//         } else {
//             echo "<script>
//             alert('Maaf, Ukuran Dokumen SPH yang diupload tidak boleh lebih dari 10MB');
//             </script>";
//             echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//             exit;
//         }
//     } else {
//         echo "<script>
//         alert('Maaf, Tipe Dokumen SPH yang diupload harus pdf');
//         </script>";
//         echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//         exit;
//     }
// } else {
//     echo "<script>
//     alert('Maaf, Tipe Dokumen LKN yang diupload harus ');
//     </script>";
//     echo "<script>window.location.href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi'</script>";
//     exit;
// }