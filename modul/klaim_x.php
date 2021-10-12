<script>
function downloadFile(strParam) {
	window.open(document.getElementById("cmbDokumen"+strParam).value, '');
}

$(document).ready(function() {
    $('#example').DataTable();
	
	$('#myModal').on('show.bs.modal', function (e) {
		var loadurl = $(e.relatedTarget).data('whatever');
		$(this).find('.modal-body').load(loadurl);
	});
	
} );
</script>
<?php
if ($_GET[range]!='') {
	$range = "TOP ".$_GET[range];
	$subtrange = "Data yang ditampilkan hanya ".$_GET[range]." data | <a href='media.php?module=$_GET[module]&q=$_GET[q]'>Lihat semua data</a>";
} else {
	$range = "";
	$subtrange = "";
}

//Default!
if ($_GET[q]=='2') {
	$title 	= "Belum Diverifikasi:";
	$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '0' AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
	$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2 a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '0' AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
	
} else if ($_GET[q]=='3') {
	$title 	= "Data Lengkap:";
	$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '4' AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
	$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2 a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '4' AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
} else if ($_GET[q]=='4') {
	$title 	= "Tidak Lengkap:";
	$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '3' AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
	$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2 a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '3' AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
} else if ($_GET[q]=='5') {
	$title 	= "Data Disetujui:";
	$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '2' AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
	$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2 a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '2' AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
} else if ($_GET[q]=='6') {
	$title 	= "Data Ditolak:";
	$sq 	= "SELECT ".$range." * FROM (SELECT TOP 1 *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2_tolak_op) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '1' AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
	$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2_tolak_op a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND c.status = '1' AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
} else if ($_GET[q]=='1') {
	if ($_SESSION[id_kantor]=='x') { //abaikan yang ini dulu
		$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY CONVERT(datetime, tgl_kirim, 103) DESC) as row FROM dbo.pengajuan_klaim_kur_gen2) a, dbo.BRI_PENYEBAB_KLAIM b WHERE a.ket_penyebab_klaim = b.kode AND row >= $posisx and row <= $batasx order by ROW ASC;";
		$saq	= "SELECT a.no_rekening, ROW_NUMBER() OVER (ORDER BY tgl_kirim) as row FROM dbo.pengajuan_klaim_kur_gen2;";
	} else {
		$title = "Seluruh Data:";
		$sq 	= "SELECT ".$range." * FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_respond_klaim DESC) as row FROM pengajuan_klaim_kur_gen2) a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND a.cabang_rekanan = '$_SESSION[id_kantor]' ORDER BY ROW ASC;";
		$saq	= "SELECT a.no_rekening FROM pengajuan_klaim_kur_gen2 a, jawaban_klaim_kur_gen2 c WHERE a.no_rekening = c.no_rekening AND a.cabang_rekanan = '$_SESSION[id_kantor]';";
	}
}

$q 	= mssql_query($sq);
$aq = mssql_query($saq);
$rq = mssql_num_rows($aq);
?>
<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Pengajuan Klaim</h3>
			<div class="tables">
				<div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
					<h4><?php echo $title." ".$rq."<br/><small>".$subtrange."</small>"; ?></h4>
					
					<table id="example" class="table"> 
						<thead> 
							<tr> 
								<th width="30px">#</th> 
								<th>Data</th> 
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
								<td>
									<?php
										if ($_GET['q']==1) {
											if ($dq['status']=='2') {
												echo "<i class='fa fa-thumbs-up' style='color: #4caf50' title='Data Disetujui'></i> &nbsp;";
											} else if ($dq['status']=='1') {
												echo "<i class='fa fa-thumbs-down' style='color: #f44336' title='Data Ditolak'></i> &nbsp;";
											} else if ($dq['status']=='0') {
												echo "<i class='fa fa-edit' style='color: #ff9800' title='Belum Diverifikasi'></i> &nbsp;";
											} else if ($dq['status']=='4') {
												echo "<i class='fa fa-check' style='color: #2196f3' title='Data Lengkap'></i> &nbsp;";
											} else if ($dq['status']=='3') {
												echo "<i class='fa fa-frown-o' style='color: #795548' title='Tidak Lengkap'></i> &nbsp;";
											}
										}
									?>
									<a role="button" title="Klik untuk melihat detail" data-toggle="collapse" data-parent="#accordion" href="#col<?php echo $no; ?>" aria-expanded="false" aria-controls="col<?php echo $no; ?>" class="">
										<div class="mail"><p>No. Sertifikat: <b><?php echo $dq[nomor_ssertifikat]; ?></b> <small>(<?php echo $dq[no_rekening]; ?>)</small></p></div>
									</a>
									<span style="float: right"><?php echo date("d-m-Y H:i:s", strtotime($dq[created_date])); ?></span>
									<br/>
									<div id="col<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="mail-body">
											<p>
												No. Rekening: <b><?php echo $dq[no_rekening]; ?></b><br/>
												Nama Debitur: <b><?php echo $dq[nama_debitur]; ?></b><br/>
												Jumlah Baki Debet: Rp. <b><?php echo number_format($dq[tunggakan_pokok], 2, ",", "."); ?></b><br/>
												Jumlah Tuntutan: Rp. <b><?php echo number_format($dq[nilai_tuntutan_klaim], 2, ",", "."); ?></b><br/>
												Plafond Kredit: Rp. <b><?php echo number_format($dq[plafond], 2, ",", "."); ?></b><br/>
												Tanggal Penjaminan: <b><?php echo date("d-m-Y", strtotime($dq[tgl_mulai])); ?></b><br/>
												No. STGR: <b><?php echo $dq[no_spk]; ?></b><br/>
												Tanggal STGR: <b><?php echo date("d-m-Y", strtotime($dq[tgl_spk])); ?></b><br/>
												Tanggal Kirim: <b><?php echo $dq[tgl_respond_klaim]; ?></b><br/>
												Penyebab Klaim: <b><?php echo $dq[sebab_klaim]; ?></b><br/>
												Jawaban: <b><?php echo $dq[ket]; ?></b><br/>
												<?php 
													$dqIn = mssql_fetch_array(mssql_query("SELECT * FROM inquiry_klaim WHERE no_rekening = '$dq[no_rekening]'"));
												?>
												Inquiry oleh BNI: <b><?php echo $dqIn[sys_autodate]; ?></b><hr/>
												
												<button class="btn btn-success" data-toggle="modal" data-target="#myModal" data-whatever="modul/modal_preview.php?q=<?php echo $_GET[q]; ?>&no_fasilitas=<?php echo $dq[no_rekening]; ?>&plafond=<?php echo $dq[plafond]; ?>&tgl_mulai=<?php echo $dq[tgl_mulai]; ?>"><i class="fa fa-search"></i> &nbsp;Lihat Dokumen</button>
												
												<!--
												<a href="modul/modal_preview.php?q=<?php echo $_GET[q]; ?>&no_fasilitas=<?php echo $dq[no_rekening]; ?>&plafond=<?php echo $dq[plafond]; ?>&tgl_mulai=<?php echo $dq[tgl_mulai]; ?>" class="ls-modal" title="Lihat Data">
													<i class="fa fa-search" style="color: #f1ae4e"></i> <b>Lihat Dokumen</b>
												</a>
												-->
												
												<!--
												 
												-->
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
					</table>
				</div>
			</div>
	</div>
</div>


<div id="myModal" class="modal fade">
	<div class="modal-dialog " style="overflow-y: initial !important"><!-- width: 75% -->
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
</div>