<html>

<head>
    <title>Daftar Data Pengajuan Subrogasi</title>
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

    $date = date("Y-m-d");
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Pengajuan Subrogasi BRI($date).xls");
    ?>

    <center>
        <h1>Data Pengajuan Subrogasi BRI</h1>
    </center>

    <table border="1">
        <tr>
            <th>#</th>
            <th>F Id Program</th>
            <th>Nomor Peserta</th>
            <th>Nomor Rekening</th>
            <th>Urutan Pengajuan</th>
            <th>Status Proses</th>
            <th>Angsuran Teller Id</th>
            <th>Angsuran Jurnal Sequence</th>
            <th>Angsuran Tanggal</th>
            <th>Angsuran Pokok</th>
            <th>Angsuran Bunga</th>
            <th>Angsuran Denda</th>
            <th>Nominal Subrogasi Fee</th>
            <th>Nominal Subrogasi Pajak</th>
            <th>F Id Jenis Subrogasi</th>
            <th>Jenis Subrogasi</th>
            <th>Claim Source</th>
            <th>Nama Debitur</th>
            <th>Net Klaim</th>
            <th>No. CL</th>
            <th>Tanggal. CL</th>
            <th>Tanggal Pengajuan</th>
            <th>Teller ID</th>
            <th>Teller Subrogation Date</th>
            <th>Tanggal Realisasi</th>

        </tr>
        <?php
        include '../../config/koneksi_askred.php';
        $no = 1;
        $listDataSubro = mssql_query("SELECT *,  a.created_date as tanggalpengajuan, c.nama_program as namaprogram, a.f_id_program as fidprogram, a.nomor_peserta as nopeserta, b.created_date as tgl_realisasi FROM askred_subrogation_validation a LEFT JOIN askred_subrogation_flag b ON a.urutan_pengajuan = b.urutan_pengajuan_subrogasi LEFT JOIN askred_program c ON a.f_id_program = c.f_id_program");
        while ($item = mssql_fetch_array($listDataSubro)) {
        ?>
        <tr>
            <th scope="row">
                <?php echo $no; ?>
            </th>
            <td><?php echo $item['namaprogram']; ?></td>
            <td><?php echo $item['nopeserta']; ?></td>
            <td><?php echo $item['nomor_rekening_pinjaman']; ?></td>
            <td><?php echo $item['urutan_pengajuan']; ?></td>
            <td><?php
                    if ($item['status_proses'] == '1') {
                        echo "Sudah Realisasi";
                    } else if ($item['status_proses'] == '0') {
                        echo "Gagal Realisasi";
                    } else if ($item['status_proses'] == NULL) {
                        echo "Belum Realisasi";
                    }

                    ?></td>
            <td><?php
                    echo $item['angsuran_teller_id'];
                    ?></td>
            <td><?php echo $item['angsuran_journal_sequence']; ?></td>
            <td><?php
                    //                                echo $item['angsuran_tanggal'];
                    echo date('d F Y', strtotime($item['angsuran_tanggal']));
                    ?></td>
            <td><?php echo 'Rp.' . number_format($item['angsuran_pokok']); ?></td>
            <td><?php
                    //                                echo $item['angsuran_bunga'];
                    echo 'Rp.' . number_format($item['angsuran_bunga']);
                    ?></td>
            <td><?php
                    //                                echo $item['angsuran_denda'];
                    echo 'Rp.' . number_format($item['angsuran_denda']);
                    ?></td>
            <td><?php
                    //                                echo $item['collecting_fee_net'];
                    echo 'Rp.' . number_format($item['collecting_fee_net']);
                    ?></td>
            <td><?php
                    //                                echo $item['pajak_collecting_fee'];
                    echo 'Rp.' . number_format($item['pajak_collecting_fee']);
                    ?></td>
            <td><?php echo $item['f_id_jenis_subrogasi']; ?></td>
            <td><?php echo $item['jenis_subrogasi']; ?></td>
            <td><?php echo $item['claim_source']; ?></td>
            <td><?php echo $item['nama_debitur']; ?></td>
            <td><?php
                    //                                echo $item['net_klaim'];
                    echo 'Rp.' . number_format($item['net_klaim']);
                    ?></td>
            <td><?php echo $item['no_cl']; ?></td>
            <td><?php
                    //                                echo $item['tanggal_cl'];
                    echo date('d F Y', strtotime($item['tanggal_cl']));
                    ?></td>
            <td><?php
                    //                                echo $item['tanggalpengajuan'];
                    echo date('d F Y', strtotime($item['tanggalpengajuan']));
                    ?>

            </td>
            <td><?php echo $item['teller_id']; ?></td>
            <td><?php

                    if ($item['teller_subrogation_date'] != NULL) {
                        echo date('d F Y', strtotime($item['teller_subrogation_date']));
                    } else {
                        echo $item['teller_subrogation_date'];
                    }

                    ?></td>
            <td><?php
                    if ($item['status_proses'] == '1') {
                        //                                    echo $item['tgl_realisasi'];
                        echo date('d F Y', strtotime($item['tgl_realisasi']));
                    }
                    ?></td>
        </tr>

        <?php
            $no++;
        }
        ?>
    </table>
</body>

</html>