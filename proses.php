<?php
	error_reporting(0);
	include "config/koneksi.php";
	
	$ceklis = 0;
	
	/* Tunggu UAT! */
	$dateRekamGx = date("Y-m-d H:i:s");
	$tahun 		= substr($_POST['tgl_mulai'], 0, 4);
	$plafond	= $_POST['plafond'];
	$plafondx	= number_format($plafond, 2, ",", ".");
	$banyak_dok	= $_POST['banyak_dokumen'];
	
	if (isset($_POST['doklengkap'])) {
		$qUPK 	= mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIHJK 	= mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap (HC)', '$dateRekamGx')", $con);
		$result	= "Hasil: Data Lengkap Hard Copy";
		echo "<script>window.alert('$result');
			  window.location=(href='media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
			  </script>";
		exit;
	}
	
	if ($_POST['tidakAdaDokumen'] == '1') {
		$noData = $_POST[no_fasilitas]."|01|Tidak ada Dokumen|08|Tidak ada Dokumen|09|Tidak ada Dokumen|010|Tidak ada Dokumen|011|Tidak ada Dokumen|02|Tidak ada Dokumen|012|Tidak ada Dokumen|013|Tidak ada Dokumen|014|Tidak ada Dokumen|015|Tidak ada Dokumen|03|Tidak ada Dokumen|04|Tidak ada Dokumen|016|Tidak ada Dokumen|017|Tidak ada Dokumen|018|Tidak ada Dokumen|019|Tidak ada Dokumen|020|Tidak ada Dokumen|05|Tidak ada Dokumen|021|Tidak ada Dokumen|022|Tidak ada Dokumen|06|Tidak ada Dokumen|023|Tidak ada Dokumen|024|Tidak ada Dokumen|025|Tidak ada Dokumen|026|Tidak ada Dokumen|027|Tidak ada Dokumen|028|Tidak ada Dokumen|029|Tidak ada Dokumen|030|Tidak ada Dokumen|031|Tidak ada Dokumen|032|Tidak ada Dokumen|033|Tidak ada Dokumen|034|Tidak ada Dokumen|035|Tidak ada Dokumen|036|Tidak ada Dokumen|07|Tidak ada Dokumen|037|Tidak ada Dokumen|038|Tidak ada Dokumen|039|Tidak ada Dokumen|040|Tidak ada Dokumen|041|Tidak ada Dokumen|042|Tidak ada Dokumen|043|Tidak ada Dokumen|044|Tidak ada Dokumen|045|Tidak ada Dokumen|046|Tidak ada Dokumen";
		$qUPK 	= mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '3' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIHJK 	= mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '3', '0', 'Tidak Lengkap - $noData', '$dateRekamGx')", $con);
		$result	= "Hasil: Tidak Lengkap - $noData";
		echo "<script>window.alert('$result');
			  window.location=(href='media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
			  </script>";
		exit;
	}
	
	/*
	$ay = array( "a" => "BAK - Berita Acara Klaim",
				 "b" => "BI - BI Checking",
				 "c" => "ID - Identitas Debitur",
				 "d" => "IUMK - Surat Ijin Usaha Mikro dan Kecil",
				 "e" => "PK - Perjanjian Kredit",
				 "f" => "RK - Rekening Koran",
				 "g" => "SPP - Surat Peringatan atau Penagihan",
				 "h" => "NPWP - Nomor Pokok Wajib Pajak",
				 "i" => "LI - Loan Inquiry");
				 
	$az = array( "a" => "BAK - Berita Acara Klaim",
				 "b" => "BI - BI Checking",
				 "c" => "ID - Identitas Debitur",
				 "d" => "IUMK - Surat Ijin Usaha Mikro dan Kecil",
				 "e" => "PK - Perjanjian Kredit",
				 "f" => "RK - Rekening Koran",
				 "g" => "SPP - Surat Peringatan atau Penagihan",
				 "h" => "LI - Loan Inquiry");
	
	$ax = array( "a" => "BAK - Berita Acara Klaim",
				 "b" => "BI - BI Checking",
				 "c" => "ID - Identitas Debitur",
				 "d" => "IUMK-Surat Ijin Usaha Mikro dan Kecil",
				 "e" => "PK - Perjanjian Kredit",
				 "f" => "RK - Rekening Koran",
				 "g" => "SP-Surat Peringatan atau Penagihan");
	//$jmlx = 7;
	
	if ($banyak_dok > 7) {
		if ($tahun > 2017 && $plafond > 50000000) { // Mulai tahun 2018 dan plafond lebih dari 50 juta
			$a1 = $ay;
			$jmlx = 9;
		} elseif ($tahun < 2018 && $plafond > 25000000) { // Sebelum tahun 2018 dan plafond lebih dari 25 juta
			$a1 = $ay;
			$jmlx = 9;
		} else {
			$a1 = $ay;
			$jmlx = 9;
		}
	} else {
		$a1 = $ax;
		$jmlx = 7;
	}
	
	foreach($_POST['cekDokumen'] as $key => $value){
		$ceklis++;
		$a2[] = $key;
	}
	
	$result = array_diff($a1, $a2);
	$blmLengkap = join(",", $result);
	
	if ($ceklis == 0) {
		$blmLengkap = "BAK - Berita Acara Klaim,BI - BI Checking,ID - Identitas Debitur,IUMK - Surat Ijin Usaha Mikro dan Kecil,PK - Perjanjian Kredit,RK - Rekening Koran,SPP - Surat Peringatan atau Penagihan,NPWP - Nomor Pokok Wajib Pajak,LI - Loan Inquiry";
	}
	
	if ($ceklis == $jmlx) {
		$qUJK 	= mssql_query("UPDATE jawaban_klaim_kur_gen2 SET status = '4', ket = 'Dokumen Lengkap', created_date = getdate() WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIJK 	= mssql_query("INSERT INTO history_jawaban_klaim_kur_gen2 SELECT * FROM jawaban_klaim_kur_gen2 WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		echo "<script>window.alert('Dokumen Lengkap. $ceklis Dokumen \\nStatus: 4 \\nNo. Rekening: $_POST[no_fasilitas]\\nPlafond: Rp. $plafondx\\nTahun: $tahun');
			  window.location=(href='media.php?module=klaim&q=2')</script>";
	} else {
		$qUJK 	= mssql_query("UPDATE jawaban_klaim_kur_gen2 SET status = '3', ket = 'Dokumen Belum Lengkap ($blmLengkap)', created_date = getdate() WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIJK 	= mssql_query("INSERT INTO history_jawaban_klaim_kur_gen2 SELECT * FROM jawaban_klaim_kur_gen2 WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		echo "<script>window.alert('Dokumen Belum Lengkap. $ceklis Dokumen \\n($blmLengkap). \\nStatus: 3 \\nNo. Rekening: $_POST[no_fasilitas]\\nPlafond: Rp. $plafondx\\nTahun: $tahun');
			  window.location=(href='media.php?module=klaim&q=2')</script>";
	}*/
	
	foreach($_POST['cekDokumen'] as $key => $value){
		if ($value <> 'x') {
			$ceklis++;
			$a2[] = $value."|".$_POST['textDokumen'][$key];
		}
	}
	
	$blmLengkap = $_POST[no_fasilitas]."|".join("|", $a2);
	
	if ($ceklis == 0) { //set pengajuan_klaim lengkap
		$qUPK 	= mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '4' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIHJK 	= mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '4', '0', 'Dokumen Lengkap', '$dateRekamGx')", $con);
		$result	= "Hasil: Data Lengkap";
	} else { //set pengajuan_klaim tidak lengkap
		$qUPK 	= mssql_query("UPDATE pengajuan_klaim_kur_gen2 SET status_klaim = '3' WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIHJK 	= mssql_query("INSERT history_jawaban_klaim_kur_gen2_bri VALUES ('$_POST[no_fasilitas]', '', '3', '0', 'Tidak Lengkap - $blmLengkap', '$dateRekamGx')", $con);
		$result	= "Hasil: Tidak Lengkap - $blmLengkap";
	}
	
	echo "<script>window.alert('$result');
		  window.location=(href='media.php?module=klaim&q=0&title=Belum%20Diverifikasi&range=500')
		  </script>";
	
?>