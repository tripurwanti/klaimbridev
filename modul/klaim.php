<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Pengajuan Klaim</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <?php
				if ($_GET['q'] == 'all') {
					$kondisi = "";
				} else {
					$kondisi = "AND a.status_klaim = '$_GET[q]'";
				}
				$q = mssql_query("SELECT TOP 50 a.*, b.nama_debitur FROM pengajuan_klaim_kur_gen2 a, sp2_kur2015 b WHERE a.no_rekening = b.no_rekening AND substring(a.no_sertifikat, 4, 2) = '$_SESSION[id_kantor]' $kondisi ORDER BY a.tgl_kirim DESC");
				$rq = mssql_num_rows($q);
				?>
                <h4><?php echo $_GET[title] . " <small>(Menampilkan " . $rq . " Data dari Total Data)<br/>" . $subtrange . "</small>"; ?>
                </h4>
                <div id="alert_message" />
                <table id="user_data" class="table display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php
							if ($_GET['q'] != 'all') {
								echo "<th></th>";
							}
							?>
                            <th>No. Rekening</th>
                            <th>Nama Debitur</th>
                            <th>No. Sertifikat</th>
                            <th>Jml Baki Debet</th>
                            <th>Jml Tuntutan</th>
                            <th>No. STGR</th>
                            <th>Tgl STGR</th>
                            <th>Ket</th>
                            <th>Tgl Kirim</th>
                            <th>Nilai Pengikatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$no = 1;
						while ($dq = mssql_fetch_array($q)) {
						?>
                        <tr>
                            <th scope="row">
                                <?php echo $no; ?>
                            </th>
                            <?php
								if ($_GET['q'] != 'all') {
								?>
                            <td>
                                <button alt="Lihat Dokumen" type="button" class="btn btn-success btn-small"
                                    data-toggle="modal" data-target="#myModal"
                                    data-whatever="modul/modal_preview.php?q=<?php echo $_GET[q]; ?>&no_fasilitas=<?php echo $dq[no_rekening]; ?>&plafond=<?php echo $dq[jml_baki_debet]; ?>&tgl_mulai=<?php echo $dq[tgl_mulai]; ?>"><i
                                        class="fa fa-search"></i> </button>
                            </td>
                            <?php
								}
								?>
                            <td><?php echo $dq['no_rekening']; ?></td>
                            <td><?php echo strtoupper($dq['nama_debitur']); ?></td>
                            <td><?php echo $dq['no_sertifikat']; ?></td>
                            <td align="right"><?php echo number_format($dq['jml_baki_debet'], 2, ",", "."); ?></td>
                            <td align="right"><?php echo number_format($dq['jml_tuntutan'], 2, ",", "."); ?></td>
                            <td><?php echo $dq['no_stgr']; ?></td>
                            <td><?php echo $dq['tgl_stgr']; ?></td>
                            <td><?php echo $dq['ket_penyebab_klaim']; ?></td>
                            <td><?php echo $dq['tgl_kirim']; ?></td>
                            <td><?php echo number_format($dq['nilai_pengikatan'], 2, ",", "."); ?></td>
                        </tr>
                        <?php
							$no++;
						}
						?>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="myModal" class="modal fade">
    <div class="modal-dialog " style="overflow-y: initial !important">
        <!-- width: 75% -->
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

<script type="text/javascript" language="javascript">
$(document).ready(function() {

    $('#user_data').DataTable({
        "scrollX": true
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var loadurl = $(e.relatedTarget).data('whatever');
        $(this).find('.modal-body').load(loadurl);
    });

    //fetch_data();

    function fetch_data() {
        var url_string = window.location.href
        var url = new URL(url_string);
        var c = url.searchParams.get("q");


        var dataTable = $('#user_data').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "bSearchable": true,
            "scrollX": true,
            "ajax": {
                url: "modul/fetch.php",
                method: "POST",
                data: {
                    status_klaim: c
                },
            },
        });
    }

    function update_data(id, column_name, value) {
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {
                id: id,
                column_name: column_name,
                value: value
            },
            success: function(data) {
                $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                $('#user_data').DataTable().destroy();
                fetch_data();
            }
        });
        setInterval(function() {
            $('#alert_message').html('');
        }, 5000);
    }

    $(document).on('blur', '.update', function() {
        var id = $(this).data("id");
        var column_name = $(this).data("column");
        var value = $(this).text();
        update_data(id, column_name, value);
    });


});

function downloadFile(strParam) {
    window.open(document.getElementById("cmbDokumen" + strParam).value, '');
}

/*$(document).ready(function() {
	$('#example').DataTable();
	
	$('#myModal').on('show.bs.modal', function (e) {
		var loadurl = $(e.relatedTarget).data('whatever');
		$(this).find('.modal-body').load(loadurl);
	});
	
} );*/
</script>