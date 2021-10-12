<div id="page-wrapper">
	<div class="main-page">
		<h3 class="title1">Selamat Datang, <?php echo $_SESSION[namauser]; ?></h3>
		<div class="blank-page widget-shadow scroll" id="style-2 div1">
			<p>
				<b>Anda berada di halaman Periksa Dokumen Klaim BRI.</b><br/>
				<small>Silahkan Periksa Dokumen yang sudah dikirim oleh BNI untuk ditindaklanjuti.</small>
			</p><br/>
			<div class="row-one">
			<a href="media.php?module=klaim&q=all&title=Seluruh Data" title="Seluruh Data">
			<div class="col-md-2">
				<div class="wid-social pengajuan5">
					<div class="social-icon">
						<i class="fa fa-table text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq4['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Seluruh Data</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<a href="media.php?module=klaim&q=0&title=Belum Diverifikasi" title="Belum Diverifikasi">
			<div class="col-md-2 states-mdl">
				<div class="wid-social pengajuan4">
					<div class="social-icon">
						<i class="fa fa-edit text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq1['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Belum Diverifikasi</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<a href="media.php?module=klaim&q=4&title=Data Lengkap" title="Data Lengkap">
			<div class="col-md-2 states-last">
				<div class="wid-social pengajuan1">
					<div class="social-icon">
						<i class="fa fa-check text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq2['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Data Lengkap</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<a href="media.php?module=klaim&q=3&title=Tidak Lengkap" title="Tidak Lengkap">
			<div class="col-md-2 states-last">
				<div class="wid-social pengajuan6">
					<div class="social-icon">
						<i class="fa fa-frown-o text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq3['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Tidak Lengkap</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<a href="media.php?module=klaim&q=2&title=Data Disetujui" title="Data Disetujui">
			<div class="col-md-2 states-last">
				<div class="wid-social pengajuan3">
					<div class="social-icon">
						<i class="fa fa-thumbs-up text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq5['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Data Disetujui</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<a href="media.php?module=klaim&q=1&title=Data Ditolak" title="Data Ditolak">
			<div class="col-md-2 states-last">
				<div class="wid-social pengajuan2">
					<div class="social-icon">
						<i class="fa fa-thumbs-down text-light icon-xlg"></i>
					</div>
					<div class="social-info">
						<h3 class="number_counter bold count text-light start_timer counted"><?php echo $naq6['banyak_data']; ?></h3>
						<h4 class="counttype text-light">Data Ditolak</h4>
					</div>
				</div>
				<div class="clearfix"> </div>	
			</div>
			</a>
			<div class="clearfix"> </div>	
		</div>
		<hr/>
		<p>
			<b style="color: red">
			Pastikan Download dan Periksa Dokumen terlebih dahulu sebelum Anda melakukan Checklist<br/></b>
			Dokumen yang dikirim oleh BRI berjumlah 8 Dokumen;<br/>
			<small>
			<b>Berita Acara Klaim</b> >> [01, 08, 09, 010, 011]<br/>
			<b>Rek. Debitur (6 Bulan Terakhir)</b> >> [02, 012, 013, 014, 015]<br/>
			<b>Loan Inquiry (Kolek)</b> >> [03]<br/>
			<b>Surat Penagihan / LKN</b> >> [04, 016, 017, 018, 019, 020]<br/>
			<b>Identitas / Legalitas Debitur</b> >> [05, 021, 022]<br/>
			<b>Surat Pengakuan Hutang</b> >> [06, 023, 024, 025, 026, 027, 028, 029, 030, 031, 032, 033, 034, 035, 036]<br/>
			<b>SID BI saat pengajuan</b> >> [07, 037, 038, 039, 040, 041, 042, 043, 044, 045]<br>
			<b>Payoff</b> >> [046]
			<small>
		</p>
		</div>
	</div>
</div>