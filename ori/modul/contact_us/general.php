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
		$q = mysql_query("SELECT * FROM hubungikami ORDER BY tanggal DESC;");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Contact us <small>General </small>
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
								if ($dq[jawaban]=='') {
									$icon = "fa-square-o";
								} else {
									$icon = "fa-check-square-o";
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
							<a href="media.php?module=contact_us_general&q=reply&id=<?php echo $dq[id]; ?>" class="btn btn-success btn-xs">Reply</a> 
							<a href="javascript:confirmdelete('modul/contact_us/aksi_contact_us.php?act=delete&id=<?php echo $dq[id]; ?>')" class="btn btn-danger btn-xs">Delete</a></td>
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
		$q = mysql_query("SELECT * FROM hubungikami WHERE id = '$_GET[id]'");
		$dq = mysql_fetch_array($q);
		$title = "Reply Message";
		$stitle = "Type your message to reply...";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			<?php echo $title; ?>
            <small><?php echo $stitle; ?></small>
			<a href="media.php?module=contact_us_general&q=view" class="btn btn-warning btn-sm" style="float: right;">Cancel</a>
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
                    <h3><?php echo $dq[nama]; ?><font size="3">, <?php echo $dq[perusahaan]; ?></font></h3>
                    <h5>Email: <b><?php echo $dq[email]; ?></b> <span class="mailbox-read-time pull-right"><?php echo tgl_indo($dq[tanggal]); ?></span></h5>
					
                </div>
				<div class="mailbox-read-message">
                    <p>
						<?php echo $dq[pesan]; ?>
					</p>
                </div>
				<div class="form-group">
					<textarea name="jawaban" class="textarea" style="width: 100%; height: 140px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
						<?php echo $dq[jawaban]; ?>
					</textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Reply</button>
				</div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
		</form>
	</section><!-- /.content -->
</div>

<?php
	}
?>