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
			Pengguna
            <small><a href="media.php?module=user&q=new" class="btn btn-primary btn-sm">Tambah Pengguna</a></small>
		</h1>
	</section>

	<!-- Main content -->
    <section class="content">
		<div class="box">
			<div class="box-header">
                <h3 class="box-title">Data Pengguna</h3>
            </div><!-- /.box-header -->
			<div class="box-body">
				<table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
						<th width="40px" >No</th>
						<th width="100px" >#</th>
                        <th>Username</th>
						<th>Nama Pengguna</th>
						<th>Level</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php
							$q = mysql_query("SELECT * FROM USER a, LEVEL b WHERE a.level = b.id_level;");
							$no = 1;
							while($dq = mysql_fetch_array($q)){
						?>
						<tr>
							<td>
								<?php echo $no; ?>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-success btn-sm">Pilih</button>
									<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="media.php?module=user&q=edit&id=<?php echo $dq['username']; ?>">Edit</a></li>
										<li><a href="javascript:confirmdelete('modul/user/aksi_user.php?act=delete&id=<?php echo $dq[username]; ?>')">Hapus</a></li>
									</ul>
								</div>
							</td>
							<td>
								<?php echo $dq['username']; ?>
							</td>
							<td>
								<?php echo $dq['namauser']; ?>
							</td>
							<td>
								<?php echo $dq['namalevel']; ?>
							</td>
						</tr>
						<?php
							$no++;
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
			$qx = mysql_query("SELECT * FROM USER a, LEVEL b WHERE a.level = b.id_level AND username = '$_GET[id]'");
			$dqx = mysql_fetch_array($qx);
			$judul = "<h1>Edit Data Pengguna #".$dqx[id_kasus]." <small>Silahkan edit data pengguna...</small></h1>";
			$pesan1 = "* Jangan Mengubah Username!";
			$pesan2 = "* Kosongkan Jika Tidak Mengubah Password!";
			$aksiform = "edit";
		} else {
			$judul = "<h1>Tambah Pengguna<small>Silahkan masukkan data pengguna...</small></h1>";
			$aksiform = "new";
			$pesan1 = "* Jangan Menggunakan Spasi! Username Harus UNIK!";
			$pesan2 = "* Password Harap Diingat";
		}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php echo $judul; ?>
	</section>

	<!-- Main content -->
    <section class="content">
		<form role="form" action="modul/user/aksi_user.php?act=<?php echo $aksiform; ?>" method="POST" enctype="multipart/form-data"> 
		<!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
				<h3 class="box-title">Data Pengguna</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
            </div>
            <div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Username </label>
							<input name="username" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[username]; ?>">
							<p><font color=red><?php echo $pesan1; ?></font></p>
						</div>
						<div class="form-group">
							<label>Nama Pengguna</label>
							<input name="namauser" type="text" class="form-control" placeholder="Type ..." value="<?php echo $dqx[namauser]; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input name="password" type="password" class="form-control" placeholder="Type ...">
							<p><font color=red><?php echo $pesan2; ?></font></p>
						</div>
						<div class="form-group">
							<label>Level</label>
							<select name="level" class="form-control">
								<option value="<?php echo $dqx[level]; ?>"><?php echo $dqx[namalevel]; ?></option>
								<option value="1">Admin</option>
								<option value="2">Pembaca</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
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
	} 
?>