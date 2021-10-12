<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Daftar RC Klaim</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">

                <b>
                    <h4><?php //echo $_GET[title]; 
                        ?></h4>
                </b>
                <span id="loadingMessage" style="display:none">
                    <center><b>Loading ... </b><br /><img src='images/loading.gif' width="60px"></center>
                </span>
                <!--<div id="alert_message"/>-->
                <table id="user_data" class="table display nowrap" cellspacing="0" width="100%">

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

    $('#myModal').on('show.bs.modal', function(e) {
        var loadurl = $(e.relatedTarget).data('whatever');
        $(this).find('.modal-body').load(loadurl);
    });

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[
                    1]);
            }
        }
        return false;
    };

    fetching();

    function fetching() {
        $('#loadingMessage').show();
        var url_string = window.location.href
        var url = new URL(url_string);
        var norek = getUrlParameter('norek');

        $.ajax({
            "url": "modul/pengajuanclaim/fetch/FetchRCClaimConfirmation.php?norek=" + norek,
            "type": "POST",
            success: function(html) {
                var o = JSON.parse(html);
                var t = $('#user_data').DataTable({
                    "scrollX": true,
                    //"scrollY": 500,
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5'
                    ],
                    "columns": o.columns,
                    "data": o.data
                });
                $('#loadingMessage').hide();
            }
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