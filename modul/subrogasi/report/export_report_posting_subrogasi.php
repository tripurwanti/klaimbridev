<html>

<head>
    <title>Export Data Rekon Ke Excel</title>
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

    class dataTable
    {
        public $noRekeningRc;
        public $nominalRc;
        public $tglRekKoran;
        public $ktrCabang;
    }
    $dataTables = array();
    $date = date("Y-m-d");
    $fileId = $_REQUEST['id'];
    $startDate = $_POST['startdate'];
    $endDate = $_POST['enddate'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Report Reconcile Subrogasi ASKRINDO - BRI($fileId).xls");
    include '../../../config/koneksi_askred.php';
    include '../../../config/excel_reader2.php';
    include '../../../config/SpreadsheetReader.php';

    function queryCabang($noRek, $db1)
    {
        return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $db1);
    }
    function queryCabang2($noRek, $db1)
    {
        return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = (SELECT top 1 no_rekening FROM pengajuan_spr_kur_gen2 WHERE no_rek_suplesi = '$noRek'
		UNION
		SELECT no_rekening FROM sp2_kur2015 WHERE no_rekening = '$noRek'))", $db1);
    }

    $queryGetDataRc = mssql_query("SELECT amrbs.*,  afrs.* FROM askred_mapping_rc_bri_subrogasi amrbs
    LEFT OUTER JOIN askred_file_rc_subrogasi afrs 
    ON amrbs.id_file_rc = afrs.id WHERE amrbs.id_file_rc = " . $fileId);
    $dqueryGetDataRc = mssql_fetch_array($queryGetDataRc)
    ?>

    <center>
        <h3>Report Reconcile Subrogasi ASKRINDO - BRI </h3>
    </center>

    <table>
        <tr>
            <td>Nama File</td>
            <td>:</td>
            <td><?php echo $dqueryGetDataRc['documen_name'] ?></td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td><?php echo $startDate ?> - <?php echo $endDate ?></td>
        </tr>
    </table>

    <table border="1">
        <tr style="background-color : #2866c9">
            <th style="color : white" rowspan="2">No</th>
            <th style="color : white" rowspan="2">Remark</th>
            <th style="color : white" rowspan="2">Debet</th>
            <th style="color : white" rowspan="2">Credit</th>
            <th style="color : white" rowspan="2">Ledger</th>
            <th style="color : white" rowspan="2">Teller ID</th>
            <th style="color : white" rowspan="2">Cabang</th>
            <th style="color : white" colspan="3">Subrogasi</th>
            <th style="color : white" colspan="3">Collecting Fee</th>
            <th style="color : white" rowspan="2">Tanggal Recon</th>
            <th style="color : white" rowspan="2">Tanggal Posting</th>
            <th style="color : white" rowspan="2">Tanggal RC</th>
            <th style="color : white" rowspan="2">Tanggal Data BRI</th>
            <th style="color : white" rowspan="2">Status</th>
        </tr>
        <tr style="background-color : #2866c9">
            <!-- <th style="color : white"></th> -->
            <!-- <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th> -->
            <th style="color : white">No. BD</th>
            <th style="color : white">No. MM</th>
            <th style="color : white">Tanggal BD</th>
            <th style="color : white">No. BK</th>
            <th style="color : white">No. MM</th>
            <th style="color : white">Tanggal BK</th>
            <!-- <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th>
            <th style="color : white"></th> -->
        </tr>
        <?php
        $no = 1;
        while ($dq = mssql_fetch_array($queryGetDataRc)) {
        ?>
        <tr>
            <th scope="row">
                <?php echo $no; ?>
            </th>
            <td><?php echo $dq['remark']; ?></td>
            <td><?php echo $dq['debet'] ?></td>
            <td><?php echo $dq['credit'] ?></td>
            <td><?php echo $dq['ledger'] ?></td>
            <td><?php echo $dq['teller_id'] ?></td>
            <td><?php echo $dq['askrindo_branch'] ?></td>
            <td><?php echo $dq['no_bd_subrogasi'] ?></td>
            <td><?php echo $dq['no_mm_subrogasi'] ?></td>
            <td><?php echo $dq['bd_subrogation_date'] ?></td>
            <td><?php echo $dq['no_bk_collecting_fee'] ?></td>
            <td><?php echo $dq['no_mm_collecting_fee'] ?></td>
            <td><?php echo $dq['bk_collecting_fee_date'] ?></td>
            <td><?php echo $dq['reconcile_date'] ?></td>
            <td><?php echo $dq['posting_date'] ?></td>
            <td><?php echo $dq['date_data_rc'] ?></td>
            <td><?php echo $dq['bri_flag_date'] ?></td>
            <td><?php if ($dq['ismatch']  == 1) {
                        echo "MATCH";
                    } else if ($dq['ismatch']  == 2) {
                        echo   "DOUBLE";
                    } else if ($dq['ismatch']  == 0) {
                        echo   "UNMATCH";
                    }


                    ?></td>
        </tr>

        <?php
            $no++;
        }
        ?>

    </table>
</body>