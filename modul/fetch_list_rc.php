<?php
//fetch.php
error_reporting(1);
include "../config/koneksi.php";

session_start();

$q = mssql_query("SELECT * FROM file_rc ORDER BY id DESC");

$n = mssql_num_rows($q);

$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
	$sub_array = array();
	$sub_array[] = $i;
	$sub_array[] = $row['id'];
	// if ($row['flag_status'] == '2') {
	// 	$sub_array[] = "<a type='submit' href='excel/export_excel_RC.php?file=" . $row['documen_name'] . " &id=" . $row['id'] . "'
	// 					class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom'
	// 					title='Download File Excel'><i class='fa fa-download'></i></a>
	// 				<a type='submit' class='btn btn-outline-success btn-sm' data-placement='bottom' 
	// 					href='#' disabled ><i class='fa fa-file'></i></a>";
	// } else {
	$sub_array[] = "<a type='submit' href='excel/export_excel_RC.php?file=" . $row['documen_name'] . " &id=" . $row['id'] . "'
						class='btn btn-outline-success btn-sm' data-toggle='tooltip' data-placement='bottom'
						title='Download File Excel'><i class='fa fa-download'></i></a>
					<a type='submit' class='btn btn-outline-success btn-sm' data-placement='bottom' 
						data-toggle='modal' 
						data-target='#myModal' 
						data-whatever='modul/modal_posting.php?fileId=" . $row['id'] . "' 
						data-toggle='tooltip'
						title='Posting'><i class='fa fa-file'></i></a>";
	// }

	$sub_array[] = $row['documen_name'];
	if ($row['flag_status'] == '0') {
		$sub_array[] = 'ON PROGRESS';
	} else if ($row['flag_status'] == '1') {
		$sub_array[] = 'POSTING READY';
	} else if ($row['flag_status'] == '2') {
		$sub_array[] = 'POSTED';
	} else {
		$sub_array[] = 'NO STATUS';
	}
	$sub_array[] = $row['upload_date'];
	$sub_array[] = $row['total_record'];
	$sub_array[] = "Rp. " . number_format($row['total_amount'], 2) . "";
	$sub_array[] = $row['no_bk'];
	$sub_array[] = $row['no_mm'];
	$sub_array[] = $row['tgl_bk'];
	$sub_array[] = $row['tgl_mm'];
	$data[] = $sub_array;
	$i++;
}

$columns 		= array();
$title[]['title'] = '#';
$title[]['title'] = 'Id';
$title[]['title'] = 'Aksi';
$title[]['title'] = 'Nama Dokumen';
$title[]['title'] = 'Status';
$title[]['title'] = 'Tanggal Upload';
$title[]['title'] = 'Total Record';
$title[]['title'] = 'Total Amount';
$title[]['title'] = 'No BK';
$title[]['title'] = 'No MM';
$title[]['title'] = 'Tanggal BK';
$title[]['title'] = 'Tanggal MM';

$columns = $title;

$output = array(
	"draw"                => intval(1),
	"recordsTotal"        => intval($n),
	"recordsFiltered"     => intval($n),
	"data"                => $data,
	"columns"             => $columns
);

echo json_encode($output);