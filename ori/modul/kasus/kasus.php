<script>
function confirmdelete(delUrl) {
	if (confirm("Hapus Data?")) {
		document.location = delUrl;
	}
}
</script>
<?php
	$p = $_GET['q'];
	if ($p=='data') {
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Permasalahan Hukum
            <?php if ($_SESSION[leveluser] == '1') { ?><small><a href="media.php?module=kasus&q=new" class="btn btn-primary btn-sm">Tambah Data Permasalahan Hukum</a></small><?php } ?>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<div class="box">
			<div class="box-header">
                <h3 class="box-title">Data Permasalahan Hukum</h3>
            </div><!-- /.box-header -->
			<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
						<th width="100px" >#</th>
                        <th>Deskripsi</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php
							$q = mysql_query("SELECT * FROM kasus ORDER BY id_kasus DESC");
							while($dq = mysql_fetch_array($q)){
						?>
						<tr>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-success">Pilih</button>
									<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="media.php?module=kasus&q=view&id=<?php echo $dq['id_kasus']; ?>">Lihat</a></li>
										<?php if ($_SESSION[leveluser] == '1') { ?>
										<li><a href="media.php?module=kasus&q=edit&id=<?php echo $dq['id_kasus']; ?>">Edit</a></li>
										<li class="divider"></li>
										<li><a href="javascript:confirmdelete('modul/kasus/aksi_kasus.php?act=delete&id=<?php echo $dq[id_kasus]; ?>')">Hapus</a></li>
										<?php } ?>
									</ul>
								</div><br/>
								<i class="fa fa-fw fa-eye"></i> <?php echo $dq['baca']; ?>
							</td>
							<td>
								<table>
									<tr>
										<td>Judul:&nbsp;&nbsp;</td><td><b><?php echo $dq['judul']; ?></b></td>
									</tr>
									<tr>
										<td>Penjamin:&nbsp;&nbsp;</td><td><b><?php echo $dq['penjamin']; ?></b></td>
									</tr>
									<tr>
										<td>Penerima Jaminan:&nbsp;&nbsp;</td><td><b><?php echo $dq['penerima_jaminan']; ?></b></td>
									</tr>
									<tr>
										<td>Obligee:&nbsp;&nbsp;</td><td><b><?php echo $dq['obligee']; ?></b></td>
									</tr>
									<tr>
										<td>Principal:&nbsp;&nbsp;</td><td><b><?php echo $dq['principal']; ?></b></td>
									</tr>
									<tr>
										<td>Produk Penjaminan:&nbsp;&nbsp;</td><td><b><?php echo $dq['produk_penjaminan']; ?></b></td>
									</tr>
									<tr>
										<td>Pekerjaan:&nbsp;&nbsp;</td><td><b><?php echo $dq['pekerjaan']; ?></b></td>
									</tr>
									<tr>
										<td>Jangka Waktu:&nbsp;&nbsp;</td><td><b><?php echo $dq['jangka_waktu']; ?></b></td>
									</tr>
									<tr>
										<td>Nilai Jaminan:&nbsp;&nbsp;</td><td><b>Rp. <?php echo number_format($dq['nilai_jaminan'], "2", ",", "."); ?></b></td>
									</tr>
								</table>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
	</section><!-- /.content -->
</div>
<?php
	} elseif ($p=='new' || $p=='edit') {
		if ($_GET['id']<>'') {
			$qx = mysql_query("SELECT * FROM kasus WHERE id_kasus = '$_GET[id]'");
			$dqx = mysql_fetch_array($qx);
			$judul = "<h1>Edit Data Permasalahan Hukum #".$dqx[id_kasus]." <small>Silahkan edit data permasalahan hukum...</small></h1>";
			$lampiran = "(Kosongkan jika tidak mengubah file)";
			$aksiform = "edit";
		} else {
			$judul = "<h1>Tambah Data Permasalahan Hukum<small>Silahkan masukkan data permasalahan hukum...</small></h1>";
			$aksiform = "new";
		}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php echo $judul; ?>
	</section>

	<!-- Main content -->
    <section class="content">
		<form role="form" action="modul/kasus/aksi_kasus.php?act=<?php echo $aksiform; ?>" method="POST" enctype="multipart/form-data"> 
		<input name="id_kasus" type="hidden" value="<?php echo $dqx[id_kasus]; ?>">
		<!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
				<h3 class="box-title">Data Permasalahan Hukum</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
            <div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Judul</label>
							<input name="judul" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[judul]; ?>">
						</div>
						<div class="form-group">
							<label>Penjamin</label>
							<input name="penjamin" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[penjamin]; ?>">
						</div>
						<div class="form-group">
							<label>Penerima Jaminan</label>
							<input name="penerima_jaminan" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[penerima_jaminan]; ?>">
						</div>
						<div class="form-group">
							<label>Obligee</label>
							<input name="obligee" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[obligee]; ?>">
						</div>
						<div class="form-group">
							<label>Principal</label>
							<input name="principal" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[principal]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Produk Penjaminan</label>
							<input name="produk_penjaminan" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[produk_penjaminan]; ?>">
						</div>
						<div class="form-group">
							<label>Pekerjaan</label>
							<input name="pekerjaan" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[pekerjaan]; ?>">
						</div>
						<div class="form-group">
							<label>Nilai Jaminan</label>
							<input name="nilai_jaminan" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[nilai_jaminan]; ?>">
						</div>
						<div class="form-group">
							<label>Jangka Waktu</label>
							<input name="jangka_waktu" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[jangka_waktu]; ?>" id="reservation">
						</div>
						<div class="form-group">
							<label>Lampiran</label>
							<input type="file" id="exampleInputFile" name="fupload" accept=".pdf">
							<p class="help-block">ext *.PDF <font color=red><?php echo $lampiran; ?></font></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea name="deskripsi" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
								<?php echo $dqx[deskripsi]; ?>
							</textarea>
						</div>
						<div class="form-group">
							<label>Pendapat</label>
							<textarea name="pendapat" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
								<?php echo $dqx[pendapat]; ?>
							</textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
		</form>
	</section><!-- /.content -->
</div>
<?php
	} elseif ($p=='view') {
		$lihat = mysql_query("UPDATE kasus SET baca = (baca + 1) WHERE id_kasus = '$_GET[id]'");
		$q = mysql_query("SELECT * FROM kasus WHERE id_kasus = '$_GET[id]'");
		$dq = mysql_fetch_array($q);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Permasalahan Hukum 
        </h1>
	</section>
	
	<!-- Main content -->
	<section class="invoice">
	<!-- title row -->
		<div class="row">
            <div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-legal"></i> &nbsp;Askrindo Legal Learning
					<small class="pull-right"><i class="fa fa-eye"></i> <?php echo $dq['baca']; ?> - ID Kasus: #<?php echo $dq['id_kasus']; ?></small>
				</h2>
            </div><!-- /.col -->
        </div>
          <!-- info row -->
		<div class="row invoice-info">
            <div class="col-sm-12 invoice-col">
				<table class="table table-striped" width="100%">
					<tr>
						<td width="160px">Judul:&nbsp;&nbsp;</td><td><b><?php echo $dq['judul']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Penjamin:&nbsp;&nbsp;</td><td><b><?php echo $dq['penjamin']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Penerima Jaminan:&nbsp;&nbsp;</td><td><b><?php echo $dq['penerima_jaminan']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Obligee:&nbsp;&nbsp;</td><td><b><?php echo $dq['obligee']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Principal:&nbsp;&nbsp;</td><td><b><?php echo $dq['principal']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Produk Penjaminan:&nbsp;&nbsp;</td><td><b><?php echo $dq['produk_penjaminan']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Pekerjaan:&nbsp;&nbsp;</td><td><b><?php echo $dq['pekerjaan']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Jangka Waktu:&nbsp;&nbsp;</td><td><b><?php echo $dq['jangka_waktu']; ?></b></td>
					</tr>
					<tr>
						<td width="160px">Nilai Jaminan:&nbsp;&nbsp;</td><td><b>Rp. <?php echo number_format($dq['nilai_jaminan'], "2", ",", "."); ?></b></td>
					</tr>
				</table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-sm-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Deskripsi</a></li>
						<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Pendapat</a></li>
						<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Lampiran</a></li>
					</ul>
                <div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<?php echo $dq['deskripsi']; ?>
					</div><!-- /.tab-pane -->
					<div class="tab-pane" id="tab_2">
						<?php echo $dq['pendapat']; ?>
					</div><!-- /.tab-pane -->
					<div class="tab-pane" id="tab_3">
						<!--<iframe src = "ViewerJS/#../databank/<?php echo $dq['file']; ?>" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>-->
						<iframe src = "databank/<?php echo $dq['file']; ?>" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
					</div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
    <div class="clearfix"></div>
</div><!-- /.content-wrapper -->
<?php
	}
?>