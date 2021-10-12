<?php
error_reporting(0);
include "../config/koneksi.php";

?>
<form action="proses.php" method="POST" onsubmit="return confirm('Data Sudah Benar?');">
    <input type="hidden" name="no_fasilitas" value="<?php echo $_GET[no_fasilitas]; ?>">
    <input type="hidden" name="plafond" value="<?php echo $_GET[plafond]; ?>">
    <input type="hidden" name="tgl_mulai" value="<?php echo $_GET[tgl_mulai]; ?>">
    <div class="form-group">
        <label style="font-size: 0.9em;"><b>No. Rekening: <?php echo $_GET[no_fasilitas]; ?> </b></label><br /><br />
        <?php
        $qD = mssql_query("SELECT * FROM r_kode_dokumen_klaim a, bri_dokumen b WHERE a.kode = b.kode_dokumen AND no_fasilitas = '$_GET[no_fasilitas]' ORDER BY a.nama ASC;");
        $nqD = mssql_num_rows($qD);
        if ($nqD > 0) {
        ?>
        <table>
            <tr>
                <td><small><b>Dokumen</b></small></td>
                <td><small><b>Keterangan</b> (Diisi Jika tidak diceklis)</small></td>
            </tr>
            <?php
                while ($dqD = mssql_fetch_array($qD)) {
                ?>
            <tr>
                <td>
                    <input type="hidden" name="banyak_dokumen" value="<?php echo $nqD; ?>">
                    <div class="checkbox-inline1">
                        <label style="font-weight: normal; font-size: 0.9em;">
                            <?php
                                    if ($_GET['q'] == 0) {
                                        $disabled = "";
                                    } else {
                                        $disabled = "disabled";
                                    }
                                    ?>
                            <input type="hidden" name="cekDokumen[<?php echo $dqD[kode_dokumen]; ?>]"
                                value="<?php echo $dqD[kode_dokumen]; ?>" />
                            <input type="checkbox" name="cekDokumen[<?php echo $dqD[kode_dokumen]; ?>]" value="x"
                                <?php echo $disabled; ?>>
                            <?php echo $dqD[nama] . " [" . $dqD[kode_dokumen] . "]"; ?> &nbsp;
                            <a href="dl.php?no_rek=<?php echo $dqD[no_fasilitas]; ?>&kode=<?php echo $dqD[kode_dokumen]; ?>&nama=<?php echo $dqD[nama]; ?>"
                                style="float:right;" target="_blank" title="Klik untuk mendownload Dokumen"><i
                                    class="fa fa-download"></i> </a>
                        </label>
                    </div>
                </td>
                <td>
                    &nbsp;<input type="text" style="height: 20px;" name="textDokumen[<?php echo $dqD[kode_dokumen]; ?>]"
                        <?php echo $disabled; ?>>
                </td>
                <?php
                }
                    ?>
        </table>
        <?php
        } else {
        ?>
        <div class="checkbox-inline1">
            <label style="font-weight: normal; font-size: 0.9em;">
                <input type="checkbox" name="tidakAdaDokumen" value="1" checked>
                Tidak ada Dokumen! &nbsp;
            </label>
        </div>
        <?php
        }
        ?>

    </div>
    <?php
    if ($_GET['q'] == 0) {
        echo "<button type='submit' class='btn btn-primary'>Simpan!</button>&nbsp;";
        echo "<button type='submit' name='doklengkap' class='btn btn-danger'>Dokumen Lengkap Manual!</button>";
    } elseif ($_GET['q'] == 3) {
        echo "<button type='submit' name='doklengkap' class='btn btn-danger'>Dokumen Lengkap Manual!</button>";
    }
    ?>
</form>
<hr />
<b>History</b><br />
<small>
    <table class="table display nowrap">

        <?php
        $qH = mssql_query("SELECT * FROM history_jawaban_klaim_kur_gen2_bri WHERE no_rekening = '$_GET[no_fasilitas]' ORDER BY id DESC;");
        while ($dqH = mssql_fetch_array($qH)) {
            echo "
		<tr>
			<td>$dqH[created_date] - <small>Status BRI: $dqH[status_bri]</small><br/>$dqH[ket]</td>
		</tr>";
        }
        ?>
    </table>
</small>