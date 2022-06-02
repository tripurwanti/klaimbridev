<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi.php";
session_start();

$q = mssql_query("SELECT a.id as id_pengajuan_history, a.history_create_date AS tgl_batal_klaim ,a.*, b.* ,c.* ,
(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = b.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur,
(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS AND d.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur_spr,
(SELECT TOP 1 e.nama FROM mapping_bank_bri e, sp2_kur2015 f WHERE e.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = f.kode_uker AND a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = f.no_rekening collate SQL_Latin1_General_CP1_CI_AS ) AS kode_uker,
(SELECT TOP 1 g.nama FROM mapping_bank_bri g, sp2_kur2015 h, pengajuan_spr_kur_gen2 i WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS 
AND h.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rekening collate SQL_Latin1_General_CP1_CI_AS
AND g.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = h.kode_uker collate SQL_Latin1_General_CP1_CI_AS) AS kode_uker_spr 
FROM pengajuan_klaim_kur_gen2_history a INNER JOIN jawaban_klaim_kur_gen2_history b ON a.id = b.id_pengajuan_history 
LEFT JOIN pengembalian_dana_batch c ON a.batch_id = c.batch_id  ORDER BY a.history_create_date DESC");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $idPengajuanHistory = $row['id_pengajuan_history'];
    $noRekening = $row['no_rekening'];
    $noKlaim = $row['no_klaim'];
    $ketTolak = $row['ket_tolak'];
    $sub_array = array();
    $sub_array[] = $i;
    if ($row['status_batal'] == 2) {
        $sub_array[] = "<a href='modul/batalklaim/fetch/batalSakura.php?noRekening=$noRekening&noKlaim=$noKlaim&ketTolak=$ketTolak'><i class='fa fa-arrow-up' aria-hidden='true'></i> </a>";
    } else if ($row['status_batal'] == 1 && $row['status_dana'] == 1) {
        $sub_array[] = "<a href='modul/batalklaim/fetch/downloadBuktiPengembalianDana.php?id=$idPengajuanHistory'><i class='fa fa-eye' aria-hidden='true'></i> </a>";
    } else if (($row['status_dana'] == null || $row['status_dana'] == 0) && $row['status_batal'] == 2) {
        $sub_array[] = "<a href='modul/batalklaim/fetch/batalSakura.php?noRekening=$noRekening&noKlaim=$noKlaim&ketTolak=$ketTolak'><i class='fa fa-arrow-up' aria-hidden='true'></i> </a>";
    } else if (($row['status_dana'] == null || $row['status_dana'] == 0) && $row['status_batal'] == 1) {
        $sub_array[] = "";
    }


    if ($row['status_batal'] == 1) {
        $sub_array[] = 'Berhasil Batal Klaim';
    } else if ($row['status_batal'] == 2) {
        $sub_array[] = 'Pending Batal Klaim';
    }
    if ($row['status_dana'] == null) {
        $sub_array[] = 'Belum dikembalikan';
    } else if ($row['status_dana'] == 1) {
        $sub_array[] = 'Sudah dikembalikan';
    } else if ($row['status_dana'] == 0) {
        $sub_array[] = 'Menunggu dikembalikan';
    }

    $sub_array[] = $row['no_rekening'];
    if ($row['nama_debitur_spr'] == null) {
        $sub_array[] = strtoupper($row['nama_debitur']);
    } else {
        $sub_array[] = strtoupper($row['nama_debitur_spr']);
    }
    if ($row['kode_uker_spr'] == null) {
        $sub_array[] = strtoupper($row['kode_uker']);
    } else {
        $sub_array[] = strtoupper($row['kode_uker_spr']);
    }
    $sub_array[] = number_format($row['jml_net_klaim'], 2, ",", ".");
    $sub_array[] = $row['no_klaim'];
    $sub_array[] = $row['tgl_kirim'];
    $sub_array[] = $row['ket_tolak'];
    $sub_array[] = $row['sys_autodate'];
    $sub_array[] = $row['download_date'];
    $sub_array[] = $row['tgl_batal_klaim'];
    $sub_array[] = $row['batch_id'];
    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Aksi';
$title[]['title'] = 'Status Batal';
$title[]['title'] = 'Status Dana';
$title[]['title'] = 'No Rekening';
$title[]['title'] = 'Nama Debitur';
$title[]['title'] = 'Cabang Bank';
$title[]['title'] = 'Jumlah Net Klaim';
$title[]['title'] = 'No. Klaim';
$title[]['title'] = 'Tanggal Klaim';
$title[]['title'] = 'Ket. Tolak Bank';
$title[]['title'] = 'Tgl Kirim Bank';
$title[]['title'] = 'Tgl Batal Klaim';
$title[]['title'] = 'Tgl Request Pengembalian';
$title[]['title'] = 'Batch Id Pengembalian Dana';
$columns = $title;

$output = array(
    "draw"                => intval(1),
    "recordsTotal"      => intval($n),
    "recordsFiltered"     => intval($n),
    "data"                => $data,
    "columns"            => $columns
);

echo json_encode($output);