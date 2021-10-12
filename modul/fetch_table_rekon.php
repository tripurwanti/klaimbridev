<?php
//fetch.php
error_reporting(1);
include "../config/koneksi.php";

session_start();

$q = mssql_query("SELECT id, mapping_date, file_name, 
(SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE rb.id = mrb.id AND mrb.status = '1') as total_match,
(SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE rb.id = mrb.id AND mrb.status = '0') as total_unmatch,
(SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE rb.id = mrb.id AND mrb.status = '2') as total_match_double,
(SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE rb.id = mrb.id AND mrb.status IS NOT NULL) as total_data
FROM mapping_rc_bri rb WHERE mapping_date IS NOT NULL GROUP BY id, mapping_date, file_name ORDER BY mapping_date DESC");

$n = mssql_num_rows($q);

$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
	$sub_array = array();
	$sub_array[] = $i;
	$sub_array[] = $row['id'];
	$sub_array[] = $row['mapping_date'];
	$sub_array[] = $row['file_name'];
	$sub_array[] = $row['total_match'];
	$sub_array[] = $row['total_unmatch'];
	$sub_array[] = $row['total_match_double'];
	$sub_array[] = $row['total_data'];
	$sub_array[] = "<a type='submit' href='media.php?module=detail&id=" . $row['id'] . "'	
						class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom'
						title='Detail'><i class='fa fa-search'></i></a>	
					<a type='submit' href='excel/export_excel.php?id=" . $row['id'] . "'
						class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom'
						title='Export Excel'><i class='fa fa-download'></i></a>";
	$data[] = $sub_array;
	$i++;
}

$columns 		= array();
$title[]['title'] = '#';
$title[]['title'] = 'Id';
$title[]['title'] = 'Tanggal Posting';
$title[]['title'] = 'Nama Dokumen';
$title[]['title'] = 'Data Match';
$title[]['title'] = 'Data Unmatch';
$title[]['title'] = 'Data Match-Double';
$title[]['title'] = 'Total Data';
$title[]['title'] = 'Aksi';
$columns = $title;

$output = array(
	"draw"                => intval(1),
	"recordsTotal"        => intval($n),
	"recordsFiltered"     => intval($n),
	"data"                => $data,
	"columns"             => $columns
);

echo json_encode($output);