<html>

<head>
	<title>Export Data Rekon Ke Excel</title>
</head>

<body>
	<style type="text/css">
		body {
			font-family: sans-serif;
		}

		table {
			margin: 20px auto;
			border-collapse: collapse;
		}

		table th,
		table td {
			border: 1px solid #3c3c3c;
			padding: 3px 8px;

		}

		a {
			background: blue;
			color: #fff;
			padding: 8px 10px;
			text-decoration: none;
			border-radius: 2px;
		}
	</style>

	<?php

	class dataTable
	{
		public $noRekeningRc;
		public $nominalRc;
		public $tglRekKoran;
		public $ktrCabang;
	}
	$dataTables = array();
	// $noRekeningRc = "";
	// $nominalRc = "";
	// $tglRekKoran = "";
	// $ktrCabang = "";
	$date = date("Y-m-d");
	$file = $_REQUEST['file'];
	$fileId = $_REQUEST['id'];
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data RC Klaim KUR BRI($fileId).xls");
	include '../config/koneksi.php';
	include '../config/excel_reader2.php';
	include '../config/SpreadsheetReader.php';
	// include '../config/koneksi_bri_prod.php';

	// //koneksi DB AOS PROD sementara
	// $server 	= "10.20.10.16";
	// $user 		= "askrindo";
	// $password 	= "p@ssw0rd";
	// $database 	= "aos_kur_bri";
	// $db1 = mssql_connect($server, $user, $password, true);
	// mssql_select_db($database, $db1) or die("Database tidak ditemukan");

	// //koneksi DB AOS DEV sementara
	// $server2 	= "10.20.10.16";
	// $user2 		= "askrindo";
	// $password2 	= "p@ssw0rd";
	// $database2 	= "aos_kur_bri_dev";
	// $con2 = mssql_connect($server2, $user2, $password2, true);
	// mssql_select_db($database2, $con2) or die("Database tidak ditemukan");

	// $q = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $fileId");

	function queryCabang($noRek, $db1)
	{
		return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = '$noRek')", $db1);
	}
	function queryCabang2($noRek, $db1)
	{
		return mssql_query("SELECT kantor FROM r_kantor WHERE id_kantor = (SELECT cabang_rekanan FROM sp2_kur2015 WHERE no_rekening = (SELECT top 1 no_rekening FROM pengajuan_spr_kur_gen2 WHERE no_rek_suplesi = '$noRek'
		UNION
		SELECT no_rekening FROM sp2_kur2015 WHERE no_rekening = '$noRek'))", $db1);
	}

	$queryGetDataRc = mssql_query("SELECT * FROM mapping_rc_bri WHERE file_name = '$file'");

	?>

	<center>
		<h3>Data RC Klaim KUR BRI (id=<?php echo $fileId ?>)</h3>
	</center>

	<table border="1">
		<tr style="background-color : #2866c9">
			<th style="color : white">No</th>
			<th style="color : white">Tanggal</th>
			<th style="color : white">No Rekening</th>
			<th style="color : white">Nominal Klaim</th>
			<th style="color : white">Kantor Cabang</th>
		</tr>
		<?php
		$no = 1;
		while ($dq = mssql_fetch_array($queryGetDataRc)) {
		?>
			<tr>
				<th scope="row">
					<?php echo $no; ?>
				</th>
				<td><?php echo $dq['tgl_rek_koran']; ?></td>
				<td><?php echo $dq['no_rekening'] ?></td>
				<td><?php echo $dq['nominal_klaim'] ?></td>
				<td><?php echo $dq['cabang']?></td>
			</tr>

		<?php
			$no++;
		}
		?>
		
	</table>
</body>

</html>

<!-- <?php
		$no = 1;
		foreach ($dataTables as $data) {
		?>
            <tr>								
                <th scope="row">
                    <?php echo $no; ?>
                </th> 
                <td><?php echo $data->tglRekKoran ?></td>
                <td><?php echo $data->noRekeningRc ?></td>
                <td><?php echo $data->nominalRc ?></td>
                <td><?php echo $data->ktrCabang ?></td>
            </tr>

        <?php
			$no++;
		}

//ini cara lama 
	// 	try
	// {
	// 	$Spreadsheet = new SpreadsheetReader("../config/uploads/".$file);
	// 	$BaseMem = memory_get_usage();

	// 	$Sheets = $Spreadsheet -> Sheets();
	// 	foreach ($Sheets as $Index => $Name)
	// 	{
	// 		$Time = microtime(true);
	// 		$Spreadsheet->ChangeSheet(14);

	// 		foreach ($Spreadsheet as $Key => $Row)
	// 		{
	// 			if ($Key >= 10) {	
	// 				if ($Row)
	// 				{
	// 					$split = explode(' ', $Row[2]);
	// 					$split2 = explode('_', $split[0]);
	// 					if(count($split2)>1){
	// 						$noRekRc = $split2[2];

	// 						// ambil data kantor cabang
	// 					$queryCabang = queryCabang($noRekRc);
	// 					$queryCabang2 = queryCabang2($noRekRc);
	// 					$cabang = mssql_fetch_array($queryCabang);
	// 					if($cabang == NULL){
	// 						$cabang = mssql_fetch_array($queryCabang2);
	// 					}

	// 					$dataRc = new dataTable();
	// 					$dataRc->noRekeningRc = $noRekRc;
	// 					$dataRc->nominalRc = $Row[6]; 
	// 					$dataRc->tglRekKoran = $Row[0];
	// 					$dataRc->ktrCabang = $cabang['kantor'];
	// 					array_push($dataTables, $dataRc);
	// 					}						
	// 					// print_r($Row);
	// 				}
	// 				else
	// 				{
	// 					// var_dump($Row);
	// 				}
	// 			}
	// 			$CurrentMem = memory_get_usage();
	// 		}
	// 	}

	// }
	// catch (Exception $E)
	// {
	// 	echo $E -> getMessage();
	// }
	
		?> -->