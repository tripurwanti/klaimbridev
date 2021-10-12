<script>
function downloadFile(strParam) {
	window.open(document.getElementById("cmbDokumen"+strParam).value, '');
}

$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<?php

$sq = "SELECT * FROM r_user WHERE id_kantor <> 'x' ORDER BY id_kantor ASC";
$q 	= mssql_query($sq);
?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Daftar User</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
					<h4><?php echo "Seluruh Data User Cabang Askrindo"; ?></h4>
					<table id="example" class="table table-hover"> 
						<thead> 
							<tr> 
								<th width="50px">#</th> 
								<th>Username</th> 
								<th>Password</th> 
								<th>Cabang</th> 
								<th>Last Login</th> 
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
								<td><?php echo $dq[username]; ?></td>
								<td><?php echo "askrindo123" ?></td>
								<td><?php echo $dq[nama]; ?></td>
								<td><?php echo $dq[last_login]; ?></td>
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