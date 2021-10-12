<?php
//fetch.php
error_reporting(1);
include "../../../config/koneksi_askred.php";
session_start();

$q = mssql_query("SELECT fr.*, 
(SELECT COUNT(*) FROM askred_mapping_rc_bri_subrogasi mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '1') as total_match,
(SELECT COUNT(*) FROM askred_mapping_rc_bri_subrogasi mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '0') as total_unmatch,
(SELECT COUNT(*) FROM askred_mapping_rc_bri_subrogasi mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '2') as total_double
FROM askred_file_rc_subrogasi fr WHERE fr.status != '0'");

$n = mssql_num_rows($q);


$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
    $sub_array = array();

    $sub_array[] = $i;
    $sub_array[] = $row['documen_name'];
    // if ($row['status'] != '1') {
    $sub_array[] = "
        <a type='submit' href='media.php?module=detailDataRC&idfile=$row[id]'
        class='btn btn-outline-success btn-sm' data-toggle='tooltip'
        data-placement='bottom' title='Detail'><i class='fa fa-search'></i></a>
        &nbsp&nbsp&nbsp
        <a type='submit' class='btn btn-outline-success btn-sm' data-placement='bottom' 
        data-toggle='modal' data-target='#myModalDownload' 
        data-whatever='modul/subrogasi/modalParameterDownloadReportView.php?fileId=" . $row['id'] . "' data-toggle='tooltip'
        title='Download'><i class='fa fa-download'></i></a>
		&nbsp&nbsp&nbsp
        
		";
    // } else {
    //     $sub_array[] = "
    //     <a type='submit' href='media.php?module=detailDataRC&idfile=$row[id]'
    //     class='btn btn-outline-success btn-sm' data-toggle='tooltip'
    //     data-placement='bottom' title='Detail'><i class='fa fa-search'></i></a>
    //     &nbsp&nbsp&nbsp
    //     <a type='submit' class='btn btn-outline-success btn-sm' data-placement='bottom' 
    //     href='#'
    //     title='Download' disabled><i class='fa fa-download'></i></a>
    // 	&nbsp&nbsp&nbsp
    //     <a type='submit' class='btn btn-outline-success btn-sm' data-placement='bottom' 
    //     data-toggle='modal' data-target='#myModalPosting'
    //     data-whatever='modul/subrogasi/modalPostingSubrogasiView.php?fileId=" . $row['id'] . "' data-toggle='tooltip'
    //     title='Posting'><i class='fa fa-file'></i></a>
    // 	";
    // }

    if ($row['status'] == '1') {
        $sub_array[] = 'POSTING READY';
    } else if ($row['status'] == '2') {
        $sub_array[] = 'POSTED';
    }


    $sub_array[] = $row['upload_date'];
    $sub_array[] = $row['reconcile_date'];
    $sub_array[] = $row['posting_date'];
    $sub_array[] = $row['bank_name'];
    $sub_array[] = $row['total_record'];
    $sub_array[] = $row['total_amount'];
    $sub_array[] = $row['no_bd_subrogasi'];
    $sub_array[] = $row['no_mm_subrogasi'];
    $sub_array[] = $row['bd_subrogation_date'];
    $sub_array[] = $row['no_bk_collecting_fee'];
    $sub_array[] = $row['no_mm_collecting_fee'];
    $sub_array[] = $row['bk_collecting_fee_date'];
    $sub_array[] = $row['total_match'];
    $sub_array[] = $row['total_unmatch'];
    $sub_array[] = $row['total_double'];
    $data[] = $sub_array;
    $i++;
}

$columns = array();
$title[]['title'] = '#';
$title[]['title'] = 'Nama Dokumen';
$title[]['title'] = 'Aksi';
$title[]['title'] = 'Status';
$title[]['title'] = 'Tanggal Upload';
$title[]['title'] = 'Tanggal Recon';
$title[]['title'] = 'Tanggal Posting';
$title[]['title'] = 'Bank';
$title[]['title'] = 'Total Record';
$title[]['title'] = 'Total Amout';
$title[]['title'] = 'No BD Subrogasi';
$title[]['title'] = 'No MM Subrogasi';
$title[]['title'] = 'Tanggal BD Subrogasi';
$title[]['title'] = 'No BK Collecting Fee';
$title[]['title'] = 'No MM Collecting Fee';
$title[]['title'] = 'Tanggal BK Collecting Fee';
$title[]['title'] = 'Data Match';
$title[]['title'] = 'Data UnMatch';
$title[]['title'] = 'Data Double';
$columns = $title;

$output = array(
    "draw"                => intval(1),
    "recordsTotal"      => intval($n),
    "recordsFiltered"     => intval($n),
    "data"                => $data,
    "columns"            => $columns
);

echo json_encode($output);