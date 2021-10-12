<?php
// $fileName = $_GET['fileName'];
$fileId = $_GET['fileId'];
$isLoading = FALSE;
?>

<!-- <form action="config/baca_file.php?id=<?php echo $fileId; ?>" method="post" id="form"> -->
<form method="post" id="form">
    <div class=col-sm-8 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No BK</label>
        <input type="text" class="form-control" name="no_bk" id="no_bk_<?php echo $fileId; ?>" required>
    </div>
    <div class=col-sm-4 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal BK</label>
        <input type="date" class="form-control" name="tgl_bk" id="tgl_bk_<?php echo $fileId; ?>" required>
    </div>

    <div class=col-sm-8 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No MM</label>
        <input type="text" class="form-control" name="no_mm" id="no_mm_<?php echo $fileId; ?>" required>
    </div>
    <div class=col-sm-4 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal MM</label>
        <input type="date" class="form-control" name="tgl_mm" id="tgl_mm_<?php echo $fileId; ?>" required>
    </div>

    <br>
    <div style="margin-left : 15px">
        <!-- <input type="submit" class="btn btn-success btn-sm" value="Posting" id="posting"> -->
        <a href="#" type="submit" class="btn btn-success btn-sm" onclick="posting('<?php echo $_GET['fileId']; ?>')"
            id="posting">Posting</a>
    </div>
</form>

<!-- ====================== loading ==================================== -->

<div id="loading" class="modal">
    <!-- <div class="modal-dialog " style="overflow-y: initial !important">
    <div class="modal-content"> -->
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
<!-- ====================== loading ==================================== -->

<script type="text/javascript" language="javascript">
function posting(id) {
    var no_bk = $("#no_bk_" + id).val();
    var tgl_bk = $("#tgl_bk_" + id).val();
    var no_mm = $("#no_mm_" + id).val();
    var tgl_mm = $("#tgl_mm_" + id).val();

    if (no_bk == '' || tgl_bk == '' || no_mm == '' || tgl_mm == '') {
        alert("Form tidak boleh kosong");
    } else {
        $("#loading").show();
        $.ajax({
            method: "POST",
            // url: "modul/scheduler/matchingProcessPelunasanKlaim.php?id=" + id,
            url: "config/baca_file.php?id=" + id,
            data: {
                no_bk: no_bk,
                no_mm: no_mm,
                tgl_mm: tgl_mm,
                tgl_bk: tgl_bk
            },
            success: function(data) {
                // console.log(this.data);
                $("#loading").hide();
                alert("File berhasil di posting");
                window.location.href = 'http://10.10.1.247:81/klaimbridev/media.php?module=listData';
            },
            error: function(error) {
                alert(error);
            }
        })
    }
}

$(document).ready(function() {


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

});

function downloadFile(strParam) {
    window.open(document.getElementById("cmbDokumen" + strParam).value, '');
}
</script>