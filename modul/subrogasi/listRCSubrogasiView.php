<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Daftar RC Subrogasi</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">

                <span id="loadingMessage" style="display:none">
                    <center><b>Loading ... </b><br /><img src='images/loading.gif' width="60px"></center>
                </span>
                <table id="user_data" class="table display nowrap" cellspacing="0" width="100%">

                </table>
            </div>
        </div>
    </div>
</div>

<div id="myModalPosting" class="modal fade">
    <div class="modal-dialog " style="overflow-y: initial !important">
        <!-- width: 75% -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Posting</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
$(document).ready(function() {

    $('#myModalPosting').on('show.bs.modal', function(e) {
        var loadurl = $(e.relatedTarget).data('whatever');
        $(this).find('.modal-body').load(loadurl);
    });

    fetching();

    function fetching() {
        $('#loadingMessage').show();
        var url_string = window.location.href
        var url = new URL(url_string);

        $.ajax({
            "url": "modul/subrogasi/fetch/FetchListRCSubrogasi.php",
            "type": "POST",
            success: function(html) {
                var o = JSON.parse(html);
                var t = $('#user_data').DataTable({
                    "scrollX": true,
                    dom: 'Bfrtip',
                    buttons: [
                        //     {
                        //     extend: 'excelHtml5',
                        //     text: 'Export to Excel'
                        // }
                    ],
                    "columns": o.columns,
                    "data": o.data
                });
                $('#loadingMessage').hide();
            }
        });
    }

    $(document).on('blur', '.update', function() {
        var id = $(this).data("id");
        var column_name = $(this).data("column");
        var value = $(this).text();
        update_data(id, column_name, value);
    });

    function confirm_click() {
        return confirm("Are you sure ?");
    }

});

function downloadFile(strParam) {
    window.open(document.getElementById("cmbDokumen" + strParam).value, '');
}
</script>