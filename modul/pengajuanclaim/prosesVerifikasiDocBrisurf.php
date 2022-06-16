<?php
error_reporting(0);
include "../../config/koneksi.php";
// include "../../config/koneksi_askred.php";
// $server = "10.20.10.16";
// $username = "askrindo";
// $password = "p@ssw0rd";
// $database = "ASKRINDO_BRI_DEV";

// // Koneksi dan memilih database di server
// $con2 = mssql_connect($server, $username, $password);
// mssql_select_db($database, $con) or die("Database tidak ditemukan");

$rootdir = "klaimbridevwanti/klaimbridev";
$ceklis = 0;
$ceklistdklengkap = 0;

/* Tunggu UAT! */
$dateRekamGx = date("Y-m-d H:i:s");
$tahun         = substr($_POST['tgl_mulai'], 0, 4);
$plafond    = $_POST['plafond'];
$plafondx    = number_format($plafond, 2, ",", ".");
$banyak_dok    = $_POST['banyak_dokumen'];
$norekPinjaman = $_POST['no_fasilitas'];

//inquiry data claim 
$url = 'localhost:8081/api/claim/inquiryClaim';
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);

$payload = json_encode(array("nomorPeserta" => $norekPinjaman));
if ($payload) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
}
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

$resultcurl = curl_exec($curl);
curl_close($curl);

$result = json_decode($resultcurl, true);
if($result['dataClaim'][0]['claimStatus'] == 7){
    moveDataClaimToHistory($norekPinjaman);
    echo "<script>window.alert('Status claim : " .$result['dataClaim'][0]['claimStatusDesc']. ". Data telah dibatalkan, mohon cek menu batal klaim');
    </script>";
    exit;
}

//move data pengajuam claim kur gen 2 to table history
function moveDataClaimToHistory($noRekening){
    $url = 'localhost:8081/api/claim/moveDataClaim';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);

    $payload = json_encode(array("nomorPeserta" => $noRekening));
    if ($payload) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // EXECUTE:
    $resultcurl = curl_exec($curl);
    // if (!$resultcurl) {
    //     die("Connection Failure");
    // }
    curl_close($curl);
}

session_start();
if (isset($_POST['doklengkap'])) {

    foreach ($_POST['cekDokumenLengkap'] as $key => $value) {
        if ($value == 'doklengkap' && $_POST['textDokumenLengkap'][$key] != 'additional') {
            $ceklis++;
        }
    }
    // $blmLengkap = $_POST[no_fasilitas] . "|" . join("|", $a2);
    // echo $ceklis;
    if ($ceklis < 7) { //set pengajuan_klaim lengkap tdk manual
        echo "<script>window.alert('Centang Semua Data jika data sudah lengkap');
        window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
        </script>";
    } else {
        $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4', flag_dokumen = '1' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
        $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap', '$dateRekamGx')", $con);
        $result    = "Hasil: Data Lengkap";
        echo "<script>window.alert('$result');
                  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
                  </script>";
    }
} else if (isset($_POST['dokTidakLengkap'])) {
    foreach ($_POST['cekDokumenTdkLengkap'] as $key => $value) {
        if ($value == 'dokumenTdkLengkap') {
            $ceklistdklengkap++;
            $a3[] = $_POST['textDokumenTdkLengkap'][$key];
        }
    }
    $blmLengkap = join(", ", $a3);

    if ($ceklistdklengkap == 0) {
        echo "<script>window.alert('Centang data jika data tidak lengkap');
    	  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
    	  </script>";
    } else {
        $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '3' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
        $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '3', '0', 'Tidak Lengkap - $blmLengkap', '$dateRekamGx')", $con);
        $ketDokumen = "Dokumen " . $blmLengkap . " belum lengkap";
        $url = '10.20.10.16:8081/api/claim/feedback';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        $data = $_POST[no_fasilitas] . "#" . $_SESSION['username'] . "#" . $ketDokumen;
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: text/plain',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $resultcurl = curl_exec($curl);
        // if (!$resultcurl) {
        //     die("Connection Failure");
        // }
        curl_close($curl);

        $result    = "Hasil: " . $ketDokumen . ". Pemberitahuan dikirim ke BRI";
        echo "<script>window.alert('$result');
                  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
                  </script>";
    }
} else if (isset($_POST['dokLengkapManual'])) {
    foreach ($_POST['cekDokumenTdkLengkap'] as $key => $value) {
        if ($value == 'dokumenTdkLengkap') {
            $ceklistdklengkap++;
            $a3[] = $_POST['textDokumenTdkLengkap'][$key];
        }
    }
    $blmLengkap = join(", ", $a3);

    if ($ceklistdklengkap == 0) {
        echo "<script>window.alert('Centang data jika data tidak lengkap');
    	  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
    	  </script>";
    } else {

        $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4', flag_dokumen = '0' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
        $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap (HC)', '$dateRekamGx')", $con);
        $result    = "Hasil: Data Lengkap Hard Copy, data yang tidak tersedia " . $blmLengkap;
        echo "<script>window.alert('$result');
                  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
                  </script>";
    }
}

// if (isset($_POST['doklengkapManual'])) {
//     $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4', flag_dokumen = '0' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
//     $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap (HC)', '$dateRekamGx')", $con);
//     $result    = "Hasil: Data Lengkap Hard Copy";
//     echo "<script>window.alert('$result');
//     		  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
//     		  </script>";
//     echo $result;
//     exit;
// }

// if ($_POST['tidakAdaDokumen'] == '1') {
//     $noData = $_POST[no_fasilitas] . "|01|Tidak ada Dokumen|08|Tidak ada Dokumen|09|Tidak ada Dokumen|010|Tidak ada Dokumen|011|Tidak ada Dokumen|02|Tidak ada Dokumen|012|Tidak ada Dokumen|013|Tidak ada Dokumen|014|Tidak ada Dokumen|015|Tidak ada Dokumen|03|Tidak ada Dokumen|04|Tidak ada Dokumen|016|Tidak ada Dokumen|017|Tidak ada Dokumen|018|Tidak ada Dokumen|019|Tidak ada Dokumen|020|Tidak ada Dokumen|05|Tidak ada Dokumen|021|Tidak ada Dokumen|022|Tidak ada Dokumen|06|Tidak ada Dokumen|023|Tidak ada Dokumen|024|Tidak ada Dokumen|025|Tidak ada Dokumen|026|Tidak ada Dokumen|027|Tidak ada Dokumen|028|Tidak ada Dokumen|029|Tidak ada Dokumen|030|Tidak ada Dokumen|031|Tidak ada Dokumen|032|Tidak ada Dokumen|033|Tidak ada Dokumen|034|Tidak ada Dokumen|035|Tidak ada Dokumen|036|Tidak ada Dokumen|07|Tidak ada Dokumen|037|Tidak ada Dokumen|038|Tidak ada Dokumen|039|Tidak ada Dokumen|040|Tidak ada Dokumen|041|Tidak ada Dokumen|042|Tidak ada Dokumen|043|Tidak ada Dokumen|044|Tidak ada Dokumen|045|Tidak ada Dokumen|046|Tidak ada Dokumen";
//     $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '3' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
//     $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '3', '0', 'Tidak Lengkap - $noData', '$dateRekamGx')", $con);
//     $result    = "Hasil: Tidak Lengkap - $noData";
//     echo "<script>window.alert('$result');
//     		  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
//     		  </script>";
//     // echo $result;
//     exit;
// }

// if ($ceklis == 0) { //set pengajuan_klaim lengkap tdk manual
//     $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4', flag_dokumen = '1' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
//     $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap', '$dateRekamGx')", $con);
//     $result    = "Hasil: Data Lengkap";
// } else { //set pengajuan_klaim tidak lengkap
//     $qUPK     = mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '3' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
//     $qIHJK     = mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '3', '0', 'Tidak Lengkap - $blmLengkap', '$dateRekamGx')", $con);

//     $url = '10.20.10.16:8089/api/claim/feedback';
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_POST, 1);
//     $data = $_POST[no_fasilitas] . "#" . $_SESSION['username'];
//     // echo "session" . $_SESSION['username'];
//     if ($data) {
//         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     }
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//         'Content-Type: text/plain',
//     ));
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

//     // EXECUTE:
//     $resultcurl = curl_exec($curl);
//     // if (!$resultcurl) {
//     //     die("Connection Failure");
//     // }
//     curl_close($curl);
//     $result = "Hasil: Tidak Lengkap - $blmLengkap";
// }

// echo "<script>window.alert('$result');
// 		  window.location=(href='http://10.10.1.247:81/" . $rootdir . "/media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
// 		  </script>";