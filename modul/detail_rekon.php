<?php
$fileId = $_REQUEST['id'];; ?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Detail Rekon</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <?php
                if ($_GET['q'] == 'all') {
                    $kondisi = "";
                } else {
                    $kondisi = "AND a.status_klaim = '$_GET[q]'";
                }

                $q = mssql_query("SELECT * FROM mapping_rc_bri WHERE id = $fileId");
                $rq = mssql_num_rows($q);
                ?>
                <h4><?php echo $_GET[title] . " <small>(Menampilkan " . $rq . " Data dari Total Data)<br/>" . $subtrange . "</small>"; ?>
                </h4>
                <div id="alert_message" />

                <div style="margin-bottom : 10px;">
                    <a href="excel/export_excel.php?id=<?php echo $fileId; ?>" class="btn btn-success btn-sm">Export To
                        Excel</a>
                    <br>
                </div>

                <table id="user_data" class="table display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <!-- <?php
                                    if ($_GET['q'] != 'all') {
                                        echo "<th></th>";
                                    }
                                    ?> -->
                            <th>Id</th>
                            <th>Tanggal Posting</th>
                            <th>No Rekening</th>
                            <th>Nominal Klaim</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>No BK</th>
                            <th>No MM</th>
                            <th>Tanggal BK</th>
                            <th>Tanggal MM</th>
                            <th>Kantor Cabang</th>
                            <th>No CL</th>
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
                                <td><?php echo $dq['id']; ?></td>
                                <td><?php echo $dq['mapping_date']; ?></td>
                                <td><?php echo $dq['no_rekening']; ?></td>
                                <td><?php echo $dq['nominal_klaim']; ?></td>
                                <td><?php echo $dq['status']; ?></td>
                                <td><?php echo $dq['detail']; ?></td>
                                <td><?php echo $dq['noBk']; ?></td>
                                <td><?php echo $dq['noMm']; ?></td>
                                <td><?php echo $dq['tgl_bk']; ?></td>
                                <td><?php echo $dq['tgl_mm']; ?></td>
                                <td><?php echo $dq['cabang']; ?></td>
                                <td><?php echo $dq['no_cl']; ?></td>
                            </tr>

                            <!-- ======================= modal ===================================== -->
                            <div id="myModal<?php echo $dq['id']; ?>" class="modal fade">
                                <div class="modal-dialog " style="overflow-y: initial !important">
                                    <!-- width: 75% -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Masukkan No. BK dan No. MM</h4>
                                        </div>
                                        <div class="modal-body" style="overflow-y: auto;">
                                            <form action="config/baca_file.php?file=<?php echo $fileName; ?>&id=<?php echo $fileId; ?>" method="post">
                                                <input type="text" class="user" name="no_bk" placeholder="No BK" required="">
                                                <input type="text" class="user" name="no_mm" placeholder="No MM" required="">
                                                <input type="submit" class="btn btn-success btn-sm" value="Rekon">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ======================= modal ===================================== -->

                        <?php
                            $no++;
                        }
                        ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="loading" class="modal">
	<!-- <div class="modal-dialog " style="overflow-y: initial !important"> -->
		<!-- <div class="modal-content"> -->
		<div class="loader" style="
							border: 16px solid #f3f3f3; /* Light grey */
							border-top: 16px solid #3498db; /* Blue */
							border-radius: 50%;
							width: 120px;
							height: 120px;
							animation: spin 2s linear infinite;
							margin-left : 50%;
							margin-top : 20%;								

							@keyframes spin {
							0% { transform: rotate(0deg); }
							100% { transform: rotate(360deg); }
							}"></div>
		</div>
	</div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('#user_data').DataTable({
            "scrollX": true
        });

        // $('#myModal').on('show.bs.modal', function(e) {
        //     var loadurl = $(e.relatedTarget).data('whatever');
        //     $(this).find('.modal-body').load(loadurl);
        // });

        //fetch_data();

        function fetch_data() {
            $('#loading').show();
            var url_string = window.location.href
            var url = new URL(url_string);
            var c = url.searchParams.get("q");


            var dataTable = $('#user_data').DataTable({
                "bServerSide": true,
                "bProcessing": true,
                "bSearchable": true,
                "scrollX": true,
                "ajax": {
                    url: "modul/fetch_detail_rekon.php",
                    method: "POST",
                    data: {
                        "id": c
                    },
                },
            });
            $('#loading').hide();
        }

        // function update_data(id, column_name, value) {
        // 	$.ajax({
        // 		url:"update.php",
        // 		method:"POST",
        // 		data:{id:id, column_name:column_name, value:value},
        // 		success:function(data) {
        // 			$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
        // 			$('#user_data').DataTable().destroy();
        // 			fetch_data();
        // 		}
        // 	});
        // 	setInterval(function(){
        // 		$('#alert_message').html('');
        // 	}, 5000);
        // }

        // $(document).on('blur', '.update', function() {
        // 	var id = $(this).data("id");
        // 	var column_name = $(this).data("column");
        // 	var value = $(this).text();
        // 	update_data(id, column_name, value);
        // });


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