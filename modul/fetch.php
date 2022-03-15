<?php
//fetch.php
error_reporting(0);
include "../config/koneksi.php";

session_start();

if ($_POST['q'] == 'all') {
	$kondisi = "";
} else {
	$kondisi = "AND a.status_klaim = '$_POST[q]'";
}
//$q = mssql_query("SELECT a.*, b.nama_debitur FROM pengajuan_klaim_kur_gen2 a, sp2_kur2015 b WHERE a.no_rekening = b.no_rekening AND substring(a.no_sertifikat, 4, 2) = '$_SESSION[id_kantor]' $kondisi ORDER BY a.tgl_kirim DESC");

// $q = mssql_query("SELECT 
// 					a.*, 
// 					(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening = b.no_rekening) AS nama_debitur,
// 					(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d WHERE a.no_rekening = c.no_rek_suplesi AND d.no_rekening = c.no_rekening) AS nama_debitur_spr,
// 					(SELECT TOP 1 e.nama FROM mapping_bank_bri e, sp2_kur2015 f WHERE e.kode_uker_bank = f.kode_uker AND a.no_rekening = f.no_rekening) AS kode_uker,
// 					(SELECT TOP 1 g.nama FROM mapping_bank_bri g, sp2_kur2015 h, pengajuan_spr_kur_gen2 i WHERE a.no_rekening = i.no_rek_suplesi AND h.no_rekening = i.no_rekening AND g.kode_uker_bank = h.kode_uker) AS kode_uker_spr
// 					FROM pengajuan_klaim_kur_gen2 a WHERE substring(a.no_sertifikat, 4, 2) = '$_SESSION[id_kantor]' $kondisi ORDER BY a.tgl_kirim DESC");


// development
$q = mssql_query("SELECT a.*, 
				(SELECT TOP 1 b.nama_debitur FROM sp2_kur2015 b WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = b.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur,
				(SELECT TOP 1 d.nama_debitur FROM pengajuan_spr_kur_gen2 c, sp2_kur2015 d WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS AND d.no_rekening collate SQL_Latin1_General_CP1_CI_AS = c.no_rekening collate SQL_Latin1_General_CP1_CI_AS) AS nama_debitur_spr,
				(SELECT TOP 1 e.nama FROM mapping_bank_bri e, sp2_kur2015 f WHERE e.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = f.kode_uker AND a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = f.no_rekening collate SQL_Latin1_General_CP1_CI_AS ) AS kode_uker,
				(SELECT TOP 1 g.nama FROM mapping_bank_bri g, sp2_kur2015 h, pengajuan_spr_kur_gen2 i WHERE a.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rek_suplesi collate SQL_Latin1_General_CP1_CI_AS 
				AND h.no_rekening collate SQL_Latin1_General_CP1_CI_AS = i.no_rekening collate SQL_Latin1_General_CP1_CI_AS
				AND g.kode_uker_bank collate SQL_Latin1_General_CP1_CI_AS = h.kode_uker collate SQL_Latin1_General_CP1_CI_AS) AS kode_uker_spr FROM pengajuan_klaim_kur_gen2 a WHERE substring(a.no_sertifikat, 4, 2) = '$_SESSION[id_kantor]' $kondisi ORDER BY a.tgl_kirim DESC");


$n = mssql_num_rows($q);

$data = array();
$i = 1;

while ($row = mssql_fetch_array($q)) {
	$sub_array = array();
	$sub_array[] = $i;
	if ($_POST['q'] != 'all' && $row['claim_source'] == 'BRISURF') {
		$sub_array[] = "<button alt='Lihat Dokumen' type='button' class='btn btn-success btn-small' data-toggle='modal' data-target='#myModal' data-whatever='modul/modal_preview_brisurf.php?q=$_POST[q]&no_fasilitas=$row[no_rekening]&plafond=$row[jml_baki_debet]&tgl_mulai=$row[tgl_mulai]&jml_tuntutan=$row[jml_tuntutan]&sumberklaim=$row[claim_source]&flagdok=$row[flag_dokumen]'><i class='fa fa-search'></i> </button>";
	} else if ($_POST['q'] != 'all' && $row['claim_source'] == 'BRIJAMIN') {
		$sub_array[] = "<button alt='Lihat Dokumen' type='button' class='btn btn-success btn-small' data-toggle='modal' data-target='#myModal' data-whatever='modul/modal_preview.php?q=$_POST[q]&no_fasilitas=$row[no_rekening]&plafond=$row[jml_baki_debet]&tgl_mulai=$row[tgl_mulai]&jml_tuntutan=$row[jml_tuntutan]&sumberklaim=$row[claim_source]'><i class='fa fa-search'></i> </button>";
	} else if ($_POST['q'] != 'all') {
		$sub_array[] = "<button alt='Lihat Dokumen' type='button' class='btn btn-success btn-small' data-toggle='modal' data-target='#myModal' data-whatever='modul/modal_preview.php?q=$_POST[q]&no_fasilitas=$row[no_rekening]&plafond=$row[jml_baki_debet]&tgl_mulai=$row[tgl_mulai]&jml_tuntutan=$row[jml_tuntutan]&sumberklaim=$row[claim_source]'><i class='fa fa-search'></i> </button>";
	}
	$sub_array[] = $row['claim_source'];
	$sub_array[] = $row['no_rekening'];
	if ($row['nama_debitur_spr'] == null) {
		$sub_array[] = strtoupper($row['nama_debitur']);
	} else {
		$sub_array[] = strtoupper($row['nama_debitur_spr']);
	}
	$sub_array[] = $row['no_sertifikat'];
	$sub_array[] = number_format($row['jml_baki_debet'], 2, ",", ".");
	$sub_array[] = number_format($row['jml_tuntutan'], 2, ",", ".");
	if ($row['kode_uker_spr'] == null) {
		$sub_array[] = strtoupper($row['kode_uker']);
	} else {
		$sub_array[] = strtoupper($row['kode_uker_spr']);
	}
	$sub_array[] = $row['no_stgr'];
	$sub_array[] = $row['tgl_stgr'];
	$sub_array[] = $row['tgl_kolek'];
	$sub_array[] = $row['ket_penyebab_klaim'];
	$sub_array[] = $row['tgl_kirim'];
	$sub_array[] = number_format($row['nilai_pengikatan'], 2, ",", ".");

	$data[] = $sub_array;
	$i++;
}

$columns 		= array();
$title[]['title'] = '#';
if ($_POST['q'] != 'all') {
	$title[]['title'] = ' ';
}
$title[]['title'] = 'Sumber Klaim';
$title[]['title'] = 'No. Rekening';
$title[]['title'] = 'Nama Debitur';
$title[]['title'] = 'No. Sertifikat';
$title[]['title'] = 'Jml Baki Debet';
$title[]['title'] = 'Jml Tuntutan';
$title[]['title'] = 'Cabang Bank';
$title[]['title'] = 'No. STGR';
$title[]['title'] = 'Tgl STGR';
$title[]['title'] = 'Tgl Kolek';
$title[]['title'] = 'Ket';
$title[]['title'] = 'Tgl Kirim';
$title[]['title'] = 'Nilai Pengikatan';

$columns = $title;

$output = array(
	"draw"    			=> intval(1),
	"recordsTotal"  	=> intval($n),
	"recordsFiltered" 	=> intval($n),
	"data"    			=> $data,
	"columns"			=> $columns
);

echo json_encode($output);