<?php
	$mod = $_GET['module'];
	if ($mod=='commissioners') {
		$q = mysql_query("SELECT * FROM _management WHERE management_id = '1';");
		$dq = mysql_fetch_array($q);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Board of Commissioners
            <small></small>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<form role="form">
		<!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
				<h3 class="box-title">Indonesia</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
            <div class="box-body">
				<div class="form-group">
                    <label>Title</label>
					<input name="id_title" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dq[id_title]; ?>">
				</div>
				<textarea name="id_content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
					<?php echo $dq[id_content]; ?>
				</textarea>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
		
		<div class="box">
            <div class="box-header with-border">
				<h3 class="box-title">English</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
            <div class="box-body">
				<div class="form-group">
                    <label>Title</label>
					<input name="en_title" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dq[en_title]; ?>">
				</div>
				<textarea name="en_content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
					<?php echo $dq[en_content]; ?>
				</textarea>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
		<button type="submit" class="btn btn-primary">Save</button>
		</form>
	</section><!-- /.content -->
</div>
<?php
		
	}
?>