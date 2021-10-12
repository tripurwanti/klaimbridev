<script>
function confirmdelete(delUrl) {
	if (confirm("Delete data?")) {
		document.location = delUrl;
	}
}
</script>
<?php
	$p = $_GET['q'];
	if ($p=='view') {
		$q = mysql_query("SELECT * FROM wbs ORDER BY id DESC;");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Contact us <small>WBS </small>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<div class="box">
			<div class="box-header">
                <h3 class="box-title">View Contact us</h3>
                <div class="box-tools">
					<div class="input-group">
						<input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
						<div class="input-group-btn">
							<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
						</div>
                    </div>
                </div>
            </div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover table-bordered table-striped">
                    <tr>
						<th>ID</th>
						<th>Message</th>
						<th>Date</th>
						<th>#</th>
                    </tr>
					<?php 
						$no = 1;
						while ($dq = mysql_fetch_array($q)) {
					?>
                    <tr>
						<td><?php echo $no; ?></td>
						<td>
							<?php
								if ($dq[file]=='') {
									$icon = "fa-minus";
								} else {
									$icon = "fa-picture-o";
								}
							?>
							<i class="fa <?php echo $icon; ?>"></i> &nbsp;&nbsp; 
							<?php 
								if (strlen($dq[pesan])>100) {
									echo substr($dq[pesan],0,100)." ..."; 
								} else {
									echo $dq[pesan]; 
								}
							?>
						</td>
						<td><?php echo tgl_indo($dq[tanggal]); ?></td>
						<td>
							<a href="media.php?module=contact_us_wbs&q=reply&id=<?php echo $dq[id]; ?>" class="btn btn-success btn-xs">View</a> 
							<a href="javascript:confirmdelete('modul/contact_us/aksi_contact_us.php?act=deletewbs&id=<?php echo $dq[id]; ?>')" class="btn btn-danger btn-xs">Delete</a></td>
                    </tr>
					<?php
						$no++;
						}
					?>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
	</section><!-- /.content -->
</div>
<?php
		
	} elseif ($p=='reply') {
		$q = mysql_query("SELECT * FROM wbs WHERE id = '$_GET[id]'");
		$dq = mysql_fetch_array($q);
		$title = "View Message";
		$stitle = "View WBS from people...";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			<?php echo $title; ?>
            <small><?php echo $stitle; ?></small>
			<a href="media.php?module=contact_us_wbs&q=view" class="btn btn-warning btn-sm" style="float: right;">Cancel</a>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<form role="form" action="modul/contact_us/aksi_contact_us.php?act=replygeneral" method="POST" enctype="multipart/form-data"> 
		<input name="id" type="hidden" value="<?php echo $dq[id]; ?>">
		<!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
				<h3 class="box-title">Message #<?php echo $dq[id]; ?></h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
            <div class="box-body">
				<div class="mailbox-read-info">
                    <h3><?php echo $dq[nama]; ?></h3>
                    <h5>Email: <b><?php echo $dq[email]; ?></b> <span class="mailbox-read-time pull-right"><?php echo tgl_indo($dq[tanggal]); ?></span></h5>
                </div>
				<div class="mailbox-read-message">
					<table>
						<tr>
							<td style="width: 80px;">Telepon:</td>
							<td width="40%">
								<b><?php echo $dq[telepon]; ?></b>
							</td>
							<td style="width: 80px;">Tipe:</td>
							<td width="40%">
								<b><?php echo $dq[tipe]; ?></b>
							</td>
						</tr>
						<tr>
							<td style="width: 80px;">Tentang:</td>
							<td width="40%">
								<b><?php echo $dq[tentang]; ?></b>
							</td>
							<td style="width: 80px;">Alamat:</td>
							<td width="40%">
								<b><?php echo $dq[alamat]; ?></b>
							</td>
						</tr>
						<tr>
							<td style="width: 80px;">Lokasi:</td>
							<td width="40%">
								<b><?php echo $dq[lokasi]; ?></b>
							</td>
						</tr>
					</table>
					<br/>
                    <p>
						<?php echo $dq[pesan]; ?>
					</p>
					<hr/>
					<ul class="mailbox-attachments clearfix">
						<li>
						  <span class="mailbox-attachment-icon"><img src="<?php echo $loadurl."files/image/wbs/".$dq[file]; ?>" alt="Attachment" style="width: 100%;"></span>
						  <div class="mailbox-attachment-info">
							<span class="mailbox-attachment-size">
							  &nbsp;
							  <a href="<?php echo $loadurl."files/image/wbs/".$dq[file]; ?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
							</span>
						  </div>
						</li>
					</ul>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
		</form>
	</section><!-- /.content -->
</div>

<?php
	}
?>