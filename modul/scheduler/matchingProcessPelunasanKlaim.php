<?php

include '../../config/koneksi.php';
include '../../config/library.php';
include '../../config/koneksi_sakura.php';

$noRekeningRc = "";
$nominalRc = "";
$noFasilitasAwal = "";
$dataMatch = 0;
$dataUnmatch = 0;
$date = date("Y-m-d");
$tglRekKoran = "";
$rekTemp = "";
$ktrCabang = "";
$ismatchBrijamin = "";
$ismatchBrisurf = "";
$detail = "";
$remarkArr = array();
$noRekArr = array();
$queryGetDataRc = null;

// //koneksi DB AOS PROD sementara
//     $server 	= "10.20.10.16";
//     $user 		= "askrindo";
//     $password 	= "p@ssw0rd";
//     $database 	= "aos_kur_bri";
//     $db1 = mssql_connect($server,$user,$password, true);
//     mssql_select_db($database, $db1) or die ("Database tidak ditemukan");

// //koneksi DB AOS DEV sementara
// $server2     = "10.20.10.16";
// $user2         = "askrindo";
// $password2     = "p@ssw0rd";
// $database2     = "aos_kur_bri_dev";
// $con = mssql_connect($server2, $user2, $password2, true);
// mssql_select_db($database2, $con) or die("Database AOS tidak ditemukan");

$server3 = "10.20.10.16";
$username3 = "askrindo";
$password3 = "p@ssw0rd";
$database3 = "ASKRINDO_BRI_DEV";
$con3 = mssql_connect($server3, $username3, $password3, true);
mssql_select_db($database3, $con3) or die("Database tidak ditemukan");



function querySakuraRC($noRek, $connection)
{
    return sybase_query("SELECT detail_klaim_askred.no_rekening, 
    detail_klaim_askred.net_klaim_rp AS nilai_persetujuan_klaim,
    klaim.status
    FROM detail_klaim_askred, klaim
    WHERE detail_klaim_askred.no_rekening = '$noRek'
    AND detail_klaim_askred.status = '1'
    AND detail_klaim_askred.status_old IS NOT NULL
    AND detail_klaim_askred.id_klaim = klaim.id_klaim", $connection);
}

function cekMatchClaimConfirmation($remark, $connection)
{
    return mssql_query("SELECT * FROM askred_claim_confirmation acc LEFT JOIN askred_claim_feedback acf 
    ON acc.nomor_peserta = acf.nomor_peserta WHERE acc.status_klaim = 1 AND acc.remark ='" . $remark . "'", $connection);
}

function cekMatchDoubleRC($remark,  $connection)
{
    return mssql_query("SELECT * FROM mapping_rc_bri WHERE remark = '" . $remark . "'", $connection);
}

$queryGetFileRc = mssql_query("SELECT fr.id 
FROM file_rc fr 
WHERE fr.flag_status = '0' OR (SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE fr.id = mrb.id AND mrb.status = 0 and mrb.isposting = '0' ) > 0", $con);


$no = 1;
while ($fetchFileRc = mssql_fetch_array($queryGetFileRc)) {
    $fileId = $fetchFileRc['id'];
    $queryGetDataRc = mssql_query("SELECT id, no_rekening, nominal_klaim, tgl_rek_koran, cabang, remark FROM mapping_rc_bri WHERE id = '$fileId' AND (status = '3' OR isposting = '0')", $con);

    while ($dq = mssql_fetch_array($queryGetDataRc)) {
        $noRekeningRc = $dq['no_rekening'];
        $nominalRc = $dq['nominal_klaim'];
        $tglRekKoran = $dq['tgl_rek_koran'];
        $ktrCabang = $dq['cabang'];
        $remark = $dq['remark'];

        // filter dengan tabel tob AOS
        $querry = mssql_query("SELECT tob.no_fasilitas_awal FROM tob WHERE tob.no_fasilitas_baru = '$noRekeningRc'");
        if (mssql_num_rows($querry) > 0) {
            $noFasilitas = mssql_fetch_array($querry);
            $noRekeningRc = $noFasilitas['no_fasilitas_awal'];
        }

        $querySakuraRc = querySakuraRC($noRekeningRc, $con2);
        $countDataSakura = sybase_num_rows($querySakuraRc);
        $dataSakura =  sybase_fetch_array($querySakuraRc);

        // cek brijamin / brisurf
        if (strpos($remark, 'BRISURF') !== false) {
            // if ($countDataSakura > 0) {

            $cekCC = cekMatchClaimConfirmation($remark, $con3);
            $cekMatchDoubleMappingRC = cekMatchDoubleRC($remark, $con);

            if (mssql_num_rows($cekCC) > 0) {
                $dataCC = mssql_fetch_array($cekCC);
                if (!($dataCC['nominal_claim'] >= $nominalRc + 100
                    || $dataCC['nominal_claim'] <= $nominalRc - 100)) {
                    if (mssql_num_rows($cekMatchDoubleMappingRC) > 1) {
                        $ismatchBrisurf = '2';
                        $detail = 'klaim sudah dibayarkan';
                    } else {
                        if ($countDataSakura > 0) {
                            if ($dataSakura['status'] == '5') {
                                // status data sakura == 5
                                $ismatchBrisurf = '0';
                                $detail = 'klaim sudah dibayar';
                            } else if (!($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100
                                || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {
                                // match
                                $ismatchBrisurf = '1';
                                $detail = null;
                            } else {
                                // rekening ada, tapi nilai klaim tidak sesuai
                                $ismatchBrisurf = '0';
                                $detail = 'Nominal klaim tidak sesuai';
                            }
                        } else {
                            // echo "norek tdk ditemukan di sakura";
                            $ismatchBrisurf = '0';
                            $detail = 'Nomor Rekening tidak ditemukan';
                        }
                    }
                } else {
                    // rekening ada, tapi nilai klaim tidak sesuai
                    $ismatchBrisurf = '0';
                    $detail = 'Nominal klaim tidak sesuai dengan data Feedback';
                }
            } else {
                $ismatchBrisurf = '0';
                $detail = 'remark tidak ditemukan';
            }

            $update_date = date("Y-m-d H:i:s");
            mssql_query("UPDATE asf
            SET asf.is_match = '" . $ismatchBrisurf . "', asf.update_date = '" . $update_date . "'
            from askred_claim_feedback asf,  askred_claim_confirmation asv
            WHERE asf.nomor_peserta = asv.nomor_peserta
            AND asf.urutan_pengajuan = asv.urutan_pengajuan
            AND asv.remark = '" . $remark . "'", $con3);
            $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '$ismatchBrisurf', detail = '$detail'
            WHERE  remark = '" . $remark . "' AND id = '$fileId'", $con);
            // mssql_query("UPDATE mapping_rc_bri set ismatch = '$ismatch' WHERE remark = '" . $remark . "' AND id = '$fileId'");

        } else {
            // $querySakuraRc = querySakuraRC($noRekeningRc);
            if ($countDataSakura > 0) {
                //cek data apakah sudah pernah di posting dalam tabel mapping
                $cekTableRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE no_rekening ='$noRekeningRc' AND id = '$fileId' AND mapping_date IS NOT NULL", $con);
                $dataTableRc = mssql_fetch_array($cekTableRc);
                if ($dataTableRc) {
                    // rekening sudah di posting (match-double)
                    $ismatchBrijamin = '2';
                    $detail = 'klaim sudah dibayarkan';
                    // $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET status = '0', detail = 'klaim sudah dibayarkan' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
                } elseif ($dataSakura['no_rekening'] != NULL) {
                    if ($dataSakura['status'] == '5') {
                        // rekening sudah pernah dibayar (update status dan detail aja)
                        $ismatchBrijamin = '0';
                        $detail = 'klaim sudah dibayar';
                    } elseif ($dataSakura['no_rekening'] == $noRekeningRc && !($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100
                        || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {
                        // jika data match
                        $ismatchBrijamin = '1';
                        $detail = null;
                    } else {
                        // rekening ada, tapi nilai klaim tidak sesuai
                        $ismatchBrijamin = '0';
                        $detail = 'Nominal klaim tidak sesuai';
                    }
                } else {
                    // rekening tidak ditemukan di sakura
                    $ismatchBrijamin = '0';
                    $detail = 'Nomor rekening tidak ditemukan';
                }
            } else {
                // rekening tidak ditemukan di sakura
                $ismatchBrijamin = '0';
                $detail = 'Nomor rekening tidak ditemukan';
            }

            $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '$ismatchBrijamin', detail = '$detail'
            WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con);


            // $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = ' $ismatchBrijamin', detail = '$detail'
            // WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'", $con);
        }
    }
}


$queryGetDataRc2 = mssql_query("SELECT id, no_rekening, nominal_klaim, tgl_rek_koran, cabang FROM mapping_rc_bri WHERE id = '$fileId' AND status = '3'", $con);
if (mssql_num_rows($queryGetDataRc2) <= 0) {
    //update flag status ready posting     
    mssql_query("UPDATE file_rc SET flag_status = '1' WHERE id = '$fileId'", $con);
}

//update no cl for match data
mssql_query("UPDATE mrb set mrb.no_cl = jkkg.no_klaim
    FROM mapping_rc_bri mrb inner join jawaban_klaim_kur_gen2 jkkg 
    ON mrb.no_rekening = jkkg.no_rekening 
    WHERE status = '1'", $con);


// ========================================================================recon mas fadly===================================================================================================================

                    // while ($noFasilitas =  mssql_fetch_array($querry)){
            // $noFasilitas = mssql_fetch_array($querry);
            // if ($noFasilitas['no_fasilitas_awal'] != NULL) {
            //     $noFasilitasAwal = $noFasilitas['no_fasilitas_awal'];

            // rekon no fasilitas awal dengan data sakura
            // $queryAOS = queryAOSRC($noFasilitasAwal);
            // if (sybase_num_rows($queryAOS) > 0) {
            //     $dataSakura =  sybase_fetch_array($queryAOS);

            //     $cekTableRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE no_rekening ='$noFasilitasAwal' AND id = '$fileId' AND noBk IS NOT NULL");
            //     $dataTableRc = mssql_fetch_array($cekTableRc);
            //     if ($dataTableRc) {
            //         // rekening sudah di posting 
            //         $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET status = '0', detail = 'klaim sudah dibayarkan' WHERE no_rekening = '$noFasilitasAwal' AND id = '$fileId'");
            //     } elseif ($dataSakura['no_rekening'] != NULL) {
            //         if ($dataSakura['status'] == '5') {
            //             // rekening sudah pernah dibayar
            //             $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = '0', detail = 'klaim sudah dibayar', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
            //         } elseif ($dataSakura['no_rekening'] == $noFasilitasAwal && !($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100 || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {

            //             // jika data match
            //             // $selectNoCl = mssql_query("SELECT no_klaim FROM  jawaban_klaim_kur_gen2 WHERE no_rekening = '$noFasilitasAwal'", $db1);
            //             // $FetchnoCl = mssql_fetch_array($selectNoCl);
            //             // $noCl = $FetchnoCl['no_klaim'];
            //             // $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = 'match', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm', no_cl = '$noCl' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
            //             $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = '1', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
            //         } else {
            //             // rekening ada, tapi nilai klaim tidak sesuai
            //             $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = '0', detail = 'Nominal klaim tidak sesuai', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
            //             // echo 'datanya tidak match';
            //         }
            //     } else {
            //         // rekening tidak ditemukan
            //         $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', no_rekening = '$noFasilitasAwal', status = '0', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
            //     }
            // }
            // $updateBkMm = mssql_query("UPDATE file_rc SET no_bk = '$noBk' ,no_mm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE id = '$fileId'");
        // }

        //jika no rekening tidak sama dengan no fasilitas awal dalam tabel AOS
        // } 
        // else {
        //     $queryAOSRc = queryAOSRC($noRekeningRc);
        //     if (sybase_num_rows($queryAOSRc) > 0) {
        //         $dataSakura =  sybase_fetch_array($queryAOSRc);

        //         //cek data apakah sudah pernah di posting dalam tabel mapping
        //         $cekTableRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE no_rekening ='$noRekeningRc' AND id = '$fileId' AND noBk IS NOT NULL");
        //         $dataTableRc = mssql_fetch_array($cekTableRc);
        //         if ($dataTableRc) {
        //             // rekening sudah di posting 
        //             $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET status = '0', detail = 'klaim sudah dibayarkan' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //         } elseif ($dataSakura['no_rekening'] != NULL) {

        //             if ($dataSakura['status'] == '5') {
        //                 // rekening sudah pernah dibayar
        //                 $inserDataExist = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '0', detail = 'Klaim sudah dibayar', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //             } elseif ($dataSakura['no_rekening'] == $noRekeningRc && !($dataSakura['nilai_persetujuan_klaim'] >= $nominalRc + 100 || $dataSakura['nilai_persetujuan_klaim'] <= $nominalRc - 100)) {
        //                 // jika data match
        //                 // $selectNoCl = mssql_query("SELECT no_klaim FROM  jawaban_klaim_kur_gen2 WHERE no_rekening = '$noRekeningRc'", $db1);
        //                 // $FetchnoCl = mssql_fetch_array($selectNoCl);
        //                 // $noCl = $FetchnoCl['no_klaim'];
        //                 // $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = 'match', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm', no_cl = '$noCl' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //                 $insertDataMatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '1', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //             } else {
        //                 // rekening ada, tapi nilai klaim tidak sesuai
        //                 $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '0', detail = 'Nominal klaim tidak sesuai', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //                 // echo 'datanya tidak match';
        //             }
        //         } else {
        //             // rekening tidak ditemukan
        //             $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '0', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //         }
        //     } else {
        //         // rekening tidak ditemukan
        //         $inserDataUnmatch = mssql_query("UPDATE mapping_rc_bri SET mapping_date = '$date', status = '0', detail = 'Nomor rekening tidak ditemukan', noBk = '$noBk', noMm = '$noMm', tgl_bk = '$tglBk', tgl_mm = '$tglMm' WHERE no_rekening = '$noRekeningRc' AND id = '$fileId'");
        //         // echo 'ga ada isinya';
        //         // echo '<br>';
        //     }
        // }