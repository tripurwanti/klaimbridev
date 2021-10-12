<html>
<head>
	<title>Export Data Rekon Ke Excel</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	$date = date("Y-m-d");
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Pelunasan Klaim KUR BRI($date).xls");
    include '../config/koneksi.php';

    $fileId = $_REQUEST['id'];
    $q = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $fileId");
	?>
 
	<center>
		<h3>Data Pelunasan Klaim KUR BRI</h3>
	</center>
 
	<table border="1">
		<tr style="background-color : #2866c9">
			<th style="color : white">No</th>
			<th style="color : white">Id</th>
			<th style="color : white">Tanggal Posting</th>
			<th style="color : white">No Rekening</th>
			<th style="color : white">Nominal Klaim</th>
            <th style="color : white">Status</th>
			<th style="color : white">Keterangan</th>
			<th style="color : white">No BK</th>
			<th style="color : white">No MM</th>
			<th style="color : white">Tanggal BK</th>
			<th style="color : white">Tanggal MM</th>
			<th style="color : white">Kantor Cabang</th>
			<th style="color : white">No CL</th>	

		</tr>
        <?php
            $no = 1;							
            while($dq = mssql_fetch_array($q)) {
        ?>
            <tr>								
                <th scope="row">
                    <?php echo $no; ?>
                </th> 
                <td><?php echo $dq['id']; ?></td>
                <td><?php echo $dq['mapping_date']; ?></td>
                <td><?php echo $dq['no_rekening']; ?></td>
                <td><?php echo $dq['nominal_klaim']; ?></td>
                <td><?php echo $dq['status']; ?></td>
				<td><?php echo $dq['detail']; ?></td>
				<td><?php echo $dq['noBk']; ?></td>
				<td><?php echo $dq['noMm']; ?></td>
				<td><?php echo $dq['tgl_bk']; ?></td>
				<td><?php echo $dq['tgl_mm']; ?></td>
				<td><?php echo $dq['cabang']; ?></td>
				<td><?php echo $dq['no_cl']; ?></td>
            </tr>

        <?php
                $no++;
            }
        ?>
	</table>
</body>
</html>