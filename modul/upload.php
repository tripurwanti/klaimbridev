<?php
// $status = $_GET['status'];

// if($status){
// 	if($status == 1){
// 		echo "
// 		<script>
// 		alert('file berhasil di upload');
// 		</script>
// 		";
// 	} elseif($status == 2){
// 		echo "
// 		<script>
// 		alert('file excel tidak sesuai');
// 		</script>
// 		";
// 	} else {
// 		echo "
// 		<script>
// 		alert('Upload file Excel');
// 		</script>
// 		";
// 	}
// }
?>

<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Pelunasan Klaim</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
                	<div class="container">
						<div class="column">
							<div class="col-md-8">
								<form action="config/upload_klaim.php" method="post" enctype="multipart/form-data">
									Pilih file RC:
									<br>
										<div class="input-group-sm col-md-6">
										<input type="file" [accept]="accept" name="fileToUpload" id="fileToUpload"
												(change)="processFile(imageInput)" class="form-control">
										</div>
										<div class="input-group-append col-md-2" style="margin-left: -20px; margin-top: 3px;">
										<select name="bank">
											<option value="BRI">Bank BRI</option>
											<!-- <option value="Mandiri">Bank Mandiri</option>
											<option value="BNI">Bank BNI</option>
											<option value="BTN">Bank BTN</option> -->
										</select>
										</div>
										<div class="input-group-append col-md-2">
										<button type="submit"
												class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="bottom"
												title="Upload"><i class="fa fa-upload"></i></button>
										</div>
									</div>
								</form>
							</div>

							<div class="col-md-4">
								<!-- <form action="config/download_template_RC.php" method="post"> -->
								<form action="config/cekNoRek.php" method="post">
								Download template Excel
								<br>
									<input class="btn" type="submit" name="submit" value="Download File" />
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>


<!-- <div id="myModal" class="modal fade">
	<div class="modal-dialog " style="overflow-y: initial !important">width: 75%
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Download Dokumen</h4>
			</div>
			<div class="modal-body" style="overflow-y: auto;">
				<p>Loading...</p>
			</div>
		</div>
	</div>
</div> -->


