<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi_askred.php";
session_start();

$q = mssql_query("SELECT * FROM askred_pending WHERE service = 'SubrogationValidation'");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $sub_array[] = $i;
    $sub_array[] = $row['id'];
    $sub_array[] = date('d F Y', strtotime($row['created_date']));
    $sub_array[] = $row['service_id'];
    $sub_array[] = $row['keterangan'];
    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Id';
$title[]['title'] = 'Tanggal Pengajuan';
$title[]['title'] = 'Nomor Rekening';
$title[]['title'] = 'Keterangan';
$columns = $title;

$output = array(
    "draw" => intval(1),
    "recordsTotal" => intval($n),
    "recordsFiltered" => intval($n),
    "data" => $data,
    "columns" => $columns
);

echo json_encode($output);
