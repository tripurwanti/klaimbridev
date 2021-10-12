<?php
$p = new Paging;
$batas  = 5;
$posisi = $p->cariPosisi($batas);
$posisx	= $posisi + 1;
$batasx	= $batas * $posisx;

if ($_GET[sby]<>'') {
	$title 	= "Belum Dicek:";
	$sq		= "SELECT * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_rekam) as row FROM dbo.bri_pengajuan_refund WHERE status_proses = '') a WHERE row >= $posisx and row <= $batasx;";
	$saq	= "SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_rekam) as row FROM dbo.bri_pengajuan_refund WHERE status_proses = ''";
}

if ($_GET[q]=='x') {
	$title 	= "Belum Dicek:";
	$sq		= "SELECT * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_rekam) as row FROM dbo.bri_pengajuan_refund WHERE status_proses = '') a WHERE row >= $posisx and row <= $batasx;";
	$saq	= "SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_rekam) as row FROM dbo.bri_pengajuan_refund WHERE status_proses = ''";
} else {
	$title = "Seluruh Data:";
	$sq 	= "SELECT * FROM bri_pengajuan_refund ORDER BY tgl_rekam DESC LIMIT $posisi, $batas;";
}
$q = mssql_query($sq);
$aq = mssql_query($saq);
$rq = mssql_num_rows($aq);
?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Dokumen Refund
			<span style="float: right;">
				<div data-example-id="simple-form-inline"> 
					<form class="form-inline" method="GET"> 
						<input name="module" type="hidden" value="<?php echo $_GET['module']; ?>">
						<input name="q" type="hidden" value="<?php echo $_GET['q']; ?>">
						<div class="form-group"> 
							<select name="sby" class="form-control" >
								<option value="no_sertifikat">No. Sertifikat</option>
								<option value="no_rekening">No. Rekening</option>
								<option value="tgl_pengajuan">Tanggal Pengajuan</option>
								<option value="tgl_pelunasan">Tanggal Pelunasan</option>
								<option value="tgl_rekam">Tanggal Rekam</option>
							</select>
						</div> 
						<div class="form-group"> 
							<input name="sval" type="text" class="form-control" placeholder="Pencarian" style="width:300px"> 
						</div> 
						<button type="submit" class="btn btn-primary">Cari</button> 
					</form> 
				</div>
			</span>
		</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
					<h4><?php echo $title." ".$rq; ?></h4>
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th width="150px">#</th> 
								<th>Data</th> 
							</tr> 
						</thead> 
						<tbody>
						<?php
							$no = $posisx;
							while($dq = mssql_fetch_array($q)) {
						?>
							<tr> 
								<th scope="row">
									<?php echo $no; ?>
									<a href="" style="float:right;"><i class="fa fa-download"></i> Download </a>
								</th> 
								<td>
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#col<?php echo $no; ?>" aria-expanded="false" aria-controls="col<?php echo $no; ?>" class="">
										<div class="mail"><p>No. Sertifikat: <b><?php echo $dq[no_sertifikat]; ?></b></p></div>
									</a>
									<br/>
									<div id="col<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="mail-body">
											<p>
												No. Rekening: <b><?php echo $dq[no_rekening]; ?></b><br/>
												Tanggal Pengajuan: <b><?php echo date("d-m-Y", strtotime($dq[tgl_pengajuan])); ?></b><br/>
												Tanggal Pelunasan: <b><?php echo date("d-m-Y", strtotime($dq[tgl_pelunasan])); ?></b><br/>
												Tenor: <b><?php echo $dq[tenor]; ?></b><br/>
												Bulan Berjalan: <b><?php echo $dq[bulan_berjalan]; ?></b><br/>
												Nilai Refund: Rp. <b><?php echo $dq[nilai_refund]; ?></b><br/>
												Tanggal Rekam: <b><?php echo date("d-m-Y", strtotime($dq[tgl_rekam])); ?></b><hr/>
												<div data-example-id="simple-form-inline"> 
													<form class="form-inline"> 
														<div class="form-group">
															<label for="radio" ><b>Persetujuan: &nbsp;</b></label>
															<select name="fieldS" class="form-control">
																<option value="1">Setuju</option>
																<option value="2">Dokumen Belum Lengkap</option>
															</select>
														</div>&nbsp;
														<button type="button" class="btn btn-primary">Simpan</button> 
													</form> 
												</div>
											</p>
										</div>
									</div>
								</td> 
							</tr> 
						<?php
							$no++;
							}
						?>
						</tbody> 
					</table><hr/>
					<?php
						$jmldata 	 = $rq;
						$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
						$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);	
						echo "<p align='center'>$linkHalaman</p>";
					?>
				</div>
			</div>
	</div>
</div>