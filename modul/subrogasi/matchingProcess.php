<?php
include '../../config/koneksi_askred.php';

$idFile = $_GET['id'];

echo " <script>
            alert('File dalam proses recon, file akan siap diposting jika status sudah berubah menjadi POSTING READY');
            </script>
            ";
echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=listRCSubrogasi'</script>";

try {
    $result = mssql_query("Exec dbo.sp_rekon_subrogasi " . $idFile);
    // var_dump(mssql_fetch_array($result));
    // if(mssql_num_rows($result) > 0){

    // }
} catch (Exception $e) {
    echo $e;
}




// $headerTable = array();
// $FileType = pathinfo("upload/" . $file, PATHINFO_EXTENSION);
// $noRekeningRc = "";
// $nominalRc = "";
// $noFasilitasAwal = "";
// $dataMatch = 0;
// $dataUnmatch = 0;
// $noBk = $_POST['no_bk'];
// $noMm = $_POST['no_mm'];
// $date = date("Y-m-d");
// $tglBk = $_POST['tgl_bk'];
// $tglMm = $_POST['tgl_mm'];
// $tglRekKoran = "";
// $rekTemp = "";
// $ktrCabang = "";


//
//echo $_POST['no_bk'];
//echo $_POST['no_mm'];

//    echo "
//        <script>
//        console.log('sampe sini ga');
//        alert(".$file."|".$fileId.");
//        </script>
//        ";

//koneksi DB AOS PROD sementara
// $server = "10.20.10.16";
// $user = "askrindo";
// $password = "p@ssw0rd";
// $database = "aos_kur_bri";
// $db1 = mssql_connect($server, $user, $password, true);
// mssql_select_db($database, $db1) or die("Database tidak ditemukan");

// $server2     = "10.10.1.173";
// $user2         = "pti01";
// $password2     = "Askrindo@1234";
// $database2     = "dummy90";


// // // Koneksi dan memilih database di server
// $con2 = sybase_connect($server2, $user2, $password2);
// sybase_select_db($database2, $con2) or die("Database tidak ditemukan");

//koneksi DB AOS DEV sementara
// $server2 = "10.20.10.16";
// $user2 = "askrindo";
// $password2 = "p@ssw0rd";
// $database2 = "aos_kur_bri_dev";
// $con2 = mssql_connect($server2, $user2, $password2, true);
// mssql_select_db($database2, $con2) or die ("Database tidak ditemukan");


// function cekMatchClaimConfirmation($remark, $connection)
// {
//     return mssql_query("SELECT * FROM askred_claim_confirmation WHERE status_klaim = 1 AND remark ='" . $remark . "'", $connection);
// }

// function cekMatchDoubleRC($remark,  $connection)
// {
//     return mssql_query("SELECT * FROM askred_mapping_rc_bri_claim WHERE remark = '" . $remark . "'", $connection);
// }

// function queryUpdate($noRek)
// {
//     return sybase_query("UPDATE klaim 
//     SET status = '5'
//     FROM detail_klaim_askred, klaim
//     WHERE detail_klaim_askred.no_rekening = '$noRek'
//     AND detail_klaim_askred.status = '1'
//     AND detail_klaim_askred.status_old IS NOT NULL
//     AND detail_klaim_askred.id_klaim = klaim.id_klaim");
// }

// function queryCabang($noRek)
// {
//     // include 'koneksi_bri_prod.php';
//     return mssql_query("SELECT nama FROM mapping_bank_bri WHERE kode_uker_bank = 
//     (SELECT kode_uker FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $db1);
// }

// function queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noRek, $connection)
// {
//     return sybase_query("SELECT (SELECT max(id_transaksi_pby)+1
//                        FROM transaksi_pembayaran
//                        WHERE transaksi_pembayaran.id_kantordb = tgr.id_kantor) id_transaksi_pby,
//                        '1' AS id_valuta,
//                        tgr.id_r_bisnis AS id_r_group_bisnis,
//                        klaim.id_klaim AS nomor_skt,
//                        '2' AS jenis_pembayaran,
//                        '$noBk' AS nomor_dokumen,
//                        '$tglRekKoran' AS tgl_dokumen,
//                        GETDATE() AS tgl_realisasi,
//                        2 AS kode_transaksi,
//                        '1' AS kurs_rupiah,
//                        '$nominalRc' AS nilai_org,
//                        '$nominalRc' AS nilai_rph,
//                        'PEMBAYARAN KLAIM' AS ket_transaksi,
//                        tgr.id_customer AS id_customer,
//                        '$noBk'  AS no_voucher,
//                        GETDATE() AS tgl_rekam,
//                        '$tglBk' AS tgl_voucher,
//                        '$noMm' AS no_jurnal,
//                        '$tglMm' AS tgl_jurnal,
//                        detail_klaim_askred.id_customer AS no_debitur,
//                        1 AS line_no,
//                        'K' AS debet_kredit,
//                        'X999' AS id_user,
//                        tgr.id_kantor AS kode_kantor,
//                        detail_klaim_askred.line_no AS line_no_skt,
//                        tgr.id_kantor AS id_kantordb,
//                        detail_klaim_askred.no_rekening AS no_rekening,
//                        tgr.id_r_bisnis AS id_r_bisnis,
//                        (SELECT max(id_r_bisnis_t) FROM debitur WHERE debitur.no_rekening = detail_klaim_askred.no_rekening) AS id_r_bisnis_t
//                        FROM detail_klaim_askred, klaim, tgr
//                        WHERE detail_klaim_askred.no_rekening = '$noRek'
//                        AND detail_klaim_askred.status = '1'
//                        AND detail_klaim_askred.status_old IS NOT NULL
//                        AND detail_klaim_askred.id_tgr = klaim.id_tgr
//                        AND detail_klaim_askred.id_tgr = tgr.id_tgr", $connection);
// }

// function querySubrogasi($noBk, $noRek, $connection)
// {
//     return sybase_query("SELECT detail_klaim_askred.id_customer AS id_customer,
//                         1 AS line_no,
//                         tgr.id_r_bisnis AS id_r_bisnis, 
//                         klaim.id_klaim AS id_klaim,
//                         klaim.no_klaim AS no_klaim,
//                         klaim.tgl_klaim AS tgl_klaim,
//                         1 AS id_valuta,
//                         1 AS kurs_rupiah,
//                         detail_klaim_askred.net_klaim_rp AS nilai_subrogasi_org,
//                         detail_klaim_askred.net_klaim_rp AS nilai_subrogasi_rp,
//                         detail_klaim_askred.nilai_baki_debet AS nilai_baki_debet,
//                         tgr.id_customer AS cus_id_customer,
//                         '0' AS status,
//                         detail_klaim_askred.id_sertifikat AS id_sertifikat,
//                         (SELECT no_sertifikat FROM sertifikat WHERE detail_klaim_askred.id_sertifikat = sertifikat.id_sertifikat) AS no_sertifikat,
//                         (SELECT year(tgl_sertifikat) FROM sertifikat WHERE detail_klaim_askred.id_sertifikat = sertifikat.id_sertifikat) AS tahun_npp,
//                         'I' AS kode_ims,
//                         GETDATE() AS tgl_rekam,
//                         0 AS akm_recov,
//                         detail_klaim_askred.nilai_pert_org AS plafond_kredit,
//                         detail_klaim_askred.line_no AS line_no_asal,
//                         tgr.id_kantor AS id_kantordb,
//                         '$noBk' AS no_dokumen,
//                         detail_klaim_askred.no_rekening AS no_rekening,
//                         tgr.id_r_bisnis_t AS id_r_bisnis_t
//                     FROM detail_klaim_askred, klaim, tgr
//                     WHERE detail_klaim_askred.no_rekening = '$noRek'
//                     AND detail_klaim_askred.status = '1'
//                     AND detail_klaim_askred.status_old IS NOT NULL
//                     AND detail_klaim_askred.id_tgr = klaim.id_tgr
//                     AND detail_klaim_askred.id_tgr = tgr.id_tgr", $connection);
// }

// function insertToTrx(
//     $idTrxPby,
//     $idValuta,
//     $idRGrupBisnis,
//     $nomorSkt,
//     $jenisPembayaran,
//     $nomorDokumen,
//     $tglDokumen,
//     $tglRealisasi,
//     $kodeTrx,
//     $kursRp,
//     $nilaiOrg,
//     $nilaiRph,
//     $ketTrx,
//     $idCustomer,
//     $noVoucher,
//     $tglRekam,
//     $tglVoucher,
//     $noJurnal,
//     $tglJurnal,
//     $noDebitur,
//     $lineNo,
//     $debetKredit,
//     $idUser,
//     $kodeKantor,
//     $lineNoSkt,
//     $idKantordb,
//     $noRekening,
//     $idRBisnis,
//     $idRBisnisT,
//     $connection
// ) {
//     return sybase_query("INSERT INTO transaksi_pembayaran (id_transaksi_pby, id_valuta, id_r_group_bisnis, nomor_skt, jenis_pembayaran, nomor_dokumen, tgl_dokumen, tgl_realisasi,
//     kode_transaksi, kurs_rupiah, nilai_org, nilai_rph, ket_transaksi, id_customer, no_voucher, tgl_rekam,
//     tgl_voucher, no_jurnal, tgl_jurnal, no_debitur, line_no, debet_kredit, id_user, kode_kantor,
//     line_no_skt, id_kantordb, no_rekening, id_r_bisnis, id_r_bisnis_t)    
// VALUES (" . $idTrxPby . "," . floatval($idValuta) . ",'" . $idRGrupBisnis . "','" . $nomorSkt . "'," . floatval($jenisPembayaran) . ",'" . $nomorDokumen . "',
//     '" . $tglDokumen . "','" . $tglRealisasi . "'," . floatval($kodeTrx) . "," . floatval($kursRp) . "," . floatval($nilaiOrg) . "," . floatval($nilaiRph) . ",
//     '" . $ketTrx . "','" . $idCustomer . "','" . $noVoucher . "','" . $tglRekam . "','" . $tglVoucher . "','" . $noJurnal . "','" . $tglJurnal . "','" . $noDebitur . "',
//     " . floatval($lineNo) . ",'" . $debetKredit . "','" . $idUser . "','" . $kodeKantor . "'," . floatval($lineNoSkt) . ",'" . $idKantordb . "','" . $noRekening . "',
//     '" . $idRBisnis . "','" . $idRBisnisT . "')", $connection);
// }

// function insertToSubro(
//     $idCustomer2,
//     $lineNo2,
//     $idRBisnis2,
//     $idKlaim2,
//     $noKlaim2,
//     $tglKlaim2,
//     $idValuta2,
//     $kursRp2,
//     $nilaiSubroOrg,
//     $nilaiSubroRp,
//     $nilaiBakiDebet,
//     $cusIdCustomer,
//     $status2,
//     $idSertifikat2,
//     $noSertifikat2,
//     $tahunNpp,
//     $kodeIms,
//     $tglRekam2,
//     $akmRcov,
//     $platfondKredit,
//     $lineNoAsal,
//     $idKantordb2,
//     $nomorDokumen2,
//     $noRekening2,
//     $idRBisnisT2,
//     $connection
// ) {
//     return sybase_query("INSERT INTO subrogasi (id_customer, line_no, id_r_bisnis, id_klaim, no_klaim, tgl_klaim, id_valuta,
//                                         kurs_rupiah, nilai_subrogasi_org, nilai_subrogasi_rp, nilai_baki_debet, cus_id_customer, status, id_sertifikat,
//                                         no_sertifikat, tahun_npp, kode_ims, tgl_rekam, akm_recov, plafond_kredit, line_no_asal, 
//                                         id_kantordb, no_dokumen, no_rekening, id_r_bisnis_t)  
//                                 VALUES ('" . $idCustomer2 . "'," . floatval($lineNo2) . ",'" . $idRBisnis2 . "','" . $idKlaim2 . "','" . $noKlaim2 . "','" . $tglKlaim2 . "'," . floatval($idValuta2) . ",
//                                 " . floatval($kursRp2) . "," . floatval($nilaiSubroOrg) . "," . floatval($nilaiSubroRp) . "," . floatval($nilaiBakiDebet) . ",'" . $cusIdCustomer . "','" . $status2 . "',
//                                 '" . $idSertifikat2 . "','" . $noSertifikat2 . "'," . floatval($tahunNpp) . ",'" . $kodeIms . "','" . $tglRekam2 . "'," . floatval($akmRcov) . "," . floatval($platfondKredit) . ",
//                                 " . floatval($lineNoAsal) . ",'" . $idKantordb2 . "','" . $nomorDokumen2 . "','" . $noRekening2 . "','" . $idRBisnisT2 . "')", $connection);
// }

// function getListSubrogasi($connect)
// {
//     return mssql_query("SELECT * FROM askred_subrogation_validation WHERE status_proses = '1' AND remark is not null", $connect);
// }

// function getListMappingRC($paramIdFile, $connect)
// {
//     return mssql_query("SELECT id, remark FROM askred_mapping_rc_bri_subrogasi WHERE id_file_rc = $paramIdFile", $connect);
// }


// $listMappingRC =  getListMappingRC($idFile, $con);
// while ($rowMapRC = mssql_fetch_array($listMappingRC)) {
//     $cekDataMatch = mssql_query("SELECT remark FROM askred_subrogation_validation WHERE status_proses = '1' AND remark ='" . $rowMapRC['remark'] . "'");

//     $cekDataRCDouble = mssql_query("SELECT remark FROM askred_mapping_rc_bri_subrogasi  WHERE remark = '" . $rowMapRC['remark'] . "' AND correction_date is null");

//     if (mssql_num_rows($cekDataMatch) > 0) {

//         if (mssql_num_rows($cekDataRCDouble) > 0) {
//             $ismatch = 2;
//         } else {
//             $ismatch = 1;
//         }
//         mssql_query("UPDATE asf
//         SET asf.is_match = '" . $ismatch . "'
//         from askred_subrogation_flag asf,  askred_subrogation_validation asv 
//         WHERE asf.nomor_peserta = asv.nomor_rekening_pinjaman 
//         AND asf.urutan_pengajuan_subrogasi  = asv.urutan_pengajuan
//         AND asv.remark = '" . $rowMapRC['remark'] . "'");
//     } else {
//         $ismatch = 0;
//         echo "unmatch";
//         echo "<br>";
//     }
//     $update_date = date("Y-m-d H:i:s");
//     mssql_query("UPDATE askred_mapping_rc_bri_subrogasi set ismatch = '" . $ismatch . "', update_date = '" . $update_date . "' WHERE remark = '" . $rowMapRC['remark'] . "'");
// $proc = mssql_init('sp_rekon_subrogasi', $con);
// $proc_result = mssql_execute($proc);

// }

// $listMappingRC =  getListMappingRC($idFile, $con);
// while ($rowMapRC = mssql_fetch_array($listMappingRC)) {

    // }


    // if ($file) {
    //     try {
    //         $Spreadsheet = new SpreadsheetReader("upload/" . $file);
    //         $BaseMem = memory_get_usage();

    //         $Sheets = $Spreadsheet->Sheets();
    //         foreach ($Sheets as $Index => $Name) {
    //             $Time = microtime(true);
    //             $Spreadsheet->ChangeSheet(14);
    //             foreach ($Spreadsheet as $Key => $Row) {
    // if ($FileType == "xlsx") {
    // if ($Key > 9) {

    // $split2 = explode('_', $Row[2]);
    // $noRekeningRc = $split2[3];
    // echo $noRekeningRc . "-";
    // $nominalRc = $Row[6];
    // $tglRekKoran = $Row[0];
    // $remark = $Row[2];
    // $ismatch = NULL;


    // ambil data kantor cabang
    // $queryCabang = queryCabang($noRekeningRc);
    // $queryCabang = mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = '$noRekeningRc')", $db1);
    // $cabang = mssql_fetch_array($queryCabang);
    // $ktrCabang = $cabang['kantor'];

    // $cekMatch = cekMatchClaimConfirmation($remark, $con);
    // $cekMatchDouble = cekMatchDoubleRC($remark, $con);

    // $cekDataMatch = mssql_query("SELECT remark FROM askred_subrogation_validation WHERE status_proses = '1' AND remark ='" . $rowMapRC['remark'] . "'");
    // $rCekDataMatch = mssql_num_rows($cekDataMatch);

    // $cekDataRCDouble = mssql_query("SELECT remark FROM askred_mapping_rc_bri_subrogasi  WHERE remark = '" . $rowMapRC['remark'] . "' AND correction_date is null");
    // $rCekDataRCDouble = mssql_num_rows($cekDataRCDouble);

    // data match
    // $a = 0;
    // if (mssql_num_rows($cekDataMatch) > 0) {
        // $a++;
        // echo $a;
        // data match double
        // if (mssql_num_rows($cekDataRCDouble) > 0) {
            // $ismatch = 2;
            // echo "match-double";
            // echo "<br>";
            // mssql_query("UPDATE asf
            // SET asf.is_match = '2'
            // from askred_subrogation_flag asf,  askred_subrogation_validation asv 
            // WHERE asf.nomor_peserta = asv.nomor_rekening_pinjaman 
            // AND asf.urutan_pengajuan_subrogasi  = asv.urutan_pengajuan
            // AND asv.remark = '" . $rowMapRC['remark'] . "'");
            // while ($row = mssql_fetch_array($cekDataRCDouble)) {
            //     mssql_query("UPDATE askred_mapping_rc_bri_subrogasi set ismatch = '2' WHERE remark = '" . $rowMapRC['remark'] . "' AND id = '" . $rowMapRC['id'] . "'");
            // }
        // } else {
            // $ismatch = 1;
            // echo "match";
            // echo "<br>";
            // mssql_query("UPDATE asf
            // SET asf.is_match = '1'
            // from askred_subrogation_flag asf,  askred_subrogation_validation asv 
            // WHERE asf.nomor_peserta = asv.nomor_rekening_pinjaman 
            // AND asf.urutan_pengajuan_subrogasi  = asv.urutan_pengajuan
            // AND asv.remark = '" . $rowMapRC['remark'] . "'");

            // $queryPayTrx = queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noRekeningRc, $con2);
            // $getTrx = sybase_fetch_array($queryPayTrx);

            // $idTrxPby = $getTrx['id_transaksi_pby'];
            // $idValuta = $getTrx['id_valuta'];
            // $idRGrupBisnis = $getTrx['id_r_group_bisnis'];
            // $nomorSkt = $getTrx['nomor_skt'];
            // $jenisPembayaran = $getTrx['jenis_pembayaran'];
            // $nomorDokumen = $getTrx['nomor_dokumen'];

            // $varTglDokumen = $getTrx['tgl_dokumen'];
            // $dateDoc = DateTime::createFromFormat('d/m/y', $varTglDokumen); // "d/m/y" corresponds to the input format
            // $tglDokumen = $dateDoc->format('Y-m-d'); //outputs 2021-01-20

            // $tglRealisasi = date('Y-m-d', strtotime($getTrx['tgl_realisasi']));
            // //
            // $kodeTrx = $getTrx['kode_transaksi'];
            // $kursRp = $getTrx['kurs_rupiah'];
            // $nilaiOrg = $getTrx['nilai_org'];
            // $nilaiRph = $getTrx['nilai_rph'];
            // $ketTrx = $getTrx['ket_transaksi'];
            // $idCustomer = $getTrx['id_customer'];
            // $noVoucher = $getTrx['no_voucher'];
            // $tglRekam = date('Y-m-d', strtotime($getTrx['tgl_rekam']));
            // $tglVoucher = date('Y-m-d', strtotime($getTrx['tgl_voucher']));
            // $noJurnal = $getTrx['no_jurnal'];
            // $tglJurnal = date('Y-m-d', strtotime($getTrx['tgl_jurnal']));
            // $noDebitur = $getTrx['no_debitur'];
            // $lineNo = $getTrx['line_no'];
            // $debetKredit = $getTrx['debet_kredit'];
            // $idUser = $getTrx['id_user'];
            // $kodeKantor = $getTrx['kode_kantor'];
            // $lineNoSkt = $getTrx['line_no_skt'];
            // $idKantordb = $getTrx['id_kantordb'];
            // $noRekening = $getTrx['no_rekening'];
            // $idRBisnis = $getTrx['id_r_bisnis'];
            // $idRBisnisT = $getTrx['id_r_bisnis_t'];


            // $insertToTrx = insertToTrx($idTrxPby, $idValuta, $idRGrupBisnis, $nomorSkt, $jenisPembayaran, $nomorDokumen, $tglDokumen, $tglRealisasi,
            //                             $kodeTrx, $kursRp, $nilaiOrg, $nilaiRph, $ketTrx, $idCustomer, $noVoucher, $tglRekam, $tglVoucher, $noJurnal,
            //                             $tglJurnal, $noDebitur, $lineNo, $debetKredit, $idUser, $kodeKantor, $lineNoSkt, $idKantordb, $noRekening, $idRBisnis,
            //                             $idRBisnisT, $con2);


            // jalankan query subrogasi
            // $querySubro = querySubrogasi($noBk, $noRekeningRc, $con2);
            // $getSubro = sybase_fetch_array($querySubro);
            // var_dump($getSubro);


            // $idCustomer2 = $getSubro['id_customer'];
            // $lineNo2 = $getSubro['line_no'];
            // $idRBisnis2 = $getSubro['id_r_bisnis'];
            // $idKlaim2 = $getSubro['id_klaim'];
            // $noKlaim2 = $getSubro['no_klaim'];
            // $tglKlaim2 = date('Y-m-d', strtotime($getSubro['tgl_klaim']));
            // $idValuta2 = $getSubro['id_valuta'];
            // $kursRp2 = $getSubro['kurs_rupiah'];
            // $nilaiSubroOrg = $getSubro['nilai_subrogasi_org'];
            // $nilaiSubroRp = $getSubro['nilai_subrogasi_rp'];
            // $nilaiBakiDebet = $getSubro['nilai_baki_debet'];
            // $cusIdCustomer = $getSubro['cus_id_customer'];
            // $status2 = $getSubro['status'];
            // $idSertifikat2 = $getSubro['id_sertifikat'];
            // $noSertifikat2 = $getSubro['no_sertifikat'];
            // $tahunNpp = $getSubro['tahun_npp'];
            // $kodeIms = $getSubro['kode_ims'];
            // $tglRekam2 = date('Y-m-d', strtotime($getSubro['tgl_rekam']));
            // $akmRcov = $getSubro['akm_recov'];
            // $platfondKredit = $getSubro['plafond_kredit'];
            // $lineNoAsal = $getSubro['line_no_asal'];
            // $idKantordb2 = $getSubro['id_kantordb'];
            // $nomorDokumen2 = $getSubro['no_dokumen'];
            // $noRekening2 = $getSubro['no_rekening'];
            // $idRBisnisT2 = $getSubro['id_r_bisnis_t'];

            // $insertToSubro = insertToSubro($idCustomer2, $lineNo2, $idRBisnis2, $idKlaim2, $noKlaim2, $tglKlaim2, $idValuta2, $kursRp2,
            //                                 $nilaiSubroOrg, $nilaiSubroRp, $nilaiBakiDebet, $cusIdCustomer, $status2, $idSertifikat2, $noSertifikat2,
            //                                 $tahunNpp, $kodeIms, $tglRekam2, $akmRcov, $platfondKredit, $lineNoAsal, $idKantordb2, $nomorDokumen2,
            //                                 $noRekening2, $idRBisnisT2, $con2);

    //     }
    //     mssql_query("UPDATE asf
    //     SET asf.is_match = '".$ismatch."'
    //     from askred_subrogation_flag asf,  askred_subrogation_validation asv 
    //     WHERE asf.nomor_peserta = asv.nomor_rekening_pinjaman 
    //     AND asf.urutan_pengajuan_subrogasi  = asv.urutan_pengajuan
    //     AND asv.remark = '" . $rowMapRC['remark'] . "'");
    // } else {
    //     $ismatch = 0;
    //     echo "unmatch";
    //     echo "<br>";
    // }
    // $update_date = date("Y-m-d H:i:s");
    // mssql_query("UPDATE askred_mapping_rc_bri_subrogasi set ismatch = '" . $ismatch . "', update_date = '" . $update_date . "' WHERE remark = '" . $rowMapRC['remark'] . "'");

    // $updateBkMm  = mssql_query("UPDATE askred_file_rc_claim  SET no_bk = '" . $noBk . "' ,no_mm = '" . $noMm . "', tgl_bk = '" . $tglBk . "', tgl_mm = '" . $tglMm . "' WHERE id = '" . $fileId . "'", $con);
    // } else {
    //     //var_dump($Row[2]);
    //     // print_r($Row[6]);
    //     // echo '<br>else';
    //     //    echo $Key;

    // }
    // }
// }
        //     $CurrentMem = memory_get_usage();
        // }
        // echo "
        // <script>
        // alert('file berhasil di posting');
        // </script>
        // ";
        // echo "<script>window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=claimListRC'</script>";
    // } catch (Exception $E) {
    //     echo $E->getMessage();
    // }
// } else {
//     echo "Sorry, there was an error uploading your file."; // this error arising in my program
// }