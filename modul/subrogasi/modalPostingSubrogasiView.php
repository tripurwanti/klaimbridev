<!-- <form action="modul/subrogasi/postingProcess.php?id=<?php echo $_GET['fileId']; ?>" method="post" id="form"> -->
<form method="post" id="form">
    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Subrogasi</label>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Collecting Fee</label>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No BD</label>
        <input type="text" class="form-control" name="no_bd" id="no_bd_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No BK</label>
        <input type="text" class="form-control" name="no_bk" id="no_bk_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No MM</label>
        <input type="text" class="form-control" name="no_mm_subrogasi"
            id="no_mm_subrogasi_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">No MM</label>
        <input type="text" class="form-control" name="no_mm_collecting_fee"
            id="no_mm_collecting_fee_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal BD</label>
        <input type="date" class="form-control" name="tgl_bd" id="tgl_bd_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal BK</label>
        <input type="date" class="form-control" name="tgl_bk" id="tgl_bk_<?php echo $_GET['fileId']; ?>" required>
    </div>

    <br>
    <br>
    <div style="margin-left : 15px">
        <!-- <input type="submit" class="btn btn-success btn-sm" value="Posting" id="posting"> -->
        <a href="#" type="submit" class="btn btn-success btn-sm" onclick="posting('<?php echo $_GET['fileId']; ?>')"
            id="posting">Posting</a>
    </div>
</form>

<script type="text/javascript" language="javascript">
function posting(id) {
    var no_bd = $("#no_bd_" + id).val();
    var no_bk = $("#no_bk_" + id).val();
    var tgl_bk = $("#tgl_bk_" + id).val();
    var tgl_bd = $("#tgl_bd_" + id).val();
    var no_mm_subrogasi = $("#no_mm_subrogasi_" + id).val();
    var no_mm_collecting_fee = $("#no_mm_collecting_fee_" + id).val();
    console.log("tgl bk" + tgl_bk)
    console.log("tgl bd" + tgl_bd)


    if (no_bd == '' || no_bk == '' || tgl_bk == '' || tgl_bd == '' || no_mm_subrogasi == '' || no_mm_collecting_fee ==
        '') {
        alert("Form tidak boleh kosong");
    } else {
        $("#loading").show();
        $.ajax({
            method: "POST",
            url: "modul/subrogasi/postingProcess.php?id=" + id,
            data: {
                no_bd: no_bd,
                no_bk: no_bk,
                no_mm_subrogasi: no_mm_subrogasi,
                no_mm_collecting_fee: no_mm_collecting_fee,
                tgl_bd: tgl_bd,
                tgl_bk: tgl_bk
            },
            success: function(data) {
                // console.log(this.data);
                $("#loading").hide();
                alert("Proses Posting sedang berjalan, report akan siap di download ketika status POSTED");
                window.location.href =
                    'http://10.10.1.247:81/klaimbridev/media.php?module=listRCReconSubrogasi';
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