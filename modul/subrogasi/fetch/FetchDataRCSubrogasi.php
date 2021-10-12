<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi_askred.php";
session_start();

$fileId = $_REQUEST['idfile'];
$q = mssql_query("SELECT * FROM askred_mapping_rc_bri_subrogasi WHERE id_file_rc = " . $fileId);
$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $sub_array[] = $i;
    $sub_array[] = $row['remark'];
    $sub_array[] = $row['debet'];
    $sub_array[] = $row['credit'];
    $sub_array[] = $row['ledger'];
    $sub_array[] = $row['teller_id'];
    $sub_array[] = $row['askrindo_branch'];
    $sub_array[] = $row['date_data_rc'];
    // $sub_array[] = $row['urutan'];
    $sub_array[] = $row['bri_flag_date'];
    $isMatch = "";

    if ($row['ismatch'] == 1) {
        $isMatch = "Match";
    } else if ($row['ismatch'] == 0) {
        $isMatch = "UnMatch";
    } else if ($row['ismatch'] == 2) {
        $isMatch = "Match-Double";
    } else if ($row['ismatch'] == 3) {
        $isMatch = "On Progress";
    } else if ($row['ismatch'] == 4) {
        $isMatch = "Match-Correction";
    }

    $sub_array[] = $isMatch;
    if ($row['ismatch'] == 2) {
        $sub_array[] = "<button><a type='submit'
        href='media.php?module=correction&idDataRC=$row[id]' class='btn btn-outline-success btn-sm'
data-toggle='tooltip' data-placement='bottom' title='Koreksi'>Koreksi</a></button>";
    } else {
        $sub_array[] = "";
    }

    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Remark';
$title[]['title'] = 'Debet';
$title[]['title'] = 'Credit';
$title[]['title'] = 'Ledger';
$title[]['title'] = 'Teller ID';
$title[]['title'] = 'Cabang';
$title[]['title'] = 'Tanggal RC';
// $title[]['title'] = 'Urutan';
$title[]['title'] = 'Tanggal Data BRI';
$title[]['title'] = 'Status';
$title[]['title'] = 'Aksi';
$columns = $title;

$output = array(
    "draw" => intval(1),
    "recordsTotal" => intval($n),
    "recordsFiltered" => intval($n),
    "data" => $data,
    "columns" => $columns
);

echo json_encode($output);