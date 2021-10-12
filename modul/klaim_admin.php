<script>
function downloadFile(strParam) {
	window.open(document.getElementById("cmbDokumen"+strParam).value, '');
}

$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<?php

$sq 	= "SELECT * FROM r_kantor ORDER BY id_kantor ASC;";

$q 	= mssql_query($sq);
$aq = mssql_query($saq);
$rq = mssql_num_rows($sq);
?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Pengajuan Klaim</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
					<h4><?php echo "Seluruh Data Cabang Askrindo"; ?></h4>
					<table id="example" class="table table-hover"> 
						<thead> 
							<tr> 
								<th width="50px">#</th> 
								<th width="90%">Data</th> 
								<th><i class='fa fa-thumbs-up' style='color: #4caf50' title='Data Disetujui'></th> 
								<th><i class='fa fa-thumbs-down' style='color: #f44336' title='Data Ditolak'></th> 
								<th><i class='fa fa-edit' style='color: #ff9800' title='Belum Diverifikasi'></th> 
								<th><i class='fa fa-check' style='color: #2196f3' title='Data Lengkap'></th>
								<th><i class='fa fa-frown-o' style='color: #795548' title='Tidak Lengkap'></th> 
							</tr> 
						</thead> 
						<tbody>
						<?php
							$no = 1;
							while($dq = mssql_fetch_array($q)) {
						?>
							<tr> 
								<td>
									<?php echo $no; ?>
								</td> 
								<td>
									<?php
										$q1 = mssql_query("SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '2' AND substring(no_sertifikat, 4, 2) = '$dq[id_kantor]';");
										$dq1 = mssql_fetch_array($q1);
										
										$q2 = mssql_query("SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '1' AND substring(no_sertifikat, 4, 2) = '$dq[id_kantor]';");
										$dq2 = mssql_fetch_array($q2);
										
										$q3 = mssql_query("SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '0' AND substring(no_sertifikat, 4, 2) = '$dq[id_kantor]';");
										$dq3 = mssql_fetch_array($q3);
										
										$q4 = mssql_query("SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '4' AND substring(no_sertifikat, 4, 2) = '$dq[id_kantor]';");
										$dq4 = mssql_fetch_array($q4);
										
										$q5 = mssql_query("SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '3' AND substring(no_sertifikat, 4, 2) = '$dq[id_kantor]';");
										$dq5 = mssql_fetch_array($q5);
										
										/*
										echo "<i class='fa fa-thumbs-up' style='color: #4caf50' title='Data Disetujui'> <small>$dq1[banyak]</small></i> &nbsp;&nbsp;&nbsp;";
										echo "<i class='fa fa-thumbs-down' style='color: #f44336' title='Data Ditolak'> <small>$dq2[banyak]</small></i> &nbsp;&nbsp;&nbsp;";
										echo "<i class='fa fa-edit' style='color: #ff9800' title='Belum Diverifikasi'> <small>$dq3[banyak]</small></i> &nbsp;&nbsp;&nbsp;";
										echo "<i class='fa fa-check' style='color: #2196f3' title='Data Lengkap'> <small>$dq4[banyak]</small></i> &nbsp;&nbsp;&nbsp;";
										echo "<i class='fa fa-frown-o' style='color: #795548' title='Tidak Lengkap'> <small>$dq5[banyak]</small></i> &nbsp;&nbsp;&nbsp;";
										*/
									?>
									<a role="button" title="Klik untuk melihat detail" data-toggle="collapse" data-parent="#accordion" href="#col<?php echo $no; ?>" aria-expanded="false" aria-controls="col<?php echo $no; ?>" class="">
										<div class="mail"><p><b><?php echo $dq[kantor]; ?></b></p></div>
									</a>
									<br/>
									<div id="col<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="mail-body">
											<p>
												Data Disetujui: <b><?php echo $dq1[banyak_data]; ?></b><br/>
												Data Ditolak: <b><?php echo $dq2[banyak_data]; ?></b><br/>
												Belum Diverifikasi: <b><?php echo $dq3[banyak_data]; ?></b><br/>
												Data Lengkap: <b><?php echo $dq4[banyak_data]; ?></b><br/>
												Tidak Lengkap: <b><?php echo $dq5[banyak_data]; ?></b><br/>
											</p>
										</div>
									</div>
								</td> 
								<td><span style='color: #4caf50'><?php echo $dq1[banyak_data]; ?></span></td>
								<td><span style='color: #f44336'><?php echo $dq2[banyak_data]; ?></span></td>
								<td><span style='color: #ff9800'><?php echo $dq3[banyak_data]; ?></span></td>
								<td><span style='color: #2196f3'><?php echo $dq4[banyak_data]; ?></span></td>
								<td><span style='color: #795548'><?php echo $dq5[banyak_data]; ?></span></td>
							</tr> 
						<?php
							$no++;
							}
						?>
						</tbody> 
					</table>
				</div>
			</div>
	</div>
</div>