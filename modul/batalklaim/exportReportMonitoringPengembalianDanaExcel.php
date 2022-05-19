<?php
include '../../config/koneksi.php';
include '../../config/excel_reader2.php';
include '../../config/SpreadsheetReader.php';

$server3 = "10.20.10.167";
$username3 = "askrindo";
$password3 = "p@ssw0rd";
$database3 = "ASKRINDO_BRI_DEV";
$con3 = mssql_connect($server3, $username3, $password3, true);
mssql_select_db($database3, $con3) or die("Database tidak ditemukan");

$date = date("Y-m-d");
$createDate = date("Y-m-d H:i:s");
$date2 = date('d/m/Y', strtotime($createDate));
$rootdir = "klaimbridev";
$dataBatalKlaim = mssql_query("SELECT j.*,  k.* ,(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = b.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur,
(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d 
  WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS 
  AND d.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur_spr
  FROM pengajuan_klaim_kur_gen2_history a INNER JOIN jawaban_klaim_kur_gen2_history j ON a.id = j.id_pengajuan_history 
  INNER JOIN pengembalian_dana_batch k ON a.batch_id = k.batch_id ", $con);


// $rDataBatalKlaim = mssql_num_rows($dataBatalKlaim);
// if ($rDataBatalKlaim <= 0) {
//     echo '<script language="javascript">
//     Swal.fire("Any fool can use a computer")
//     </script>';
// } else {

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

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=bri_cms.xls");
    ?>

    <center>
        <table>
            <tr>
                <td style=" border: none;">
                    <b>Converter Mass FT CMS BRI</b>
                </td>
            </tr>
            <tr>
                <td style=" border: none; color : red;">
                    <b>Mandatory</b>
                </td>
            </tr>
            <tr>
                <td style=" border: none; color : blue;">
                    <b>Optional</b>
                </td>

            </tr>
        </table>
    </center>

    <table border="1">
        <tr style="background-color : #f0f0f0">
            <th rowspan="2" style="color : red; font-weight: bold;">No</th>
            <th style="font-weight: bold;">Sender Information</th>
            <th colspan="3" style="font-weight: bold;">Beneficiary Information</th>
            <th colspan="7" style="font-weight: bold;">Transaction Information</th>
        </tr>
        <tr style="background-color : #f0f0f0">
            <th style="color : red; font-weight: bold;">Account Number</th>
            <th style="color : red; font-weight: bold;">Account Number</th>
            <th style="color : red; font-weight: bold;">Account Name</th>
            <th style="color : blue; font-weight: bold;">Email Address</th>
            <th style="color : red; font-weight: bold;">Amount</th>
            <th style="color : red; font-weight: bold;">Currency</th>
            <th style="color : blue; font-weight: bold;">Charge Type</th>
            <th style="color : blue; font-weight: bold;">Voucher Code</th>
            <th style="color : blue; font-weight: bold;">BI Trx Code</th>
            <th style="color : red; font-weight: bold;">Remark</th>
            <th style="color : red; font-weight: bold;">Ref Number</th>
        </tr>
        <?php
        $no = 1;
        $totalNominalClaim = 0;
        while ($dq = mssql_fetch_array($dataBatalKlaim)) {
            $nopes = $dq['no_rekening'];
            $query = "";
            $getRemark = mssql_query("SELECT remark FROM askred_claim_confirmation WHERE nomor_peserta = '$nopes'",  $con3);
            $dGetRemark = mssql_fetch_array($getRemark);
            $remark = $dGetRemark['remark'];

        ?>
        <tr>
            <th scope="row">
                <?php echo $no; ?>
            </th>
            <td>04720743463436</td>
            <td><?php echo $dq['no_rekening']; ?></td>
            <td><?php
                    if ($dq['nama_debitur_spr'] == null) {
                        echo $dq['nama_debitur'];
                    } else {
                        echo $dq['nama_debitur_spr'];
                    }
                    ?></td>
            <td></td>
            <td><?php echo $dq['jml_net_klaim']; ?></td>
            <td>IDR</td>
            <td>OUR</td>
            <td></td>
            <td></td>
            <td><?php echo $remark ?></td>
            <td></td>
        </tr>

        <?php
            $no++;
            $totalNominalClaim = $totalNominalClaim + $dq['jml_net_klaim'];
        }
        ?>
        <tr>
            <td style="color : red; font-weight: bold;">COUNT</td>
            <td style="font-weight: bold;"><?php echo $no - 1; ?></td>
        </tr>
        <tr>
            <td style="color : red; font-weight: bold;">TOTAL</td>
            <td style="font-weight: bold;"><?php echo $totalNominalClaim; ?></td>
        </tr>
        <tr>
            <td style="color : blue;  font-weight: bold;">DATE</td>
        </tr>
        <tr>
            <td style="color : blue; font-weight: bold;">TIME</td>
        </tr>

    </table>

    <?php
    // }
    ?>
</body>

</html>