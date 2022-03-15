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
$tipeDokSphKtp = pathinfo($filenameDokKtp, PATHINFO_EXTENSION);
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

$filenameDokAdditional = pathinfo($_FILES['dok_additional']['name'], PATHINFO_FILENAME);
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
$target_file_lkn = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameLkn . ".pdf"; //destination
$target_file_sph = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameSph . ".pdf"; //destination
$target_file_ktp = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameKtp . "." . $tipeDokSphKtp; //destination
$target_file_slik = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameSlik . ".pdf"; //destination
$target_file_sku = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameSku . ".pdf"; //destination
$target_file_rc = SITE_ROOT . $target_dir . $nomorRekening . "/" . $targetfilenameRc . ".pdf"; //destination
// $target_file_additional = $target_dir . $nomorRekening . "/" . $targetfilenameAdditional . ".pdf"; //destination
$target_file_additional = SITE_ROOT . $target_dir . $nomorRekening . "/" . $filenameDokAdditional . ".pdf";; //destination

$destinationFtpDirSph = "/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf";
$destinationFtpDirLkn = "/" . $nomorRekening . "/" . $targetfilenameLkn . ".pdf";
$destinationFtpDirKtp = "/" . $nomorRekening . "/" . $targetfilenameKtp . "." . $tipeDokSphKtp;
$destinationFtpDirSlik = "/" . $nomorRekening . "/" . $targetfilenameSlik . ".pdf";
$destinationFtpDirSku = "/" . $nomorRekening . "/" . $targetfilenameSku . ".pdf";
$destinationFtpDirRc = "/" . $nomorRekening . "/" . $targetfilenameRc . ".pdf";
// $destinationFtpDirAdditional = "/" . $nomorRekening . "/" . $targetfilenameAdditional . ".pdf";
$destinationFtpDirAdditional = "/" . $nomorRekening . "/" .  $filenameDokAdditional . ".pdf";;

$dir_ftp =  "/DEV\/" . $nomorRekening . "/";
$dir =  SITE_ROOT . $target_dir . $nomorRekening;
$rootdir = "klaimbridevwanti/klaimbridev";
// echo $dir;
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
    if (!empty($_FILES['dok_lkn']['tmp_name'])) {
        if (move_uploaded_file($filenameDokLkn_temp, $target_file_lkn)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameLkn . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameLkn . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = '" . $targetfilenameLkn . "'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'lkn' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                      (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                       VALUES('" . $nomorRekening . "', 'lkn', '" . $targetfilenameLkn . "', 'portal', '" . $dir_ftp .  $targetfilenameLkn . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }

                if ($result == "") {
                    $result = "Dokumen LKN sukses di upload";
                } else {
                    $result = $result . ", Dokumen LKN sukses di upload";
                }
                unlink($target_file_lkn);
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
    }

    if (!empty($_FILES['dok_sph']['tmp_name'])) {
        if (move_uploaded_file($filenameDokSph_temp, $target_file_sph)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSph . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameSph . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = '" . $targetfilenameSph . "'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'sph' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                    (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                     VALUES('" . $nomorRekening . "', 'sph', '" . $targetfilenameSph . "', 'portal', '" . $dir_ftp .  $targetfilenameSph . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "Dokumen SPH sukses di upload";
                } else {
                    $result = $result . ", Dokumen SPH sukses di upload";
                }
                unlink($target_file_sph);
            } else {
                if ($result == "") {
                    $result = "Dokumen SPH gagal di upload";
                } else {
                    $result = $result . ", Dokumen SPH gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "Dokumen SPH gagal di upload (local)";
            } else {
                $result = $result . ", Dokumen SPH gagal di upload (local)";
            }
        }
    }

    if (!empty($_FILES['ktp']['tmp_name'])) {
        if (move_uploaded_file($filenameDokKtp_temp,  $target_file_ktp)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameKtp . "." . $tipeDokSphKtp, "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/" . $nomorRekening . "/" . $targetfilenameKtp . "." . $tipeDokSphKtp, FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = '" . $targetfilenameKtp . "'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "', path_local_dokumen = '" . $dir_ftp .  $targetfilenameKtp . "." . $tipeDokSphKtp . "', tipe_dokumen = '" . $tipeDokSphKtp . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'ktp' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                  (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                   VALUES('" . $nomorRekening . "', 'ktp', '" . $targetfilenameKtp . "', 'portal', '" . $dir_ftp .  $targetfilenameKtp . "." . $tipeDokSphKtp . "', '" . $tipeDokSphKtp . "', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "KTP sukses di upload";
                } else {
                    $result = $result . ", KTP sukses di upload";
                }
                unlink($target_file_ktp);
            } else {
                if ($result == "") {
                    $result = "KTP gagal di upload";
                } else {
                    $result = $result . ", KTP gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "KTP gagal di upload (local) " . $tipeDokSphKtp;
            } else {
                $result = $result . ", KTP gagal di upload (local)";
            }
        }
    }

    if (!empty($_FILES['dok_slik']['tmp_name'])) {
        if (move_uploaded_file($filenameDokSlik_temp,  $target_file_slik)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSlik . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
                . $nomorRekening . "/" . $targetfilenameSlik . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = '" . $targetfilenameSlik . "'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {

                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'slik' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                      (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                       VALUES('" . $nomorRekening . "', 'slik', '" . $targetfilenameSlik . "', 'portal', '" . $dir_ftp .  $targetfilenameSlik . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "Dokumen SLIK sukses di upload";
                } else {
                    $result = $result . ", Dokumen SLIK sukses di upload";
                }
                unlink($target_file_slik);
            } else {
                if ($result == "") {
                    $result = "Dokumen SLIK gagal di upload";
                } else {
                    $result = $result . ", Dokumen SLIK gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "Dokumen SLIK gagal di upload (local)";
            } else {
                $result = $result . ", Dokumen SLIK gagal di upload (local)";
            }
        }
    }

    if (!empty($_FILES['dok_sku']['tmp_name'])) {
        if (move_uploaded_file($filenameDokSku_temp, $target_file_sku)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameSku . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
                . $nomorRekening . "/" . $targetfilenameSku . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'data_usaha'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'data_usaha' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                      (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                       VALUES('" . $nomorRekening . "', 'data_usaha', '" . $targetfilenameSku . "', 'portal', '" . $dir_ftp .  $targetfilenameSku . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "Dokumen SKU sukses di upload";
                } else {
                    $result = $result . ", Dokumen SKU sukses di upload";
                }
                unlink($target_file_sku);
            } else {
                if ($result == "") {
                    $result = "Dokumen SKU gagal di upload";
                } else {
                    $result = $result . ", Dokumen SKU gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "Dokumen SKU gagal di upload (local)";
            } else {
                $result = $result . ", Dokumen SKU gagal di upload (local)";
            }
        }
    }

    if (!empty($_FILES['dok_rc']['tmp_name'])) {
        if (move_uploaded_file($filenameDokRC_temp,  $target_file_rc)) {
            $upload = ftp_put($conn, $dir_ftp .  $targetfilenameRc . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
                . $nomorRekening . "/" . $targetfilenameRc . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = '" . $targetfilenameRc . "'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);
                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'rc' ;
                    ", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                      (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                       VALUES('" . $nomorRekening . "', 'rc', '" . $targetfilenameRc . "', 'portal', '" . $dir_ftp .  $targetfilenameRc . ".pdf" . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "Dokumen RC sukses di upload";
                } else {
                    $result = $result . ", Dokumen RC sukses di upload";
                }
                unlink($target_file_rc);
            } else {
                if ($result == "") {
                    $result = "Dokumen RC gagal di upload";
                } else {
                    $result = $result . ", Dokumen RC gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "Dokumen RC gagal di upload (local)";
            } else {
                $result = $result . ", Dokumen RC gagal di upload (local)";
            }
        }
    }

    if (!empty($_FILES['dok_additional']['tmp_name'])) {
        if (move_uploaded_file($filenameDokAdditional_temp, $target_file_additional)) {
            $upload = ftp_put($conn, $dir_ftp .  $filenameDokAdditional . ".pdf", "C:/xamppx/htdocs/" . $rootdir . "/modul/pengajuanclaim/upload/"
                . $nomorRekening . "/" . $filenameDokAdditional . ".pdf", FTP_BINARY);
            if ($upload) {
                $cekDokInfo =  mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'additional'", $con);
                $rcekDokInfo = mssql_fetch_array($cekDokInfo);

                $created_date = date("Y-m-d H:i:s");
                if ($rcekDokInfo > 0) {
                    $sql = mssql_query("UPDATE askred_dokumen_info
                    SET modified_date='" . $created_date . "', file_name = '" . $filenameDokAdditional . "', path_local_dokumen = '" . $dir_ftp .  $filenameDokAdditional . ".pdf" . "', 
                    url_dokumen = 'portal/" . $targetfilenameAdditional . "'
                    WHERE no_rekening_pinjaman='" . $nomorRekening . "' AND kode_dokumen = 'additional'", $con);
                } else {
                    $sql = mssql_query("INSERT INTO askred_dokumen_info
                                      (no_rekening_pinjaman, kode_dokumen, file_name, url_dokumen, path_local_dokumen, tipe_dokumen, created_date, modified_date, external_id)
                                       VALUES('" . $nomorRekening . "', 'additional', '" . $filenameDokAdditional . "', 'portal/" . $targetfilenameAdditional . "', '" . $dir_ftp .  $filenameDokAdditional . "', 'pdf', '" . $created_date . "', NULL, '-')", $con);
                }
                if ($result == "") {
                    $result = "Dokumen " . $targetfilenameAdditional . " sukses di uploadssss" . "";
                } else {
                    $result = $result . ", Dokumen " . $targetfilenameAdditional . " sukses di uploadssss";
                }
                unlink($target_file_additional);
            } else {
                if ($result == "") {
                    $result = "Dokumen " . $targetfilenameAdditional . " gagal di upload";
                } else {
                    $result = $result . ", Dokumen " . $targetfilenameAdditional . " gagal di upload";
                }
            }
        } else {
            if ($result == "") {
                $result = "Dokumen " . $targetfilenameAdditional . " gagal di upload (local)";
            } else {
                $result = $result . ", Dokumen " . $targetfilenameAdditional . " gagal di upload (local)";
            }
        }
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