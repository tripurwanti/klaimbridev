<?php
	error_reporting(0);
	include "config/koneksi.php";
	
	$ceklis = 0;
	
	/* Tunggu UAT! */
	$tahun 		= substr($_POST['tgl_mulai'], 0, 4);
	$plafond	= $_POST['plafond'];
	$plafondx	= number_format($plafond, 2, ",", ".");
	$banyak_dok	= $_POST['banyak_dokumen'];
	
	if (isset($_POST['doklengkap'])) {
		$qUJK 	= mssql_query("UPDATE jawaban_klaim_kur_gen2 SET status = '4', ket = 'Dokumen Lengkap (HC)', created_date = getdate() WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		$qIJK 	= mssql_query("INSERT INTO history_jawaban_klaim_kur_gen2 SELECT * FROM jawaban_klaim_kur_gen2 WHERE no_rekening = '$_POST[no_fasilitas]';", $con);
		echo "<script>window.alert('Dokumen Lengkap Manual! \\nStatus: 4 \\nNo. Rekening: $_POST[no_fasilitas]\\nPlafond: Rp. $plafondx\\nTahun: $tahun');
			  window.location=(href='media.php?module=klaim&q=2')</script>";
		exit;
	}
	
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
	}
	
?>