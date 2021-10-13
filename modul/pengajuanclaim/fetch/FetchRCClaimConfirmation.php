<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi_askred.php";
session_start();

$norekPinjaman = $_REQUEST['norek'];

$q = mssql_query("SELECT ark.* FROM askred_rekening_koran ark
INNER JOIN askred_claim_confirmation acc ON ark.id_claim_confirmation = acc.id
WHERE acc.nomor_peserta = '" . $norekPinjaman . "'");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $sub_array[] = $i;
    $sub_array[] = $row['uraian_transaksi'];
    $sub_array[] = $row['tanggal'];
    $sub_array[] = $row['debet'];
    $sub_array[] = $row['kredit'];
    $sub_array[] = $row['saldo'];
    $sub_array[] = $row['created_date'];
    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Uraian Transaksi';
$title[]['title'] = 'Tanggal RC';
$title[]['title'] = 'Debet';
$title[]['title'] = 'Kredit';
$title[]['title'] = 'Saldo';
$title[]['title'] = 'Tanggal Pengajuan Klaim';
$columns = $title;

$output = array(
    "draw"                => intval(1),
    "recordsTotal"      => intval($n),
    "recordsFiltered"     => intval($n),
    "data"                => $data,
    "columns"            => $columns
);

echo json_encode($output);