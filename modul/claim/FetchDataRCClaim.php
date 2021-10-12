<?php
//fetch.php
error_reporting(0);
include "../../config/koneksi_askred.php";

session_start();

$fileId = $_REQUEST['idfile'];

$q = mssql_query("SELECT * FROM askred_mapping_rc_bri_claim WHERE id_file_rc_claim = $fileId");

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
    if ($row['ismatch'] == 1) {
        $sub_array[] = "Match";
    } else if ($row['ismatch'] == 0) {
        $sub_array[] = "UnMatch";
    } else if ($row['ismatch'] == 2) {
        $sub_array[] = "Double";
    }

    if ($row['ismatch'] == 2) {
        $sub_array[] = "<button><a type='submit'
        href='media.php?module=correctionDateClaim&idDataRC=" . $row['id'] . "
        class='btn btn-outline-success btn-sm' data-toggle='tooltip'
        data-placement='bottom' title='Koreksi'>Koreksi</a></button>";
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
$title[]['title'] = 'Teller Id';
$title[]['title'] = 'Cabang';
$title[]['title'] = 'Status';
$title[]['title'] = 'Aksi';
$columns = $title;

$output = array(
    "draw"                => intval(1),
    "recordsTotal"      => intval($n),
    "recordsFiltered"     => intval($n),
    "data"                => $data,
    "columns"            => $columns
);

echo json_encode($output);