<?php
	$p = $_GET['q'];
	if ($p=='view') {
		$q = mysql_query("SELECT * FROM _post ORDER BY post_id DESC;");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Article
            <small><a href="media.php?module=article&q=new" class="btn btn-primary btn-sm">New Article</a></small>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<div class="box">
			<div class="box-header">
                <h3 class="box-title">View Article</h3>
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
						<th>Title</th>
						<th>Date</th>
						<th>#</th>
                    </tr>
					<?php 
						$no = 1;
						while ($dq = mysql_fetch_array($q)) {
					?>
                    <tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $dq[id_title]; ?></td>
						<td><?php echo tgl_indo($dq[create_time]); ?></td>
						<td><a href="media.php?module=article&q=edit&id=<?php echo $dq[post_id]; ?>" class="btn btn-success btn-xs">Edit</a> <a href class="btn btn-danger btn-xs">Delete</a></td>
                    </tr>
					<?php
						$no++;
						}
					?>
                    <tr>
						<td>219</td>
						<td>Alexander Pierce</td>
						<td>11-7-2014</td>
						<td><span class="label label-warning">Pending</span></td>
                    </tr>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
	</section><!-- /.content -->
</div>
<?php
		
	} elseif ($p=='new') {
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			New Article
            <small>Type your new article in here...</small>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<form role="form" action="modul/article/aksi_article.php?act=new" method="POST" enctype="multipart/form-data"> 
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
		
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
			<div class="box-body">
				<div class="form-group">
					<label>Category</label>
					<select class="form-control" name="category">
						<?php
							$qc = mysql_query("SELECT * FROM _category ORDER BY category_id DESC;");
							while ($dqc = mysql_fetch_array($qc)) {
						?>
						<option value="<?php echo $dqc['category_id']; ?>"><?php echo $dqc['id_name']; ?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Date </label>
					<input name="date" type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" style="width: 10%"><?php echo tgl_indo(date("Y-m-d")); ?>
				</div>
				<div class="form-group">
                    <label>Image</label>
                    <input type="file" id="exampleInputFile">
                    <p class="help-block">ext *.JPG, *.JPEG (200x150).</p>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
		</form>
	</section><!-- /.content -->
</div>

<?php
	}
?>