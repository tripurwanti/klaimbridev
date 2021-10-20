<?php
error_reporting(0);
// include "../config/koneksi_askred.php";
include "../config/koneksi.php";
// include "../js/jquery.min.js";


$server3 = "10.20.10.16";
$username3 = "askrindo";
$password3 = "p@ssw0rd";
$database3 = "ASKRINDO_BRI_DEV";
$con3 = mssql_connect($server3, $username3, $password3, true);
mssql_select_db($database3, $con3) or die("Database tidak ditemukan");


$norekPinjaman = $_GET[no_fasilitas];
$sumberklaim = $_GET[sumberklaim];
$statusKlaim = $_GET[q];
$dataKlaim = mssql_query("SELECT * FROM pengajuan_klaim_kur_gen2 WHERE no_rekening ='" . $_GET[no_fasilitas] . "'", $con);
$rDataKlaim  = mssql_num_rows($dataKlaim);
$dDataKlaim = mssql_fetch_array($dataKlaim);

?>

<label style="font-size: 1em;"><b>No. Rekening:
        <?php echo $dDataKlaim['no_rekening']; ?> </b></label><br />
<?php
if ($statusKlaim == '2' || $statusKlaim == '4') {
?>
<label style="font-size: 1em;"><b>Dokumen Analisa: <?php
                                                        if ($dDataKlaim['flag_dokumen'] == '0') {
                                                            echo "Dokumen Lengkap Manual";
                                                        } else if ($dDataKlaim['flag_dokumen'] == '1') {
                                                            echo "Dokumen Lengkap";
                                                        }

                                                        ?></b></label><br />

<?php
}
if ($statusKlaim == '0') {
?>

<!-- <hr style="width:50%;text-align:left;margin-left:0"> -->


<label style="font-size: 0.9em;margin-top: 10px; "><b>Unggah Dokumen</b></label><br />
<div style="border: 2px solid #f0f0f0; border-radius: 5px; margin-top: 10px; padding: 10px; background-color:#f0f0f0">

    <form action="modul/pengajuanclaim/prosesUploadDocument.php" method="POST" enctype="multipart/form-data"
        onsubmit="return fileValidationFilePdf()">
        <!-- onsubmit="return Validate(this);"> -->
        <!-- <form action="" method="POST" enctype="multipart/form-data"> -->
        <!-- <form method="POST" id="formUpload"> -->
        <input id='norekPinjaman' type="hidden" name="no_rekening_pinjaman" value="<?php echo $_GET[no_fasilitas]; ?>">
        <table class="table">
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen LKN</label>
                </td>
                <td colspan="2">
                    <input id="dok_lkn" type="file" class="form-control" name="dok_lkn" value="Dokumen LKN">
                    <span style="color: red; font-size: 13px;" id="msgerrorlkn"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SPH</label>
                </td>
                <td colspan="2">
                    <input id="dok_sph" type="file" class="form-control" name="dok_sph" value="Dokumen SPH">
                    <span style="color: red; font-size: 13px;" id="msgerrorsph"></span>

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">KTP</label>
                </td>
                <td colspan="2">
                    <input id="ktp" type="file" class="form-control" name="ktp" value="KTP">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SLIK</label>
                </td>
                <td colspan="2">
                    <input id="dok_slik" type="file" class="form-control" name="dok_slik" value="Dokumen SLIK"
                        onchange="return fileValidationFilePdf()">
                    <span style="color: red; font-size: 13px;" id="msgerrorslik"></span>

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SKU</label>
                </td>
                <td colspan="2">
                    <input id="dok_sku" type="file" class="form-control" name="dok_sku" value="Dokumen SKU"
                        onchange="return fileValidationFilePdf()">
                    <span style="color: red; font-size: 13px;" id="msgerrorsku"></span>

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Rekening Koran</label>
                </td>
                <td colspan="2">
                    <input id="dok_rc" type="file" class="form-control" name="dok_rc" value="Dokumen SKU"
                        onchange="return fileValidationFilePdf()">
                    <span style="color: red; font-size: 13px;" id="msgerrorrc"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen Tambahan</label>
                </td>
                <td>
                    <input id="dok_additional" type="file" class="form-control" name="dok_additional"
                        value="Dokumen Tambahan" onchange="return fileValidationFilePdf()">
                    <span style="color: red; font-size: 13px;" id="msgerroradditional"></span>

                </td>
                <td>
                    <input id="dokumenname" type="text" class="form-control" name="dokumenname" value="Nama Dokumen">

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input style="margin-top: 10px;" class='btn btn-primary btn-sm' type="submit" value="Unggah"
                        name="submit">
                </td>

            </tr>

        </table>

    </form>
</div>
<?php


    $qDinfoDokSph = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = 'sph';", $con3);
    $nqDinfoDokSph = mssql_num_rows($qDinfoDokSph);

    $qDinfoDokLkn = mssql_query(
        "SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = 'lkn';",
        $con3
    );
    $nqDinfoDokLkn = mssql_num_rows($qDinfoDokLkn);
    ?>

<label style=" font-size: 0.9em;margin-top: 20px; "><b>Dokumen Lengkap</b></label><br />
<div style=" border: 2px solid #f0f0f0; border-radius: 5px; margin-top: 10px; padding: 10px; background-color:#f0f0f0">

    <form action="modul/pengajuanclaim/prosesVerifikasiDocBrisurf.php" method="POST"
        onsubmit="return confirm('Data Sudah Benar?');">

        <input type="hidden" name="no_fasilitas" value="<?php echo $_GET[no_fasilitas]; ?>">
        <input type="hidden" name="plafond" value="<?php echo $_GET[plafond]; ?>">
        <input type="hidden" name="tgl_mulai" value="<?php echo $_GET[tgl_mulai]; ?>">
        <input type="hidden" name="jml_tuntutan" value="<?php echo $_GET[jml_tuntutan]; ?>">
        <div class="form-group">
            <br />
            <!-- <br /> -->
            <!-- <label style="font-size: 0.9em;"><b>No. Rekening: <?php echo $_GET[no_fasilitas]; ?> </b></label><br /><br /> -->
            <?php
                // $qD = mssql_query("SELECT * FROM r_kode_dokumen_klaim a, bri_dokumen b WHERE a.kode = b.kode_dokumen AND no_fasilitas = '$_GET[no_fasilitas]' ORDER BY a.nama ASC;");

                $qD = mssql_query("SELECT * FROM askred_dokumen_claim WHERE kode_dokumen_digital in ('ktp', 'slik', 'data_usaha', 'lkn', 'sph', 'additional') ORDER BY id ASC;");
                $nqD = mssql_num_rows($qD);


                $dataDokumenAvailable[] = array();
                // if ($nqD > 0) {
                ?>
            <table>
                <!-- <tr>
                    <td colspan="3"><small><b>Dokumen Lengkap</b></small></td>
                </tr> -->
                <?php
                    while ($dqD = mssql_fetch_array($qD)) {
                    ?>
                <tr>
                    <input type="hidden" name="banyak_dokumen" value="<?php echo $nqD; ?>">
                    <?php
                            $qDinfo = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = '$dqD[kode_dokumen_digital]';");
                            $nqDinfo = mssql_num_rows($qDinfo);
                            // $dqDinfo = mssql_fetch_array($qDinfo);
                            $qDinfoCount = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman';");
                            $nqDinfoCount = mssql_num_rows($qDinfoCount);
                            ?>
                    <td>
                        <div class="checkbox-inline1">
                            <label style="font-weight: normal; font-size: 0.9em;">
                                <?php
                                        $disabled = "";
                                        if ($_GET['q'] == 0 && $nqDinfo > 0) {
                                            if ($dqD['kode_dokumen_digital'] != "additional") {
                                                $dataDokumenAvailable[] = $dqD['kode_dokumen_digital'];
                                            }
                                            $disabled = "";
                                        } else if ($_GET['q'] == 0 && $nqDinfo <= 0) {
                                            if ($dqD['kode_dokumen_digital'] != "additional") {
                                                $disabled = "disabled";
                                            }
                                        } else {
                                            $disabled = "disabled";
                                        }
                                        ?>

                    </td>
                    <td>
                        <input type="hidden" name="textDokumenLengkap[<?php echo $dqD[kode_dokumen_digital]; ?>]"
                            value="<?php echo $dqD[kode_dokumen_digital]; ?>" />

                        <input type="checkbox" name="cekDokumenLengkap[<?php echo $dqD[kode_dokumen_digital]; ?>]"
                            value="doklengkap" <?php echo $disabled; ?>>
                        <?php //echo  " [" . $dqD[kode_dokumen_digital] . "]"; 
                                ?>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo $dqD[dokumen_claim]; ?>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo " [" . $dqD[kode_dokumen_digital] . "]"; ?>
                    </td>
                    <td>
                        &nbsp;<input type="hidden" style="height: 20px;"
                            name="textDokumen[<?php echo $dqD[kode_dokumen]; ?>]">
                    </td>
                    <td>
                        &nbsp;&nbsp;
                        <?php
                                if ($nqDinfo > 0) {
                                ?>
                        <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                            style="float:right;" title="Klik untuk mendownload Dokumen"><i class="fa fa-download"></i>
                        </a>
                        <?php
                                } else {
                                ?>
                        <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                            style="float:right;  pointer-events: auto; color: #ccc; cursor: default;"
                            title="Dokumen tidak tersedia untuk di download">
                            <i class="fa fa-download"></i>
                        </a>
                        <?php
                                }
                                ?>

                        </label>
        </div>
        </td>

        <?php
                    }
        ?>

        </tr>
        <tr>
            <td>
                <div class="checkbox-inline1">
                    <label style="font-weight: normal; font-size: 0.9em;"><?php

                                                                            $qDinfoRcUpload = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = 'Rc';");
                                                                            $nqDinfoRcUpload = mssql_num_rows($qDinfoRcUpload);

                                                                            $qDinfoRcRaw = mssql_query("SELECT ark.* FROM askred_rekening_koran ark
                                                                        INNER JOIN askred_claim_confirmation acc ON ark.id_claim_confirmation = acc.id
                                                                        WHERE acc.nomor_peserta = '$norekPinjaman'");
                                                                            $nqDinfoRcRaw = mssql_num_rows($qDinfoRcRaw);

                                                                            if ($_GET['q'] == 0 && ($nqDinfoRcUpload > 0 || $nqDinfoRcRaw > 0)) {
                                                                                $disabledCheckboxRC = "";
                                                                            } else if ($_GET['q'] == 0 && $nqDinfoRcUpload <= 0 && $nqDinfoRcRaw <= 0) {
                                                                                $disabledCheckboxRC = "disabled";
                                                                            } else {
                                                                                $disabledCheckboxRC = "disabled";
                                                                            }
                                                                            ?>

            </td>
            <td>
                <input type="hidden" name="textDokumenLengkap[RC]" value="RC" />
                <input type="checkbox" name="cekDokumenLengkap[RC]" value="doklengkap"
                    <?php echo $disabledCheckboxRC; ?>>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo "Rekening Koran" ?>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo " [RC]"; ?>
            </td>
            <td>
                &nbsp;<input type="hidden" style="height: 20px;" name="textDokumen[RC]">
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                    href="media.php?module=listRCClaimConfirmation&norek=<?php echo $norekPinjaman;  ?>"
                    style="float:right;" target="_blank" title="Daftar Rekening Koran"><i class="fa fa-list"></i></a>
                </label>
            </td>
        </tr>
        <!-- <tr>
            <td>
                <div class="checkbox-inline1">
                    <label style="font-weight: normal; font-size: 0.9em;">

            </td>
            <td>
                <input type="hidden" name="cekDokumenAdditional[additional]" value="additional" />
                <input type="checkbox" name="cekDokumenAdditional[additional]" value="x"
                    <?php echo $disabledCheckboxRC; ?>>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo "Dokumen Tambahan"
                            ?>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo " [dokumen tambahan]";
                            ?>
            </td>
            <td>
                &nbsp;<input type="hidden" style="height: 20px;" name="textDokumen[additional]">
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                    style="float:right;" title="Klik untuk mendownload Dokumen"><i class="fa fa-download"></i>
                </a>
                </label>
            </td>
        </tr> -->

        <tr>
            <td>
                <div class="checkbox-inline1">
                    <label style="font-weight: normal; font-size: 0.9em;">

            </td>
            <td>
                <input type="hidden" name="textDokumenLengkap[ReportPayoff]" value="reportpayoff" />
                <input type="checkbox" name="cekDokumenLengkap[ReportPayoff]" value="doklengkap">
            </td>
            <td>
                &nbsp;&nbsp;<?php echo "Report Payoff" ?>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo " [reportpayoff]"; ?>
            </td>
            <td>
                &nbsp;<input type="hidden" style="height: 20px;" name="textDokumen[reportpayoff]">
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                    style="float:right;" title="Klik untuk mendownload Dokumen"><i class="fa fa-download"></i>
                </a>
                </label>
            </td>
        </tr>

        </table>

        <?php
        // } else {
        ?>
        <!-- <div class="checkbox-inline1">
            <label style="font-weight: normal; font-size: 0.9em;">
                <input type="checkbox" name="tidakAdaDokumen" value="1" checked>
                Tidak ada Dokumen! &nbsp;
            </label>
        </div> -->
        <?php
        // }
        ?>

</div>
<?php
    // var_dump($dataDokumenAvailable);
    // echo count($dataDokumenAvailable);
    if ((count($dataDokumenAvailable) - 1) < 5 ||  $disabledCheckboxRC == "disabled") {
        echo "<button type='submit'  name='doklengkap' class='btn btn-primary' disabled >Dokumen Lengkap</button>&nbsp;";
    } else {
        echo "<button type='submit'  name='doklengkap' class='btn btn-primary'>Dokumen Lengkap</button>&nbsp;";
    }
    // else if ($_GET['q'] == 3) {
    //     echo "<button type='submit' name='doklengkapManual' class='btn btn-danger'>Dokumen Lengkap Manual!</button>";
    // }
    ?>
</form>
</div>
</div>

<label style="font-size: 0.9em;margin-top: 20px; "><b>Dokumen Tidak Lengkap</b></label><br />
<div style="border: 2px solid #f0f0f0; border-radius: 5px; margin-top: 10px; padding: 10px; background-color:#f0f0f0">
    <form action="modul/pengajuanclaim/prosesVerifikasiDocBrisurf.php" method="POST"
        onsubmit="return confirm('Data Sudah Benar?');">
        <input type="hidden" name="no_fasilitas" value="<?php echo $_GET[no_fasilitas]; ?>">
        <input type="hidden" name="plafond" value="<?php echo $_GET[plafond]; ?>">
        <input type="hidden" name="tgl_mulai" value="<?php echo $_GET[tgl_mulai]; ?>">
        <input type="hidden" name="jml_tuntutan" value="<?php echo $_GET[jml_tuntutan]; ?>">
        <div class="form-group">
            <br />
            <!-- <br /> -->
            <!-- <label style="font-size: 0.9em;"><b>No. Rekening: <?php echo $_GET[no_fasilitas]; ?> </b></label><br /><br /> -->
            <?php
                // $qD = mssql_query("SELECT * FROM r_kode_dokumen_klaim a, bri_dokumen b WHERE a.kode = b.kode_dokumen AND no_fasilitas = '$_GET[no_fasilitas]' ORDER BY a.nama ASC;");

                $qD = mssql_query("SELECT * FROM askred_dokumen_claim WHERE kode_dokumen_digital in ('ktp', 'slik', 'data_usaha', 'lkn', 'sph') ORDER BY id ASC;");
                $nqD = mssql_num_rows($qD);
                // if ($nqD > 0) {
                ?>
            <table>
                <!-- <tr>
                    <td colspan="3"><small><b>Dokumen Lengkap</b></small></td>
                </tr> -->
                <?php
                    while ($dqD = mssql_fetch_array($qD)) {
                        $qDinfo2 = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = '$dqD[kode_dokumen_digital]';");
                        $nqDinfo2 = mssql_num_rows($qDinfo2);
                        $qDinfoCount2 = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman';");
                        $nqDinfoCount2 = mssql_num_rows($qDinfoCount2);

                        // echo $dqD['kode_dokumen_digital'] . "-" . $nqDinfo2;
                    ?>
                <tr>
                    <input type="hidden" name="banyak_dokumen" value="<?php echo $nqD; ?>">
                    <td>
                        <div class="checkbox-inline1">
                            <label style="font-weight: normal; font-size: 0.9em;">
                                <?php
                                        $q = mssql_query("SELECT ark.* FROM askred_rekening_koran ark
                                   INNER JOIN askred_claim_confirmation acc ON ark.id_claim_confirmation = acc.id
                                   WHERE acc.nomor_peserta = '" . $norekPinjaman . "'");

                                        if ($_GET['q'] == 0 && $nqDinfo2 <= 0) {
                                            $disabled = "";
                                        } else {
                                            if ($n <= 0) {
                                                $disabled = "disabled";
                                            }
                                            $disabled = "disabled";
                                        }
                                        ?>
                        </div>

                    </td>
                    <td>
                        <input type="hidden" name="textDokumenTdkLengkap[<?php echo $dqD[kode_dokumen_digital]; ?>]"
                            value="<?php echo $dqD[kode_dokumen_digital]; ?>" />

                        <input type="checkbox" name="cekDokumenTdkLengkap[<?php echo $dqD[kode_dokumen_digital]; ?>]"
                            value="dokumenTdkLengkap" <?php echo $disabled; ?>>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo $dqD[dokumen_claim]; ?>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo " [" . $dqD[kode_dokumen_digital] . "]"; ?>
                    </td>
                    </label>


                    <?php
                    }
                        ?>

                </tr>
                <tr>

                    <?php
                            $disabledCheckboxRCTdkLengkap = "";
                            $qDinfoRcUpload = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = 'Rc';");
                            $nqDinfoRcUpload = mssql_num_rows($qDinfoRcUpload);

                            $qDinfoRcRaw = mssql_query("SELECT ark.* FROM askred_rekening_koran ark
                        INNER JOIN askred_claim_confirmation acc ON ark.id_claim_confirmation = acc.id
                        WHERE acc.nomor_peserta = '$norekPinjaman'");
                            $nqDinfoRcRaw = mssql_num_rows($qDinfoRcRaw);

                            if ($nqDinfoRcUpload <= 0 && $nqDinfoRcRaw <= 0) {
                                $disabledCheckboxRCTdkLengkap = "";
                            } else if ($nqDinfoRcUpload > 0 || $nqDinfoRcRaw > 0) {
                                $disabledCheckboxRCTdkLengkap = "disabled";
                            }

                            ?>
                    <td>
                        <div class="checkbox-inline1">
                            <label style="font-weight: normal; font-size: 0.9em;">
                        </div>

                    </td>
                    <td>
                        <input type="hidden" name="textDokumenTdkLengkap[RC]" value="RC" />
                        <input type="checkbox" name="cekDokumenTdkLengkap[RC]" value="dokumenTdkLengkap"
                            <?php echo $disabledCheckboxRCTdkLengkap; ?>>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo "Rekening Koran" ?>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo " [RC]"; ?>
                    </td>

                </tr>
            </table>
            <br>

            <?php

                if ($nqDinfoCount2 < 5 || ($nqDinfoRcUpload <= 0 && $nqDinfoRcRaw <= 0)) {
                    echo "<button type='submit' name='dokTidakLengkap' class='btn btn-danger'>Dokumen Tidak Lengkap</button>&nbsp;";
                    echo "<button type='submit' name='dokLengkapManual' class='btn btn-success'>Dokumen Lengkap Manual</button>";
                } else {
                    echo "<button type='submit' name='dokTidakLengkap' class='btn btn-danger' disabled>Dokumen Tidak Lengkap</button>&nbsp;";
                    echo "<button type='submit' name='dokLengkapManual' class='btn btn-success' disabled>Dokumen Lengkap Manual</button>";
                }
                ?>
    </form>
</div>
</div>

<?php
} else {
?>
<div style=" border: 2px solid #f0f0f0; border-radius: 5px; margin-top: 10px; padding: 10px; background-color:#f0f0f0">

    <form action="modul/pengajuanclaim/prosesVerifikasiDocBrisurf.php" method="POST"
        onsubmit="return confirm('Data Sudah Benar?');">

        <input type="hidden" name="no_fasilitas" value="<?php echo $_GET[no_fasilitas]; ?>">
        <input type="hidden" name="plafond" value="<?php echo $_GET[plafond]; ?>">
        <input type="hidden" name="tgl_mulai" value="<?php echo $_GET[tgl_mulai]; ?>">
        <input type="hidden" name="jml_tuntutan" value="<?php echo $_GET[jml_tuntutan]; ?>">
        <div class="form-group">
            <br />
            <!-- <br /> -->
            <!-- <label style="font-size: 0.9em;"><b>No. Rekening: <?php echo $_GET[no_fasilitas]; ?> </b></label><br /><br /> -->
            <?php
                $qD2 = mssql_query("SELECT * FROM r_kode_dokumen_klaim a, bri_dokumen b WHERE a.kode = b.kode_dokumen AND no_fasilitas = '$_GET[no_fasilitas]' ORDER BY a.nama ASC;");

                $qD2 = mssql_query("SELECT * FROM askred_dokumen_claim WHERE kode_dokumen_digital in ('ktp', 'slik', 'data_usaha', 'lkn', 'sph', 'additional') ORDER BY id ASC;");
                $nqD2 = mssql_num_rows($qD2);


                // $dataDokumenAvailable[] = array();
                // if ($nqD > 0) {
                ?>
            <table>
                <!-- <tr>
                    <td colspan="3"><small><b>Dokumen Lengkap</b></small></td>
                </tr> -->
                <?php
                    while ($dqD = mssql_fetch_array($qD2)) {
                    ?>
                <tr>
                    <input type="hidden" name="banyak_dokumen" value="<?php echo $nqD; ?>">
                    <?php
                            $qDinfo = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman' AND kode_dokumen = '$dqD[kode_dokumen_digital]';");
                            $nqDinfo = mssql_num_rows($qDinfo);
                            // $dqDinfo = mssql_fetch_array($qDinfo);
                            $qDinfoCount = mssql_query("SELECT * FROM askred_dokumen_info WHERE no_rekening_pinjaman = '$norekPinjaman';");
                            $nqDinfoCount = mssql_num_rows($qDinfoCount);
                            ?>
                    <td>
                        <div class="checkbox-inline1">
                            <label style="font-weight: normal; font-size: 0.9em;">
                                <?php
                                        $disabled = "";
                                        if ($_GET['q'] == 0 && $nqDinfo > 0) {
                                            if ($dqD['kode_dokumen_digital'] != "additional") {
                                                $dataDokumenAvailable[] = $dqD['kode_dokumen_digital'];
                                            }
                                            $disabled = "";
                                        } else if ($_GET['q'] == 0 && $nqDinfo <= 0) {
                                            if ($dqD['kode_dokumen_digital'] != "additional") {
                                                $disabled = "disabled";
                                            }
                                        } else {
                                            $disabled = "disabled";
                                        }
                                        ?>

                    </td>

                    <td>
                        &nbsp;&nbsp;<?php echo $dqD[dokumen_claim]; ?>
                    </td>
                    <td>
                        &nbsp;&nbsp;<?php echo " [" . $dqD[kode_dokumen_digital] . "]"; ?>
                    </td>
                    <td>
                        &nbsp;<input type="hidden" style="height: 20px;"
                            name="textDokumen[<?php echo $dqD[kode_dokumen]; ?>]">
                    </td>
                    <td>
                        &nbsp;&nbsp;
                        <?php
                                if ($nqDinfo > 0) {
                                ?>
                        <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                            style="float:right;" title="Klik untuk mendownload Dokumen"><i class="fa fa-download"></i>
                        </a>
                        <?php
                                } else {
                                ?>
                        <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                            style="float:right;  pointer-events: auto; color: #ccc; cursor: default;"
                            title="Dokumen tidak tersedia untuk di download">
                            <i class="fa fa-download"></i>
                        </a>
                        <?php
                                }
                                ?>

                        </label>
        </div>
        </td>

        <?php
                    }
        ?>

        </tr>
        <tr>
            <td>
                <div class="checkbox-inline1">
                    <label style="font-weight: normal; font-size: 0.9em;"><?php

                                                                            if ($_GET['q'] == 0 && ($nqDinfoRcUpload > 0 || $nqDinfoRcRaw > 0)) {
                                                                                $disabledCheckboxRC = "";
                                                                            } else if ($_GET['q'] == 0 && $nqDinfoRcUpload <= 0 && $nqDinfoRcRaw <= 0) {
                                                                                $disabledCheckboxRC = "disabled";
                                                                            } else {
                                                                                $disabledCheckboxRC = "disabled";
                                                                            }
                                                                            ?>

            </td>
            <td>
                &nbsp;&nbsp;<?php echo "Rekening Koran" ?>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo " [RC]"; ?>
            </td>
            <td>
                &nbsp;<input type="hidden" style="height: 20px;" name="textDokumen[RC]">
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                    href="media.php?module=listRCClaimConfirmation&norek=<?php echo $norekPinjaman;  ?>"
                    style="float:right;" target="_blank" title="Daftar Rekening Koran"><i class="fa fa-list"></i></a>
                </label>
            </td>
        </tr>


        <tr>
            <td>
                <div class="checkbox-inline1">
                    <label style="font-weight: normal; font-size: 0.9em;">

            </td>
            <td>
                &nbsp;&nbsp;<?php echo "Report Payoff" ?>
            </td>
            <td>
                &nbsp;&nbsp;<?php echo " [reportpayoff]"; ?>
            </td>
            <td>
                &nbsp;<input type="hidden" style="height: 20px;" name="textDokumen[reportpayoff]">
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="modul/pengajuanclaim/downloadDocBrisurf.php?no_rek=<?php echo $norekPinjaman; ?>&kode=<?php echo $dqD[kode_dokumen_digital]; ?>"
                    style="float:right;" title="Klik untuk mendownload Dokumen"><i class="fa fa-download"></i>
                </a>
                </label>
            </td>
        </tr>

        </table>



</div>
</div>
<?php
}
?>

<hr />
<b>History</b><br />
<small>
    <table class="table display nowrap">

        <?php
        $qH = mssql_query("SELECT * FROM history_jawaban_klaim_kur_gen2_bri WHERE no_rekening = '$norekPinjaman' ORDER BY id DESC;", $con);
        while ($dqH = mssql_fetch_array($qH)) {
            echo "
		<tr>
			<td>$dqH[created_date] - <small>Status BRI: $dqH[status_bri]</small><br/>$dqH[ket]</td>
		</tr>";
        }
        ?>
    </table>
</small>


<script type="text/javascript" language="javascript">
function fileValidationFilePdf() {
    // var fileInputLkn = document.getElementById('dok_lkn');
    // var filePathLkn = fileInputLkn.value;

    // var fileInputSph = document.getElementById('dok_sph');
    // var filePathSph = fileInputSph.value;

    // // Allowing file type
    // // var allowedExtensions =
    // //     /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    // var msgerror = "Tipe file yang harus diunggah harus .pdf";
    // var allowedExtensions =
    //     /(\.pdf)$/i;

    // // if (fileInputLkn.files.length != 0) {
    // if (!allowedExtensions.exec(filePathLkn)) {
    //     $("#msgerrorlkn").text("Tipe file yang harus diunggah harus .pdf");
    //     // alert('Invalid file type');
    //     filePathLkn.value = '';
    //     return false;
    // } else {
    //     $("#msgerrorlkn").text("");
    //     // alert('Invalid file type');
    //     filePathLkn.value = '';
    //     return true;
    // }

    // if (!allowedExtensions.exec(filePathSph)) {
    //     $("#msgerrorsph").text("Tipe file yang harus diunggah harus .pdf");
    //     // alert('Invalid file type');
    //     filePathSph.value = '';
    //     return false;
    // } else {
    //     $("#msgerrorsph").text("");
    //     // alert('Invalid file type');
    //     filePathSph.value = '';
    //     return true;
    // }
    // }


}
</script>