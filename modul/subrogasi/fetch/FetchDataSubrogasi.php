<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi_askred.php";
session_start();


$q = mssql_query("SELECT *,  a.created_date as tanggalpengajuan, c.nama_program as namaprogram, a.f_id_program as fidprogram, a.nomor_peserta as nopeserta, b.created_date as tgl_realisasi 
FROM askred_subrogation_validation a 
LEFT JOIN askred_subrogation_flag b ON a.urutan_pengajuan = b.urutan_pengajuan_subrogasi 
LEFT JOIN askred_program c ON a.f_id_program = c.f_id_program");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $sub_array[] = $i;
    $sub_array[] = $row['namaprogram'];
    $sub_array[] = $row['nopeserta'];
    $sub_array[] = $row['nomor_rekening_pinjaman'];
    $sub_array[] = $row['urutan_pengajuan'];

    $statusProses = "";
    if ($item['status_proses'] == '1') {
        $statusProses = "Sudah Realisasi";
    } else if ($item['status_proses'] == '0') {
        $statusProses =  "Gagal Realisasi";
    } else if ($item['status_proses'] == NULL) {
        $statusProses =  "Belum Realisasi";
    }
    $sub_array[] = $statusProses;

    $sub_array[] = $row['angsuran_teller_id'];
    $sub_array[] = $row['angsuran_journal_sequence'];
    $sub_array[] = date('d F Y', strtotime($row['angsuran_tanggal']));
    $sub_array[] = 'Rp.' . number_format($row['angsuran_pokok'], 2, ',', '.');
    $sub_array[] = 'Rp.' . number_format($row['angsuran_bunga'], 2, ',', '.');
    $sub_array[] = 'Rp.' . number_format($row['angsuran_denda'], 2, ',', '.');

    $totalSubrogasi = $row['nominal_pokok'] + $row['nominal_bunga'] + $row['nominal_denda'];
    $sub_array[] = 'Rp.' . number_format($totalSubrogasi, 2, ',', '.');

    $sub_array[] = 'Rp.' . number_format($row['collecting_fee_net'], 2, ',', '.');
    $sub_array[] = 'Rp.' . number_format($row['pajak_collecting_fee'], 2, ',', '.');
    $netSubrogasi = $totalSubrogasi - $row['pajak_collecting_fee'];
    $sub_array[] = 'Rp.' . number_format($netSubrogasi, 2, ',', '.');
    $sub_array[] = 'Rp.' . number_format($row['nominal_sisa_klaim'], 2, ',', '.');
    $sub_array[] = $row['f_id_jenis_subrogasi'];
    $sub_array[] = $row['jenis_subrogasi'];
    $sub_array[] = $row['claim_source'];
    $sub_array[] = $row['nama_debitur'];
    $sub_array[] = 'Rp.' . number_format($row['net_klaim'], 2, ',', '.');
    $sub_array[] = $row['no_cl'];
    $sub_array[] = date('d F Y', strtotime($row['tanggal_cl']));
    $sub_array[] = date('d F Y', strtotime($row['tanggalpengajuan']));
    $sub_array[] = $row['teller_id'];

    if ($item['teller_subrogation_date'] != NULL) {
        $sub_array[] = date('d F Y', strtotime($row['teller_subrogation_date']));
    } else {
        $sub_array[] = $row['teller_subrogation_date'];
    }

    if ($row['status_proses'] == '1') {
        $sub_array[] = date('d F Y', strtotime($row['tgl_realisasi']));
    } else {
        $sub_array[] = "";
    }


    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Nama Program';
$title[]['title'] = 'Nomor Peserta';
$title[]['title'] = 'Nomor Rekening';
$title[]['title'] = 'Urutan Pengajuan';
$title[]['title'] = 'Status Proses';
$title[]['title'] = 'Angsuran Teller Id';
$title[]['title'] = 'Angsuran Jurnal Sequence';
$title[]['title'] = 'Angsuran Tanggal';
$title[]['title'] = 'Angsuran Pokok';
$title[]['title'] = 'Angsuran Bunga';
$title[]['title'] = 'Angsuran Denda';
$title[]['title'] = 'Total Subrogasi';
$title[]['title'] = 'Nominal Subrogasi Fee';
$title[]['title'] = 'Nominal Subrogasi Pajak';
$title[]['title'] = 'Net Subrogasi';
$title[]['title'] = 'SHS';
$title[]['title'] = 'F Id Jenis Subrogasi';
$title[]['title'] = 'Jenis Subrogasi';
$title[]['title'] = 'Claim Source';
$title[]['title'] = 'Nama Debitur';
$title[]['title'] = 'Net Klaim';
$title[]['title'] = 'No. CL';
$title[]['title'] = 'Tanggal. CL';
$title[]['title'] = 'Tanggal Pengajuan';
$title[]['title'] = 'Teller ID';
$title[]['title'] = 'Teller Subrogation Date';
$title[]['title'] = 'Tanggal Realisasi';
$columns = $title;

$output = array(
    "draw"                => intval(1),
    "recordsTotal"      => intval($n),
    "recordsFiltered"     => intval($n),
    "data"                => $data,
    "columns"            => $columns
);

echo json_encode($output);
