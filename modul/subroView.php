<?php
include ("config/koneksi_askred.php");
?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Daftar Data Pengajuan Subrogasi</h3>

        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <div id="alert_message"/>
                <table id="user_data" class="table display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>F Id Program</th>
                        <th>Nomor Peserta</th>
                        <th>Nomor Rekening</th>
                        <th>Urutan Pengajuan</th>
                        <th>Angsuran Teller Id</th>
                        <th>Angsuran Jurnal Sequence</th>
                        <th>Angsuran Tanggal</th>
                        <th>Angsuran Pokok</th>
                        <th>Angsuran Bunga</th>
                        <th>Angsuran Denda</th>
                        <th>F Id Jenis Subrogasi</th>
                        <th>Jenis Subrogasi</th>
                        <th>Claim Source</th>
                        <th>Tanggal Pengajuan</th>

                        <th style="text-align : center;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $listDataSubro = mssql_query('SELECT * FROM askred_subrogation_validation');
                    $rq = mssql_num_rows($listDataSubro);
                    $no = 1;
                    while($item = mssql_fetch_array($listDataSubro)) {
                        ?>
                        <tr>
                            <td><?php echo $item['f_id_program']; ?></td>
                            <td><?php echo $item['nomor_peserta']; ?></td>
                            <td><?php echo $item['nomor_rekening_pinjaman']; ?></td>
                            <td><?php echo $item['urutan_pengajuan']; ?></td>
                            <td><?php echo $item['angsuran_teller_id']; ?></td>
                            <td><?php echo $item['angsuran_journal_sequence']; ?></td>
                            <td><?php echo $item['angsuran_tanggal']; ?></td>
                            <td><?php echo $item['angsuran_pokok']; ?></td>
                            <td><?php echo $item['angsuran_bunga']; ?></td>
                            <td><?php echo $item['angsuran_denda']; ?></td>
                            <td><?php echo $item['f_id_jenis_subrogasi']; ?></td>
                            <td><?php echo $item['jenis_subrogasi']; ?></td>
                            <td><?php echo $item['claim_source']; ?></td>
                            <td><?php echo $item['created_date']; ?></td>

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

<script type="text/javascript" language="javascript" >
    $(document).ready(function(){

        $('#user_data').DataTable({"scrollX": true});

        $('#myModal').on('show.bs.modal', function (e) {
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
                "ajax" : {
                    url: "modul/fetch.php",
                    method: "POST",
                    data:{ status_klaim:c },
                },
            });
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
        window.open(document.getElementById("cmbDokumen"+strParam).value, '');
    }

    /*$(document).ready(function() {
        $('#example').DataTable();

        $('#myModal').on('show.bs.modal', function (e) {
            var loadurl = $(e.relatedTarget).data('whatever');
            $(this).find('.modal-body').load(loadurl);
        });

    } );*/
</script>