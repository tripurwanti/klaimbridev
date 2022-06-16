<?php
include '../../config/koneksi.php';
include '../../config/excel_reader2.php';
include '../../config/SpreadsheetReader.php';

$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$startDate = str_replace("-", "/", $startDate);
$endDate = str_replace("-", "/", $endDate);
$date = date("Y-m-d");
$createDate = date("Y-m-d H:i:s");
$date2 = date('d/m/Y', strtotime($createDate));

$roodirarr = explode("/", $_SERVER['REQUEST_URI']);
$rootdir = $roodirarr[1];
$server = $_SERVER['SERVER_NAME'];
$query = "SELECT a.*, j.*, l.kantor , k.* ,(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = b.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur,
(SELECT TOP 1 m.tanggal_sertifikat FROM sertifikat_kur m WHERE a.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS = m.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS) AS tanggal_sertifikat_kur ,
(SELECT TOP 1 n.tanggal_sertifikat FROM sertifikat_kur_spr n WHERE a.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS = n.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS) AS tanggal_sertifikat_kur_spr,
(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS AND d.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur_spr,
(SELECT TOP 1 e.nama FROM mapping_bank_bri e, sp2_kur2015 f WHERE e.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = f.kode_uker AND a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = f.no_rekening collate SQL_Latin1_General_CP1_CI_AS ) AS kode_uker,
(SELECT TOP 1 g.nama FROM mapping_bank_bri g, sp2_kur2015 h, pengajuan_spr_kur_gen2 i WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS 
AND h.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rekening collate SQL_Latin1_General_CP1_CI_AS
AND g.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = h.kode_uker collate SQL_Latin1_General_CP1_CI_AS) AS kode_uker_spr 
FROM pengajuan_klaim_kur_gen2_history a INNER JOIN jawaban_klaim_kur_gen2_history j ON a.id = j.id_pengajuan_history 
LEFT JOIN pengembalian_dana_batch k ON a.batch_id = k.batch_id 
INNER JOIN r_kantor l ON substring(a.no_sertifikat, 4, 2) = l.id_kantor AND
CONVERT(varchar, a.history_create_date , 111) 
BETWEEN '$startDate' AND '$endDate' 
AND a.status_batal = '1' AND a.batch_id is null";

echo "SELECT a.*, j.*, l.kantor , k.* ,(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = b.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur,
(SELECT TOP 1 m.tanggal_sertifikat FROM sertifikat_kur m WHERE a.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS = m.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS) AS tanggal_sertifikat_kur ,
(SELECT TOP 1 n.tanggal_sertifikat FROM sertifikat_kur_spr n WHERE a.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS = n.no_sertifikat collate SQL_Latin1_General_CP1_CI_AS) AS tanggal_sertifikat_kur_spr,
(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS AND d.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur_spr,
(SELECT TOP 1 e.nama FROM mapping_bank_bri e, sp2_kur2015 f WHERE e.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = f.kode_uker AND a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = f.no_rekening collate SQL_Latin1_General_CP1_CI_AS ) AS kode_uker,
(SELECT TOP 1 g.nama FROM mapping_bank_bri g, sp2_kur2015 h, pengajuan_spr_kur_gen2 i WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS 
AND h.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rekening collate SQL_Latin1_General_CP1_CI_AS
AND g.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = h.kode_uker collate SQL_Latin1_General_CP1_CI_AS) AS kode_uker_spr 
FROM pengajuan_klaim_kur_gen2_history a INNER JOIN jawaban_klaim_kur_gen2_history j ON a.id = j.id_pengajuan_history 
LEFT JOIN pengembalian_dana_batch k ON a.batch_id = k.batch_id 
INNER JOIN r_kantor l ON substring(a.no_sertifikat, 4, 2) = l.id_kantor AND
CONVERT(varchar, a.history_create_date , 111) 
BETWEEN '$startDate' AND '$endDate' 
AND a.status_batal = '1' AND a.batch_id is null";

$dataBatalKlaim = mssql_query($query);

$rDataBatalKlaim = mssql_num_rows($dataBatalKlaim);
if ($rDataBatalKlaim <= 0) {
    echo '<script language="javascript">';
    echo 'alert("Semua data sedang dalam proses pengembalian dana")';
    echo '</script>';
    echo "<script>window.location.href='http://" . $server . ":81/" . $rootdir . "/klaimbridev/media.php?module=batalklaim'</script>";
} else {

?>
<html>

<head>
    <title>Permintaan Pengembalian Dana</title>
</head>

<body>
    <style type="text/css">
    body {
        font-family: sans-serif;
    }

    table {
        margin: 20px auto;
        border-collapse: collapse;
    }

    table th,
    table td {
        border: 1px solid #3c3c3c;
        padding: 3px 8px;

    }

    a {
        background: blue;
        color: #fff;
        padding: 8px 10px;
        text-decoration: none;
        border-radius: 2px;
    }
    </style>
    <?php



        $dataCounter = mssql_query("SELECT * FROM counter_batch WHERE date = '$date'");
        $rDataCounter = mssql_num_rows($dataCounter);
        $dDataCounter = mssql_fetch_array($dataCounter);
        $counter = 1;
        if ($rDataCounter <= 0) {
            mssql_query("INSERT INTO counter_batch ([date], counter) VALUES('$date',$counter)");
        } else {
            $counter = $dDataCounter['counter'] + 1;
            mssql_query("UPDATE counter_batch SET counter = $counter WHERE date = '$date' ");
        }
        $date = str_replace("-", "", $date);
        $batchId = $date . str_pad($counter, 3, "0", STR_PAD_LEFT);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=bri_batal_klaim_$batchId.xls");

        // header("Content-Disposition: attachment; filename=bri_batal_klaim.xls");
        ?>

    <center>
        <h2>Permintaan Pengembalian Dana </h2>
        <table>
            <tr>
                <td style=" border: none;">
                    <b>Batch Id</b>
                </td>
                <td style=" border: none;">
                    <b>:</b>
                </td>
                <td style=" border: none;">
                    <b><?php echo $batchId;
                            ?></b>
                </td>
            </tr>
            <tr>
                <td style=" border: none;">
                    <b>Tanggal</b>
                </td>
                <td style=" border: none;">
                    <b>:</b>
                </td>
                <td style=" border: none;">
                    <b><?php echo $date2; ?></b>
                </td>
            </tr>
        </table>
    </center>

    <table border="1">
        <tr style="background-color : #2866c9">
            <th style="color : white">No</th>
            <th style="color : white">Status Batal</th>
            <th style="color : white">Status Dana</th>
            <th style="color : white">No Rekening</th>
            <th style="color : white">Nama Debitur</th>
            <th style="color : white">Cabang Bank</th>
            <th style="color : white">Kantor Cabang Askrindo</th>
            <th style="color : white">Id Tgr</th>
            <th style="color : white">Tanggal Tgr</th>
            <th style="color : white">Id Sertifikat</th>
            <th style="color : white">Tanggal Sertifikat</th>
            <th style="color : white">Baki Debet</th>
            <th style="color : white">Nilai Tuntutan</th>
            <th style="color : white">Jumlah Net Klaim</th>
            <th style="color : white">Nomor Klaim</th>
            <th style="color : white">Tanggal Klaim</th>
            <th style="color : white">Keterangan Tolak Bank</th>
            <th style="color : white">Tanggal Kirim Bank</th>
            <th style="color : white">Tanggal Request Pengembalian Dana</th>
            <th style="color : white">Batch Id Pengembalian Dana</th>
            <th style="color : white">Tanggal Approve KUR</th>
            <th style="color : white">Tanggal Approve Keuangan</th>
        </tr>
        <?php
            $no = 1;
            $totalNominalClaim = 0;
            while ($dq = mssql_fetch_array($dataBatalKlaim)) {
                mssql_query("UPDATE pengajuan_klaim_kur_gen2_history SET batch_id = '$batchId' WHERE no_rekening = '$dq[no_rekening]'");
            ?>
        <tr>
            <th scope="row">
                <?php echo $no; ?>
            </th>
            <td><?php
                        if ($dq['status_batal'] == 1) {
                            echo 'Berhasil Batal Klaim';
                        } else if ($dq['status_batal'] == 2) {
                            echo 'Pending Batal Klaim';
                        }
                        ?></td>
            <td><?php
                        if ($dq['status_dana'] == null) {
                            echo 'Belum dikembalikan';
                        } else if ($dq['status_dana'] == 1) {
                            echo 'Sudah dikembalikan';
                        } else if ($dq['status_dana'] == 0) {
                            echo 'Menunggu dikembalikan';
                        }
                        ?></td>
            <td><?php echo $dq['no_rekening']; ?></td>
            <td><?php
                        if ($dq['nama_debitur_spr'] == null) {
                            echo $dq['nama_debitur'];
                        } else {
                            echo $dq['nama_debitur_spr'];
                        }
                        ?></td>
            <td><?php
                        if ($dq['kode_uker_spr'] == null) {
                            echo $dq['kode_uker'];
                        } else {
                            echo $dq['kode_uker_spr'];
                        }
                        ?></td>
            <td><?php echo $dq['kantor']; ?></td>
            <td><?php echo $dq['id_tgr']; ?></td>
            <td><?php echo $dq['tgl_kirim']; ?></td>
            <td><?php echo $dq['no_sertifikat']; ?></td>
            <td><?php if ($dq['tanggal_sertifikat_kur_spr']) {
                            echo date('d/m/Y', strtotime($dq['tanggal_sertifikat_kur_spr']));
                        } else if ($dq['tanggal_sertifikat_kur']) {
                            echo date('d/m/Y', strtotime($dq['tanggal_sertifikat_kur']));
                        }
                        ?></td>

            <td><?php echo "Rp " . number_format($dq['jml_baki_debet'], 2, ",", "."); ?> </td>
            <td><?php echo "Rp " . number_format($dq['jml_tuntutan'], 2, ",", "."); ?> </td>

            <td><?php echo "Rp " . number_format($dq['jml_net_klaim'], 2, ",", "."); ?></td>
            <td><?php echo $dq['no_klaim']; ?></td>

            <td><?php echo date('d/m/Y', strtotime($dq['tgl_klaim'])); ?></td>

            <td><?php echo $dq['ket_tolak']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($dq['sys_autodate'])); ?></td>

            <td><?php echo date('d/m/Y', strtotime($createDate)); ?></td>

            <td><?php echo $batchId ?></td>

            <td><?php if ($dq['tgl_approve_kur']) {

                            echo date('d/m/Y', strtotime($dq['tgl_approve_kur']));
                        } else {
                            echo $dq['tgl_approve_kur'];
                        }
                        ?></td>
            <td><?php
                        if ($dq['tgl_approve_kur']) {
                            echo date('d/m/Y', strtotime($dq['tgl_approve_keu']));
                        } else {
                            echo $dq['tgl_approve_keu'];
                        } ?></td>
        </tr>

        <?php
                $no++;
                $totalNominalClaim = $totalNominalClaim + $dq['jml_net_klaim'];
            }
            ?>
        <tr>
            <td colspan="19" style="font-weight: bold;">Total Permintaan Pengembalian Dana Klaim</td>
            <td style="font-weight: bold;"><?php echo "Rp " . number_format($totalNominalClaim, 2, ",", "."); ?></td>
        </tr>

    </table>

    <?php
    mssql_query("INSERT INTO pengembalian_dana_batch
    			(batch_id, status_dana, download_date, create_date, modified_date)
    			VALUES('$batchId', '0', '$createDate', '$createDate', NULL)");
}
    ?>
</body>

</html>