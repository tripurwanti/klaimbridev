<?php
$dataId = 0;
;?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Report Hasil Rekon</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
				<?php
					if ($_GET['q'] == 'all') {
						$kondisi = "";
					} else {
						$kondisi = "AND a.status_klaim = '$_GET[q]'";
					}
					
					$q = mssql_query("SELECT mapping_date, id , file_name FROM mapping_rc_bri GROUP BY mapping_date, id , file_name ORDER BY mapping_date DESC");
					$rq = mssql_num_rows($q);					
					
				?>
					<h4><?php echo $_GET[title]." <small>(Menampilkan ".$rq." Data dari Total Data)<br/>".$subtrange."</small>"; ?></h4>
					<div id="alert_message"/>

					<table id="user_data" class="table display nowrap" cellspacing="0" width="100%"> 
						<thead>
							<tr>
								<th>#</th>
								<th>Id</th>
								<th>Tanggal Posting</th>
								<th>Nama Dokumen</th>
								<th>Data Match</th>
								<th>Data Unmatch</th>
								<th>Total Data</th>
								<th style="text-align : center;">Aksi</th>							
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;							
							while($dq = mssql_fetch_array($q)) {
						?>
							<tr>								
								<th scope="row">
									<?php echo $no; ?>
								</th> 
																
								<td><?php echo $dq['id']; ?></td>

								<td><?php echo $dq['mapping_date'];?></td>
								
								<td><?php echo $dq['file_name'];?></td>
								
								<td><?php 
								$dataId = $dq['id'];
								$match = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $dataId AND status = 'match'");
								$totalMatch = mssql_num_rows($match);
								echo $totalMatch 
								?></td>
								
								<td><?php 
								$unmatch = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $dataId AND status = 'unmatch'");
								$totalUnmatch = mssql_num_rows($unmatch);
								echo $totalUnmatch ?></td>
								
								<td><?php
								$totalData = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $dataId");
								echo mssql_num_rows($totalData);?></td>
								
								<td style="text-align : center;">
								<a type="submit" href="media.php?module=detail&id=<?php echo $dataId;?>"	
												class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="bottom"
												title="Detail"><i class="fa fa-search"></i></a>	
								<a type="submit" href="excel/export_excel.php?id=<?php echo $dataId;?>"
												class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="bottom"
												title="Export Excel"><i class="fa fa-download"></i></a>	
								</td>
							</tr>								

							<!-- ======================= modal ===================================== -->
							<div id="myModal<?php echo $dq['id'];?>" class="modal fade">
								<div class="modal-dialog " style="overflow-y: initial !important">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title">Masukkan No. BK dan No. MM</h4>
										</div>
										<div class="modal-body" style="overflow-y: auto;">
											<form action="config/baca_file.php?file=<?php echo $fileName;?>&id=<?php echo $fileId;?>" method="post">
												<input type="text" class="user" name="no_bk" placeholder="No BK" required="">
												<input type="text" class="user" name="no_mm" placeholder="No MM" required="">
												<input type="submit" class="btn btn-success btn-sm" value="Rekon">
											</form>														
										</div>
									</div>
								</div>
							</div>
							<!-- ======================= modal ===================================== -->

						<?php
								$no++;
							}
						?>
					</table>
				</div>
			</div>
	</div>
</div>


<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		
		$('#user_data').DataTable({"scrollX": true});
		
		$('#myModal').on('show.bs.modal', function (e) {
			var loadurl = $(e.relatedTarget).data('whatever');
			$(this).find('.modal-body').load(loadurl);
		});

		//fetch_data();

		function fetch_data() {
			var url_string = window.location.href
			var url = new URL(url_string);
			var c = url.searchParams.get("q");
			
			
			var dataTable = $('#user_data').DataTable({
				"bServerSide": true,
                "bProcessing": true,
				"bSearchable": true,
				"scrollX": true,
				"ajax" : {
					url: "modul/fetch.php",
					method: "POST",
					data:{ status_klaim:c },
				},
			});
		}

		// function update_data(id, column_name, value) {
		// 	$.ajax({
		// 		url:"update.php",
		// 		method:"POST",
		// 		data:{id:id, column_name:column_name, value:value},
		// 		success:function(data) {
		// 			$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
		// 			$('#user_data').DataTable().destroy();
		// 			fetch_data();
		// 		}
		// 	});
		// 	setInterval(function(){
		// 		$('#alert_message').html('');
		// 	}, 5000);
		// }

		// $(document).on('blur', '.update', function() {
		// 	var id = $(this).data("id");
		// 	var column_name = $(this).data("column");
		// 	var value = $(this).text();
		// 	update_data(id, column_name, value);
		// });

		
	});
	
	function downloadFile(strParam) {
		window.open(document.getElementById("cmbDokumen"+strParam).value, '');
	}

	/*$(document).ready(function() {
		$('#example').DataTable();
		
		$('#myModal').on('show.bs.modal', function (e) {
			var loadurl = $(e.relatedTarget).data('whatever');
			$(this).find('.modal-body').load(loadurl);
		});
		
	} );*/
</script>