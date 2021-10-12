<?php
error_reporting(1);
include "../../config/koneksi_askred.php";
session_start();


$q = mssql_query("SELECT fr.*, 
                    (SELECT COUNT(*) FROM askred_mapping_rc_bri_claim mrb WHERE fr.id = mrb.id_file_rc_claim AND mrb.ismatch = '1') as total_match,
                    (SELECT COUNT(*) FROM askred_mapping_rc_bri_claim mrb WHERE fr.id = mrb.id_file_rc_claim AND mrb.ismatch = '0') as total_unmatch,
                    (SELECT COUNT(*) FROM askred_mapping_rc_bri_claim mrb WHERE fr.id = mrb.id_file_rc_claim AND mrb.ismatch = '2') as total_double
                    FROM askred_file_rc_claim fr");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $id = $row['id'];

    $sub_array[] = $i;
    $sub_array[] = $row['documen_name'];
    $sub_array[] = $row['upload_date'];
    $sub_array[] = $row['bank_name'];
    $sub_array[] = $row['total_record'];
    $sub_array[] = $row['total_amount'];
    $sub_array[] = $row['no_bk'];
    $sub_array[] = $row['no_mm'];
    $sub_array[] = $row['tgl_bk'];
    $sub_array[] = $row['tgl_mm'];
    $sub_array[] = $row['total_match'];
    $sub_array[] = $row['total_unmatch'];
    $sub_array[] = $row['total_double'];
    $sub_array[] = "<a type='submit' href='media.php?module=detailDataRCClaim&id=" . $id . " ' class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom' title='Detail'><i class='fa fa-search'></i></a>
    &nbsp&nbsp&nbsp<a type='submit' href='excel/export_excel.php?id=" . $id . " ' class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom' title='Export Excel'><i class='fa fa-download'></i></a>";
    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Nama Dokumen';
$title[]['title'] = 'Tanggal Upload';
$title[]['title'] = 'Bank';
$title[]['title'] = 'Total Record';
$title[]['title'] = 'Total Amount';
$title[]['title'] = 'No BK';
$title[]['title'] = 'No MM';
$title[]['title'] = 'Tgl BK';
$title[]['title'] = 'Tgl MM';
$title[]['title'] = 'Total Match';
$title[]['title'] = 'Total UnMatch';
$title[]['title'] = 'Total Double';
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