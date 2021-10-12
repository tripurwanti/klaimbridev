<?php

include 'excel_reader2.php';
include 'SpreadsheetReader.php';
// include 'koneksi.php';
include 'library.php';
include 'koneksi_sakura.php';

// $file = $_REQUEST['file'];
$fileId = $_REQUEST['id'];
$headerTable = array();
$FileType = pathinfo("uploads/" . $file, PATHINFO_EXTENSION);
$noRekeningRc = "";
$nominalRc = "";
$noFasilitasAwal = "";
$dataMatch = 0;
$dataUnmatch = 0;
$noBk = $_POST['no_bk'];
$noMm = $_POST['no_mm'];
$date = date("Y-m-d");
$tglBk = $_POST['tgl_bk'];
$tglMm = $_POST['tgl_mm'];
$tglRekKoran = "";
$rekTemp = "";
$ktrCabang = "";

//koneksi DB AOS PROD sementara
$server     = "10.20.10.16";
$user         = "askrindo";
$password     = "p@ssw0rd";
$database     = "aos_kur_bri";
$db1 = mssql_connect($server, $user, $password, true);
mssql_select_db($database, $db1) or die("Database tidak ditemukan");

//koneksi DB AOS DEV sementara
$server2     = "10.20.10.16";
$user2         = "askrindo";
$password2     = "p@ssw0rd";
$database2     = "aos_kur_bri_dev";
$con2 = mssql_connect($server2, $user2, $password2, true);
mssql_select_db($database2, $con2) or die("Database tidak ditemukan");


function queryUpdate($noRek)
{
    return sybase_query("UPDATE klaim 
    SET status = '5'
    FROM detail_klaim_askred, klaim
    WHERE detail_klaim_askred.no_rekening = '$noRek'
    AND detail_klaim_askred.status = '1'
    AND detail_klaim_askred.status_old IS NOT NULL
    AND detail_klaim_askred.id_klaim = klaim.id_klaim");
}

// function queryCabang($noRek)
// {
//     // include 'koneksi_bri_prod.php';
//     return mssql_query("SELECT nama FROM mapping_bank_bri WHERE kode_uker_bank = 
//     (SELECT kode_uker FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $db1);
// }

function queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noRek)
{
    return sybase_query("SELECT (SELECT max(id_transaksi_pby)+1 
                        FROM transaksi_pembayaran 
                        WHERE transaksi_pembayaran.id_kantordb = tgr.id_kantor) id_transaksi_pby,
                        '1' AS id_valuta,
                        tgr.id_r_bisnis AS id_r_group_bisnis, 
                        klaim.id_klaim AS nomor_skt,
                        '2' AS jenis_pembayaran,
                        '$noBk' AS nomor_dokumen,
                        '$tglRekKoran' AS tgl_dokumen,  
                        GETDATE() AS tgl_realisasi,
                        2 AS kode_transaksi,
                        '1' AS kurs_rupiah,
                        '$nominalRc' AS nilai_org,
                        '$nominalRc' AS nilai_rph,
                        'PEMBAYARAN KLAIM' AS ket_transaksi,
                        tgr.id_customer AS id_customer,
                        '$noBk'  AS no_voucher,
                        GETDATE() AS tgl_rekam,
                        '$tglBk' AS tgl_voucher,
                        '$noMm' AS no_jurnal,
                        '$tglMm' AS tgl_jurnal,
                        detail_klaim_askred.id_customer AS no_debitur,
                        1 AS line_no,
                        'K' AS debet_kredit,
                        'X999' AS id_user,
                        tgr.id_kantor AS kode_kantor,
                        detail_klaim_askred.line_no AS line_no_skt,
                        tgr.id_kantor AS id_kantordb,
                        detail_klaim_askred.no_rekening AS no_rekening,
                        tgr.id_r_bisnis AS id_r_bisnis,
                        (SELECT max(id_r_bisnis_t) FROM debitur WHERE debitur.no_rekening = detail_klaim_askred.no_rekening) AS id_r_bisnis_t
                        FROM detail_klaim_askred, klaim, tgr
                        WHERE detail_klaim_askred.no_rekening = '$noRek'	
                        AND detail_klaim_askred.status = '1'
                        AND detail_klaim_askred.status_old IS NOT NULL
                        AND detail_klaim_askred.id_tgr = klaim.id_tgr
                        AND detail_klaim_askred.id_tgr = tgr.id_tgr");
}

function querySubrogasi($noBk, $noRek)
{
    return sybase_query("SELECT detail_klaim_askred.id_customer AS id_customer,
                        1 AS line_no,
                        tgr.id_r_bisnis AS id_r_bisnis, 
                        klaim.id_klaim AS id_klaim,
                        klaim.no_klaim AS no_klaim,
                        klaim.tgl_klaim AS tgl_klaim,
                        1 AS id_valuta,
                        1 AS kurs_rupiah,
                        detail_klaim_askred.net_klaim_rp AS nilai_subrogasi_org,
                        detail_klaim_askred.net_klaim_rp AS nilai_subrogasi_rp,
                        detail_klaim_askred.nilai_baki_debet AS nilai_baki_debet,
                        tgr.id_customer AS cus_id_customer,
                        '0' AS status,
                        detail_klaim_askred.id_sertifikat AS id_sertifikat,
                        (SELECT no_sertifikat FROM sertifikat WHERE detail_klaim_askred.id_sertifikat = sertifikat.id_sertifikat) AS no_sertifikat,
                        (SELECT year(tgl_sertifikat) FROM sertifikat WHERE detail_klaim_askred.id_sertifikat = sertifikat.id_sertifikat) AS tahun_npp,
                        'I' AS kode_ims,
                        GETDATE() AS tgl_rekam,
                        0 AS akm_recov,
                        detail_klaim_askred.nilai_pert_org AS plafond_kredit,
                        detail_klaim_askred.line_no AS line_no_asal,
                        tgr.id_kantor AS id_kantordb,
                        '$noBk' AS no_dokumen,
                        detail_klaim_askred.no_rekening AS no_rekening,
                        tgr.id_r_bisnis_t AS id_r_bisnis_t
                    FROM detail_klaim_askred, klaim, tgr
                    WHERE detail_klaim_askred.no_rekening = '$noRek'
                    AND detail_klaim_askred.status = '1'
                    AND detail_klaim_askred.status_old IS NOT NULL
                    AND detail_klaim_askred.id_tgr = klaim.id_tgr
                    AND detail_klaim_askred.id_tgr = tgr.id_tgr");
}

function insertToTrx(
    $idTrxPby,
    $idValuta,
    $idRGrupBisnis,
    $nomorSkt,
    $jenisPembayaran,
    $nomorDokumen,
    $tglDokumen,
    $tglRealisasi,
    $kodeTrx,
    $kursRp,
    $nilaiOrg,
    $nilaiRph,
    $ketTrx,
    $idCustomer,
    $noVoucher,
    $tglRekam,
    $tglVoucher,
    $noJurnal,
    $tglJurnal,
    $noDebitur,
    $lineNo,
    $debetKredit,
    $idUser,
    $kodeKantor,
    $lineNoSkt,
    $idKantordb,
    $noRekening,
    $idRBisnis,
    $idRBisnisT
) {
    return sybase_query("INSERT INTO transaksi_pembayaran (id_transaksi_pby, id_valuta, id_r_group_bisnis, nomor_skt, jenis_pembayaran, nomor_dokumen, tgl_dokumen, tgl_realisasi,
    kode_transaksi, kurs_rupiah, nilai_org, nilai_rph, ket_transaksi, id_customer, no_voucher, tgl_rekam,
    tgl_voucher, no_jurnal, tgl_jurnal, no_debitur, line_no, debet_kredit, id_user, kode_kantor,
    line_no_skt, id_kantordb, no_rekening, id_r_bisnis, id_r_bisnis_t)    
VALUES (" . $idTrxPby . "," . floatval($idValuta) . ",'" . $idRGrupBisnis . "','" . $nomorSkt . "'," . floatval($jenisPembayaran) . ",'" . $nomorDokumen . "',
    '" . $tglDokumen . "','" . $tglRealisasi . "'," . floatval($kodeTrx) . "," . floatval($kursRp) . "," . floatval($nilaiOrg) . "," . floatval($nilaiRph) . ",
    '" . $ketTrx . "','" . $idCustomer . "','" . $noVoucher . "','" . $tglRekam . "','" . $tglVoucher . "','" . $noJurnal . "','" . $tglJurnal . "','" . $noDebitur . "',
    " . floatval($lineNo) . ",'" . $debetKredit . "','" . $idUser . "','" . $kodeKantor . "'," . floatval($lineNoSkt) . ",'" . $idKantordb . "','" . $noRekening . "',
    '" . $idRBisnis . "','" . $idRBisnisT . "')");
}

function insertToSubro(
    $idCustomer2,
    $lineNo2,
    $idRBisnis2,
    $idKlaim2,
    $noKlaim2,
    $tglKlaim2,
    $idValuta2,
    $kursRp2,
    $nilaiSubroOrg,
    $nilaiSubroRp,
    $nilaiBakiDebet,
    $cusIdCustomer,
    $status2,
    $idSertifikat2,
    $noSertifikat2,
    $tahunNpp,
    $kodeIms,
    $tglRekam2,
    $akmRcov,
    $platfondKredit,
    $lineNoAsal,
    $idKantordb2,
    $nomorDokumen2,
    $noRekening2,
    $idRBisnisT2
) {
    return sybase_query("INSERT INTO subrogasi (id_customer, line_no, id_r_bisnis, id_klaim, no_klaim, tgl_klaim, id_valuta,
                                        kurs_rupiah, nilai_subrogasi_org, nilai_subrogasi_rp, nilai_baki_debet, cus_id_customer, status, id_sertifikat,
                                        no_sertifikat, tahun_npp, kode_ims, tgl_rekam, akm_recov, plafond_kredit, line_no_asal, 
                                        id_kantordb, no_dokumen, no_rekening, id_r_bisnis_t)  
                                VALUES ('" . $idCustomer2 . "'," . floatval($lineNo2) . ",'" . $idRBisnis2 . "','" . $idKlaim2 . "','" . $noKlaim2 . "','" . $tglKlaim2 . "'," . floatval($idValuta2) . ",
                                " . floatval($kursRp2) . "," . floatval($nilaiSubroOrg) . "," . floatval($nilaiSubroRp) . "," . floatval($nilaiBakiDebet) . ",'" . $cusIdCustomer . "','" . $status2 . "',
                                '" . $idSertifikat2 . "','" . $noSertifikat2 . "'," . floatval($tahunNpp) . ",'" . $kodeIms . "','" . $tglRekam2 . "'," . floatval($akmRcov) . "," . floatval($platfondKredit) . ",
                                " . floatval($lineNoAsal) . ",'" . $idKantordb2 . "','" . $nomorDokumen2 . "','" . $noRekening2 . "','" . $idRBisnisT2 . "')");
}

$no = 1;
// ----------------------------------------- posting data sakura -----------------------------------------------
$queryGetDataRc2 = mssql_query("SELECT no_rekening, nominal_klaim, tgl_rek_koran, cabang FROM mapping_rc_bri WHERE id = '$fileId' AND status = '1'", $con2);

$no = 1;

while ($dq = mssql_fetch_array($queryGetDataRc2)) {

    $noRekeningRc = $dq['no_rekening'];
    $nominalRc = $dq['nominal_klaim'];
    $tglRekKoran = $dq['tgl_rek_koran'];
    $ktrCabang = $dq['cabang'];

    // ambil data transaksi pembayaran
    $queryPayTrx = queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noRekeningRc);
    $getTrx = sybase_fetch_array($queryPayTrx);

    $idTrxPby = $getTrx['id_transaksi_pby'];
    $idValuta = $getTrx['id_valuta'];
    $idRGrupBisnis = $getTrx['id_r_group_bisnis'];
    $nomorSkt = $getTrx['nomor_skt'];
    $jenisPembayaran = $getTrx['jenis_pembayaran'];
    $nomorDokumen = $getTrx['nomor_dokumen'];

    $varTglDokumen = $getTrx['tgl_dokumen'];
    $dateDoc = DateTime::createFromFormat('d/m/y', $varTglDokumen); // "d/m/y" corresponds to the input format
    $tglDokumen =  $dateDoc->format('Y-m-d'); //outputs 2021-01-20

    $tglRealisasi = date('Y-m-d', strtotime($getTrx['tgl_realisasi']));

    $kodeTrx = $getTrx['kode_transaksi'];
    $kursRp = $getTrx['kurs_rupiah'];
    $nilaiOrg = $getTrx['nilai_org'];
    $nilaiRph = $getTrx['nilai_rph'];
    $ketTrx = $getTrx['ket_transaksi'];
    $idCustomer = $getTrx['id_customer'];
    $noVoucher = $getTrx['no_voucher'];
    $tglRekam = date('Y-m-d', strtotime($getTrx['tgl_rekam']));
    $tglVoucher = date('Y-m-d', strtotime($getTrx['tgl_voucher']));
    $noJurnal = $getTrx['no_jurnal'];
    $tglJurnal = date('Y-m-d', strtotime($getTrx['tgl_jurnal']));
    $noDebitur = $getTrx['no_debitur'];
    $lineNo = $getTrx['line_no'];
    $debetKredit = $getTrx['debet_kredit'];
    $idUser = $getTrx['id_user'];
    $kodeKantor = $getTrx['kode_kantor'];
    $lineNoSkt = $getTrx['line_no_skt'];
    $idKantordb = $getTrx['id_kantordb'];
    $noRekening = $getTrx['no_rekening'];
    $idRBisnis = $getTrx['id_r_bisnis'];
    $idRBisnisT = $getTrx['id_r_bisnis_t'];

    // $insertToTrx = insertToTrx(
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
    //     $idRBisnisT
    // );

    // if ($insertToTrx) {
    //     echo "Success";
    // } else {
    //     echo "Failed";
    //     echo ("Error description: " . $insertToTrx->error);
    // }

    // jalankan query subrogasi
    $querySubro = querySubrogasi($noBk, $noRekeningRc);
    $getSubro = sybase_fetch_array($querySubro);

    $idCustomer2 = $getSubro['id_customer'];
    $lineNo2 = $getSubro['line_no'];
    $idRBisnis2 = $getSubro['id_r_bisnis'];
    $idKlaim2 = $getSubro['id_klaim'];
    $noKlaim2 = $getSubro['no_klaim'];
    $tglKlaim2 = date('Y-m-d', strtotime($getSubro['tgl_klaim']));
    $idValuta2 = $getSubro['id_valuta'];
    $kursRp2 = $getSubro['kurs_rupiah'];
    $nilaiSubroOrg = $getSubro['nilai_subrogasi_org'];
    $nilaiSubroRp = $getSubro['nilai_subrogasi_rp'];
    $nilaiBakiDebet = $getSubro['nilai_baki_debet'];
    $cusIdCustomer = $getSubro['cus_id_customer'];
    $status2 = $getSubro['status'];
    $idSertifikat2 = $getSubro['id_sertifikat'];
    $noSertifikat2 = $getSubro['no_sertifikat'];
    $tahunNpp = $getSubro['tahun_npp'];
    $kodeIms = $getSubro['kode_ims'];
    $tglRekam2 = date('Y-m-d', strtotime($getSubro['tgl_rekam']));
    $akmRcov = $getSubro['akm_recov'];
    $platfondKredit = $getSubro['plafond_kredit'];
    $lineNoAsal = $getSubro['line_no_asal'];
    $idKantordb2 = $getSubro['id_kantordb'];
    $nomorDokumen2 = $getSubro['no_dokumen'];
    $noRekening2 = $getSubro['no_rekening'];
    $idRBisnisT2 = $getSubro['id_r_bisnis_t'];

    // $insertToSubro = insertToSubro(
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
    //     $idRBisnisT2
    // );

    // if ($insertToSubro) {
    //     echo "Success";
    // } else {
    //     echo "Failed";
    //     echo ("Error description: " . $insertToSubro->error);
    // }

    // // jalankan query update status claim
    // $queryUpdate = queryUpdate($noRekeningRc);
}

// update no bk dan no mm
mssql_query("UPDATE file_rc SET no_bk = '$noBk' ,no_mm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm'
WHERE id = '$fileId'", $con2);

$dataMatchNotPosting = mssql_query("SELECT no_rekening FROM mapping_rc_bri WHERE id = '$fileId' AND status = '1' AND is_posting = 0", $con2);
$countDataMatchNotPosting  = mssql_num_rows($dataMatchNotPosting);
if ($countDataMatchNotPosting <= 0) {
    mssql_query("UPDATE file_rc SET flag_status = '2' WHERE id = '$fileId'", $con2);
}

mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date' ,noBk = '$noBk' ,noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' 
WHERE id = '$fileId' AND status = '1'", $con2);












// ---------------------------------- ini posting sebelum pake scheduler -----------------------------------------
// $queryGetDataRc = mssql_query("SELECT no_rekening, nominal_klaim, tgl_rek_koran, cabang FROM mapping_rc_bri WHERE id = '$fileId'", $con2);
// while ($dq = mssql_fetch_array($queryGetDataRc)) {

//     $noRekeningRc = $dq['no_rekening'];
//     $nominalRc = $dq['nominal_klaim'];
//     $tglRekKoran = $dq['tgl_rek_koran'];
//     $ktrCabang = $dq['cabang'];

//     // filter dengan tabel tob AOS
//     $querry = mssql_query("SELECT tob.no_fasilitas_awal FROM tob WHERE tob.no_fasilitas_baru = '$noRekeningRc'", $con2);
//     if (mssql_num_rows($querry) > 0) {
//         // while ($noFasilitas =  mssql_fetch_array($querry)){
//         $noFasilitas = mssql_fetch_array($querry);
//         if ($noFasilitas['no_fasilitas_awal'] != NULL) {
//             $noFasilitasAwal = $noFasilitas['no_fasilitas_awal'];

//             // rekon no fasilitas awal dengan data sakura
//             $queryAOS = queryAOSRC($noFasilitasAwal);
//             if (sybase_num_rows($queryAOS) > 0) {
//                 $dataSakura =  sybase_fetch_array($queryAOS);

//                 $cekTableRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE no_rekening ='$noFasilitasAwal' AND id = '$fileId' AND status IS NOT NULL", $con2);
//                 $dataTableRc = mssql_fetch_array($cekTableRc);
//                 if ($dataTableRc) {
//                     // rekening sudah di posting 
//                     $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET status = 'unmatch', detail = 'klaim sudah dibayarkan' WHERE no_rekening = '$noFasilitasAwal' AND id = '$fileId'", $con2);
//                 } elseif ($dataSakura['no_rekening'] != NULL) {
//                     if ($dataSakura['status'] == '5') {
//                         // rekening sudah pernah dibayar
//                         $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = 'unmatch', detail = 'klaim sudah dibayar', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                     } elseif ($dataSakura['no_rekening'] == $noFasilitasAwal && !($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100 || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {

//                         // jika data match
//                         $selectNoCl = mssql_query("SELECT no_klaim FROM  jawaban_klaim_kur_gen2 WHERE no_rekening = '$noFasilitasAwal'", $db1);
//                         $FetchnoCl = mssql_fetch_array($selectNoCl);
//                         $noCl = $FetchnoCl['no_klaim'];
//                         $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = 'match', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm', no_cl = '$noCl' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                         // ambil data transaksi pembayaran
//                         $queryPayTrx = queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noFasilitasAwal);
//                         $getTrx = sybase_fetch_array($queryPayTrx);
//                         $idTrxPby = $getTrx['id_transaksi_pby'];
//                         $idValuta = $getTrx['id_valuta'];
//                         $idRGrupBisnis = $getTrx['id_r_group_bisnis'];
//                         $nomorSkt = $getTrx['nomor_skt'];
//                         $jenisPembayaran = $getTrx['jenis_pembayaran'];
//                         $nomorDokumen = $getTrx['nomor_dokumen'];

//                         $varTglDokumen = $getTrx['tgl_dokumen'];
//                         $dateDoc = DateTime::createFromFormat('d/m/y', $varTglDokumen); // "d/m/y" corresponds to the input format
//                         $tglDokumen =  $dateDoc->format('Y-m-d'); //outputs 2021-01-20

//                         $tglRealisasi = date('Y-m-d', strtotime($getTrx['tgl_realisasi']));

//                         $kodeTrx = $getTrx['kode_transaksi'];
//                         $kursRp = $getTrx['kurs_rupiah'];
//                         $nilaiOrg = $getTrx['nilai_org'];
//                         $nilaiRph = $getTrx['nilai_rph'];
//                         $ketTrx = $getTrx['ket_transaksi'];
//                         $idCustomer = $getTrx['id_customer'];
//                         $noVoucher = $getTrx['no_voucher'];
//                         $tglRekam = date('Y-m-d', strtotime($getTrx['tgl_rekam']));
//                         $tglVoucher = date('Y-m-d', strtotime($getTrx['tgl_voucher']));
//                         $noJurnal = $getTrx['no_jurnal'];
//                         $tglJurnal = date('Y-m-d', strtotime($getTrx['tgl_jurnal']));
//                         $noDebitur = $getTrx['no_debitur'];
//                         $lineNo = $getTrx['line_no'];
//                         $debetKredit = $getTrx['debet_kredit'];
//                         $idUser = $getTrx['id_user'];
//                         $kodeKantor = $getTrx['kode_kantor'];
//                         $lineNoSkt = $getTrx['line_no_skt'];
//                         $idKantordb = $getTrx['id_kantordb'];
//                         $noRekening = $getTrx['no_rekening'];
//                         $idRBisnis = $getTrx['id_r_bisnis'];
//                         $idRBisnisT = $getTrx['id_r_bisnis_t'];

//                         // $insertToTrx = insertToTrx($idTrxPby, $idValuta, $idRGrupBisnis, $nomorSkt, $jenisPembayaran, $nomorDokumen, $tglDokumen, $tglRealisasi,
//                         //                             $kodeTrx, $kursRp, $nilaiOrg, $nilaiRph, $ketTrx, $idCustomer, $noVoucher, $tglRekam, $tglVoucher, $noJurnal,
//                         //                             $tglJurnal, $noDebitur, $lineNo, $debetKredit, $idUser, $kodeKantor, $lineNoSkt, $idKantordb, $noRekening, $idRBisnis,
//                         //                             $idRBisnisT);

//                         // // jalankan query subrogasi
//                         $querySubro = querySubrogasi($noBk, $noFasilitasAwal);
//                         $getSubro = sybase_fetch_array($querySubro);

//                         $idCustomer2 = $getSubro['id_customer'];
//                         $lineNo2 = $getSubro['line_no'];
//                         $idRBisnis2 = $getSubro['id_r_bisnis'];
//                         $idKlaim2 = $getSubro['id_klaim'];
//                         $noKlaim2 = $getSubro['no_klaim'];
//                         $tglKlaim2 = date('Y-m-d', strtotime($getSubro['tgl_klaim']));
//                         $idValuta2 = $getSubro['id_valuta'];
//                         $kursRp2 = $getSubro['kurs_rupiah'];
//                         $nilaiSubroOrg = $getSubro['nilai_subrogasi_org'];
//                         $nilaiSubroRp = $getSubro['nilai_subrogasi_rp'];
//                         $nilaiBakiDebet = $getSubro['nilai_baki_debet'];
//                         $cusIdCustomer = $getSubro['cus_id_customer'];
//                         $status2 = $getSubro['status'];
//                         $idSertifikat2 = $getSubro['id_sertifikat'];
//                         $noSertifikat2 = $getSubro['no_sertifikat'];
//                         $tahunNpp = $getSubro['tahun_npp'];
//                         $kodeIms = $getSubro['kode_ims'];
//                         $tglRekam2 = date('Y-m-d', strtotime($getSubro['tgl_rekam']));
//                         $akmRcov = $getSubro['akm_recov'];
//                         $platfondKredit = $getSubro['plafond_kredit'];
//                         $lineNoAsal = $getSubro['line_no_asal'];
//                         $idKantordb2 = $getSubro['id_kantordb'];
//                         $nomorDokumen2 = $getSubro['no_dokumen'];
//                         $noRekening2 = $getSubro['no_rekening'];
//                         $idRBisnisT2 = $getSubro['id_r_bisnis_t'];

//                         // $insertToSubro = insertToSubro($idCustomer2, $lineNo2, $idRBisnis2, $idKlaim2, $noKlaim2, $tglKlaim2, $idValuta2, $kursRp2,
//                         //                                 $nilaiSubroOrg, $nilaiSubroRp, $nilaiBakiDebet, $cusIdCustomer, $status2, $idSertifikat2, $noSertifikat2,
//                         //                                 $tahunNpp, $kodeIms, $tglRekam2, $akmRcov, $platfondKredit, $lineNoAsal, $idKantordb2, $nomorDokumen2,
//                         //                                 $noRekening2, $idRBisnisT2);        

//                         // jalankan query update status claim
//                         // $queryUpdate = queryUpdate($noFasilitasAwal);

//                         // echo 'datanya match';
//                     } else {
//                         // rekening ada, tapi nilai klaim tidak sesuai
//                         $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = 'unmatch', detail = 'Nominal klaim tidak sesuai', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                         // echo 'datanya tidak match';
//                     }
//                 } else {
//                     // rekening tidak ditemukan
//                     $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = 'unmatch', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                 }
//             }
//             $updateBkMm = mssql_query("UPDATE file_rc SET no_bk = '$noBk' ,no_mm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE id = '$fileId'");
//         }

//         //jika no rekening tidak sama dengan no fasilitas awal dalam tabel AOS
//     } else {
//         $queryAOSRc = queryAOSRC($noRekeningRc);
//         if (sybase_num_rows($queryAOSRc) > 0) {
//             $dataSakura =  sybase_fetch_array($queryAOSRc);

//             //cek data apakah sudah pernah di posting dalam tabel mapping
//             $cekTableRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE no_rekening ='$noRekeningRc' AND id = '$fileId' AND status IS NOT NULL", $con2);
//             $dataTableRc = mssql_fetch_array($cekTableRc);
//             if ($dataTableRc) {
//                 // rekening sudah di posting 
//                 $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET status = 'unmatch', detail = 'klaim sudah dibayarkan' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//             } elseif ($dataSakura['no_rekening'] != NULL) {

//                 if ($dataSakura['status'] == '5') {
//                     // rekening sudah pernah dibayar
//                     $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'unmatch', detail = 'Klaim sudah dibayar', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                 } elseif ($dataSakura['no_rekening'] == $noRekeningRc && !($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100 || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {
//                     // jika data match
//                     $selectNoCl = mssql_query("SELECT no_klaim FROM  jawaban_klaim_kur_gen2 WHERE no_rekening = '$noRekeningRc'", $db1);
//                     $FetchnoCl = mssql_fetch_array($selectNoCl);
//                     $noCl = $FetchnoCl['no_klaim'];
//                     $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'match', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm', no_cl = '$noCl' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                     // ambil data transaksi pembayaran
//                     $queryPayTrx = queryPayTrx($noBk, $tglBk, $noMm, $tglMm, $tglRekKoran, $nominalRc, $noRekeningRc);
//                     $getTrx = sybase_fetch_array($queryPayTrx);
//                     // print_r($getTrx);

//                     $idTrxPby = $getTrx['id_transaksi_pby'];
//                     $idValuta = $getTrx['id_valuta'];
//                     $idRGrupBisnis = $getTrx['id_r_group_bisnis'];
//                     $nomorSkt = $getTrx['nomor_skt'];
//                     $jenisPembayaran = $getTrx['jenis_pembayaran'];
//                     $nomorDokumen = $getTrx['nomor_dokumen'];

//                     $varTglDokumen = $getTrx['tgl_dokumen'];
//                     $dateDoc = DateTime::createFromFormat('d/m/y', $varTglDokumen); // "d/m/y" corresponds to the input format
//                     $tglDokumen =  $dateDoc->format('Y-m-d'); //outputs 2021-01-20

//                     $tglRealisasi = date('Y-m-d', strtotime($getTrx['tgl_realisasi']));

//                     $kodeTrx = $getTrx['kode_transaksi'];
//                     $kursRp = $getTrx['kurs_rupiah'];
//                     $nilaiOrg = $getTrx['nilai_org'];
//                     $nilaiRph = $getTrx['nilai_rph'];
//                     $ketTrx = $getTrx['ket_transaksi'];
//                     $idCustomer = $getTrx['id_customer'];
//                     $noVoucher = $getTrx['no_voucher'];
//                     $tglRekam = date('Y-m-d', strtotime($getTrx['tgl_rekam']));
//                     $tglVoucher = date('Y-m-d', strtotime($getTrx['tgl_voucher']));
//                     $noJurnal = $getTrx['no_jurnal'];
//                     $tglJurnal = date('Y-m-d', strtotime($getTrx['tgl_jurnal']));
//                     $noDebitur = $getTrx['no_debitur'];
//                     $lineNo = $getTrx['line_no'];
//                     $debetKredit = $getTrx['debet_kredit'];
//                     $idUser = $getTrx['id_user'];
//                     $kodeKantor = $getTrx['kode_kantor'];
//                     $lineNoSkt = $getTrx['line_no_skt'];
//                     $idKantordb = $getTrx['id_kantordb'];
//                     $noRekening = $getTrx['no_rekening'];
//                     $idRBisnis = $getTrx['id_r_bisnis'];
//                     $idRBisnisT = $getTrx['id_r_bisnis_t'];

//                     // $insertToTrx = insertToTrx($idTrxPby, $idValuta, $idRGrupBisnis, $nomorSkt, $jenisPembayaran, $nomorDokumen, $tglDokumen, $tglRealisasi,
//                     //                             $kodeTrx, $kursRp, $nilaiOrg, $nilaiRph, $ketTrx, $idCustomer, $noVoucher, $tglRekam, $tglVoucher, $noJurnal,
//                     //                             $tglJurnal, $noDebitur, $lineNo, $debetKredit, $idUser, $kodeKantor, $lineNoSkt, $idKantordb, $noRekening, $idRBisnis,
//                     //                             $idRBisnisT);

//                     // if($insertToTrx){
//                     //     echo "Success";
//                     // }else {
//                     //     echo "Failed";
//                     //    echo("Error description: " . $insertToTrx -> error);
//                     // }

//                     // jalankan query subrogasi
//                     $querySubro = querySubrogasi($noBk, $noRekeningRc);
//                     $getSubro = sybase_fetch_array($querySubro);

//                     $idCustomer2 = $getSubro['id_customer'];
//                     $lineNo2 = $getSubro['line_no'];
//                     $idRBisnis2 = $getSubro['id_r_bisnis'];
//                     $idKlaim2 = $getSubro['id_klaim'];
//                     $noKlaim2 = $getSubro['no_klaim'];
//                     $tglKlaim2 = date('Y-m-d', strtotime($getSubro['tgl_klaim']));
//                     $idValuta2 = $getSubro['id_valuta'];
//                     $kursRp2 = $getSubro['kurs_rupiah'];
//                     $nilaiSubroOrg = $getSubro['nilai_subrogasi_org'];
//                     $nilaiSubroRp = $getSubro['nilai_subrogasi_rp'];
//                     $nilaiBakiDebet = $getSubro['nilai_baki_debet'];
//                     $cusIdCustomer = $getSubro['cus_id_customer'];
//                     $status2 = $getSubro['status'];
//                     $idSertifikat2 = $getSubro['id_sertifikat'];
//                     $noSertifikat2 = $getSubro['no_sertifikat'];
//                     $tahunNpp = $getSubro['tahun_npp'];
//                     $kodeIms = $getSubro['kode_ims'];
//                     $tglRekam2 = date('Y-m-d', strtotime($getSubro['tgl_rekam']));
//                     $akmRcov = $getSubro['akm_recov'];
//                     $platfondKredit = $getSubro['plafond_kredit'];
//                     $lineNoAsal = $getSubro['line_no_asal'];
//                     $idKantordb2 = $getSubro['id_kantordb'];
//                     $nomorDokumen2 = $getSubro['no_dokumen'];
//                     $noRekening2 = $getSubro['no_rekening'];
//                     $idRBisnisT2 = $getSubro['id_r_bisnis_t'];

//                     // $insertToSubro = insertToSubro($idCustomer2, $lineNo2, $idRBisnis2, $idKlaim2, $noKlaim2, $tglKlaim2, $idValuta2, $kursRp2,
//                     //                                 $nilaiSubroOrg, $nilaiSubroRp, $nilaiBakiDebet, $cusIdCustomer, $status2, $idSertifikat2, $noSertifikat2,
//                     //                                 $tahunNpp, $kodeIms, $tglRekam2, $akmRcov, $platfondKredit, $lineNoAsal, $idKantordb2, $nomorDokumen2,
//                     //                                 $noRekening2, $idRBisnisT2);            

//                     //  if($insertToSubro){
//                     //      echo "Success";
//                     //  }else {
//                     //      echo "Failed";
//                     //     echo("Error description: " . $insertToSubro -> error);
//                     //  }

//                     // jalankan query update status claim
//                     // $queryUpdate = queryUpdate($noRekeningRc);                                                

//                     // echo 'datanya match';
//                 } else {
//                     // rekening ada, tapi nilai klaim tidak sesuai
//                     $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'unmatch', detail = 'Nominal klaim tidak sesuai', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//                     // echo 'datanya tidak match';
//                 }
//             } else {
//                 // rekening tidak ditemukan
//                 $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'unmatch', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//             }


//             // update no BK dan no MM db AOS
//             $updateBkMm = mssql_query("UPDATE file_rc SET no_bk = '$noBk' ,no_mm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE id = '$fileId'", $con2);
//         } else {
//             // rekening tidak ditemukan
//             $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'unmatch', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con2);
//             // echo 'ga ada isinya';
//             // echo '<br>';
//         }
//     }
// }