<?php
$fileName = "";
$fileId = 0;
$isLoading = FALSE;
?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">List Data RC</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
				<?php
					if ($_GET['q'] == 'all') {
						$kondisi = "";
					} else {
						$kondisi = "AND a.status_klaim = '$_GET[q]'";
					}
					// $q = mssql_query("SELECT TOP 50 a.*, b.nama_debitur FROM pengajuan_klaim_kur_gen2 a, sp2_kur2015 b WHERE a.no_rekening = b.no_rekening AND substring(a.no_sertifikat, 4, 2) = '$_SESSION[id_kantor]' $kondisi ORDER BY a.tgl_kirim DESC");
					$q = mssql_query("SELECT * FROM file_rc ORDER BY id DESC");
					$rq = mssql_num_rows($q);
				?>
					<h4><?php echo $_GET[title]." <small>(Menampilkan ".$rq." Data dari Total Data)<br/>".$subtrange."</small>"; ?></h4>
					<div id="alert_message"/>
					<table id="user_data" class="table display nowrap" cellspacing="0" width="100%"> 
						<thead>
							<tr>
								<th>#</th>
								<!-- <?php
									if ($_GET['q'] != 'all') {
										echo "<th></th>";
									}
								?> -->
								<th>Id</th>
								<th style="text-align : center;">Aksi</th>
								<th>Nama Dokumen</th>
								<!-- <th>Bank</th> -->
								<th>Tanggal Upload</th>
								<th style="text-align : center;">Total Record</th>
								<th>Total Amount</th>
								<th>No BK</th>
								<th>No MM</th>
								<th>Tanggal BK</th>
								<th>Tanggal MM</th>
															
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
								<!-- <?php
									if ($_GET['q'] != 'all') {
								?>
								<td>
									<button alt="Lihat Dokumen" type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#myModal" data-whatever="modul/modal_preview.php?q=<?php echo $_GET[q]; ?>&no_fasilitas=<?php echo $dq[no_rekening]; ?>&plafond=<?php echo $dq[jml_baki_debet]; ?>&tgl_mulai=<?php echo $dq[tgl_mulai]; ?>"><i class="fa fa-search"></i> </button>
								</td>
								<?php
									}
								?> -->
								<td><?php echo $dq['id']; ?></td>
								<td style="text-align : center;">
								<a type="submit" href="excel/export_excel_RC.php?file=<?php
                                $fileName = $dq['documen_name'];
                                $fileId = $dq['id'];
                                echo $dq['documen_name']?>&id=<?php echo $dq['id'];?>"
												class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="bottom"
												title="Download File Excel"><i class="fa fa-download"></i></a>
								<?php
                        		if ($_SESSION[username] == 'admin' || $_SESSION[username] == 'ask.akuntansi') {
                            	?>					
								<a type="submit" class="btn btn-outline-success btn-sm" data-placement="bottom" 
												data-toggle="modal" data-target="#myModal<?php echo $dq['id'];?>"
												data-toggle="tooltip"
												title="Posting"><i class="fa fa-file"></i></a>
								<?php
								}
								?>	
								</td>
								<td><?php echo $dq['documen_name']; ?></td>
								<!-- <td><?php echo $dq['bank_name']; ?></td> -->
								<td><?php echo $dq['upload_date']; ?></td>
								<td style="text-align : center;">
								<?php echo $dq['total_record'];?></td>
								<td><?php echo number_format($dq['total_amount'],2); ?></td>								
								<td><?php echo $dq['no_bk']; ?></td>
								<td><?php echo $dq['no_mm']; ?></td>
								<td><?php echo $dq['tgl_bk']; ?></td>
								<td><?php echo $dq['tgl_mm']; ?></td>
								
							</tr>

							<!-- ======================= modal ===================================== -->
							<div id="myModal<?php echo $dq['id'];?>" class="modal fade">
								<div class="modal-dialog " style="overflow-y: initial !important"><!-- width: 75% -->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title">Masukkan No. BK dan No. MM</h4>
										</div>
										<div class="modal-body" style="overflow-y: auto;">
											<!-- <form action="config/baca_file.php?file=<?php echo $fileName;?>&id=<?php echo $fileId;?>" method="post"> -->
											<form method="post" id="form">	
												<div class=col-sm-8 style="margin-bottom : 3px">
												<label for="example-search-input" class="col-form-label">No BK</label>
												<input type="text" class="form-control" name="no_bk" id="no_bk_<?php echo $fileId;?>" required>
												</div>
												<div class=col-sm-4 style="margin-bottom : 3px">
												<label for="example-search-input" class="col-form-label">Tanggal BK</label>
												<input type="date" class="form-control" name="tgl_bk" id="tgl_bk_<?php echo $fileId;?>" required>
												</div>
												<br>
												<div class=col-sm-8 style="margin-bottom : 3px">
												<label for="example-search-input" class="col-form-label">No MM</label>
												<input type="text" class="form-control" name="no_mm" id="no_mm_<?php echo $fileId;?>" required>
												</div>
												<div class=col-sm-4 style="margin-bottom : 3px">
												<label for="example-search-input" class="col-form-label">Tanggal MM</label>
												<input type="date" class="form-control" name="tgl_mm" id="tgl_mm_<?php echo $fileId;?>" required>
												</div>
												<br>
												<div style="margin-left : 15px">
												<!-- <input type="submit" class="btn btn-success btn-sm" value="Posting" id="posting"> -->
												<a href="#" type="submit" class="btn btn-success btn-sm"  onclick="posting('<?php echo $fileName;?>','<?php echo $fileId;?>')" id="posting">Posting</a>
												</div>
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

<!-- ====================== loading ==================================== -->

<div id="loading" class="modal">
	<!-- <div class="modal-dialog " style="overflow-y: initial !important"> -->
		<!-- <div class="modal-content"> -->
		<div class="loader" style="
							border: 16px solid #f3f3f3; /* Light grey */
							border-top: 16px solid #3498db; /* Blue */
							border-radius: 50%;
							width: 120px;
							height: 120px;
							animation: spin 2s linear infinite;
							margin-left : 50%;
							margin-top : 20%;								

							@keyframes spin {
							0% { transform: rotate(0deg); }
							100% { transform: rotate(360deg); }
							}"></div>
		</div>
	</div>
</div>
<!-- ====================== loading ==================================== -->

<script type="text/javascript" language="javascript" >
// $("#loading").hide();

	function posting(name, id){
		var no_bk = $("#no_bk_"+id).val();
		var tgl_bk = $("#tgl_bk_"+id).val();
		var no_mm = $("#no_mm_"+id).val();
		var tgl_mm = $("#tgl_mm_"+id).val();
		
		if(no_bk == '' || tgl_bk == '' || no_mm == '' || tgl_mm == ''){
			alert("Form tidak boleh kosong");
		} else {
			$("#loading").show();
			$.ajax({
			method: "POST",
			url: "config/baca_file.php?file="+name+"&id="+id,
			data: {no_bk: no_bk, no_mm: no_mm, tgl_mm: tgl_mm, tgl_bk: tgl_bk},
			success: function(data){
				$("#loading").hide();
				alert("File berhasil di posting");
				window.location.href='http://10.10.1.247:81/klaimbridev/media.php?module=listData';
			},
			error: function(error){
				alert(error);
			}
		})
		}
		// console.log("config: config/baca_file.php?file="+name+"&id="+id);
	}

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