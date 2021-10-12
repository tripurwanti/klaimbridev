<form action="modul/subrogasi/report/export_report_posting_subrogasi.php?id=<?php echo $_GET['fileId']; ?>"
    method="post" id="form">
    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal Awal</label>
        <input type="date" class="form-control" name="startdate" id="startdate" required>
    </div>

    <div class=col-sm-6 style="margin-bottom : 3px">
        <label for="example-search-input" class="col-form-label">Tanggal Akhir</label>
        <input type="date" class="form-control" name="enddate" id="enddate" required>
    </div>

    <br>
    <br>
    <div style="margin-left : 15px">
        <input type="submit" class="btn btn-success btn-sm" value="Download" id="download_btn">
    </div>
</form>

<!-- ====================== loading ==================================== -->


<script type="text/javascript" language="javascript">
$('#download_btn').click(function() {
    if (!$('form input:invalid').length) {
        setTimeout(function() {
            $('#myModal').modal('hide');
        }, 1000);
    }
});
</script>