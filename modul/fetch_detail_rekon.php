<?php
//fetch.php
error_reporting(1);
include "../config/koneksi.php";

session_start();

$fileId = $_REQUEST['id'];

$q = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $fileId");

$n = mssql_num_rows($q);

$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
	$sub_array = array();
	$sub_array[] = $i;
	$sub_array[] = $row['id'];
	$sub_array[] = $row['mapping_date'];
	// $sub_array[] = $row['remark'];
	$sub_array[] = $row['no_rekening'];
	$sub_array[] = $row['nominal_klaim'];
	if ($row['status'] == '1') {
		$sub_array[] = 'match';
	} else if ($row['status'] == '2') {
		$sub_array[] = 'match - double';
	} else {
		$sub_array[] = 'unmatch';
	}
	$sub_array[] = $row['detail'];

	if (strpos($row['remark'], 'BRISURF') !== false) {
		$sub_array[] = 'BRISURF';
	} else {
		$sub_array[] = 'BRIJAMIN';
	}
	$sub_array[] = $row['noBk'];
	$sub_array[] = $row['noMm'];
	$sub_array[] = $row['tgl_bk'];
	$sub_array[] = $row['tgl_mm'];
	$sub_array[] = $row['no_cl'];
	$sub_array[] = $row['cabang'];
	if (strpos($row['remark'], 'BRISURF') !== false) {
		$sub_array[] = "<a type='submit' href='media.php?module=correctionClaim&idDataRC=" . $row[id] . "'
						class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='bottom'
						title='Koreksi'>Koreksi</a>";
	} else {
		$sub_array[] = "";
	}
	$data[] = $sub_array;
	$i++;
}

$columns 		= array();
$title[]['title'] = '#';
$title[]['title'] = 'Id';
$title[]['title'] = 'Tanggal Posting';
// $title[]['title'] = 'Remark';
$title[]['title'] = 'No Rekening';
$title[]['title'] = 'Nominal Klaim';
$title[]['title'] = 'Status';
$title[]['title'] = 'Keterangan';

$title[]['title'] = 'Sumber Klaim';
$title[]['title'] = 'No BK';
$title[]['title'] = 'No MM';
$title[]['title'] = 'Tgl BK';
$title[]['title'] = 'Tgl MM';
$title[]['title'] = 'No CL';
$title[]['title'] = 'Kantor Cabang';
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