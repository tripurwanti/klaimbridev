<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Laporan Pembatalan Klaim Otomatis</h3>
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
                <h4 class="modal-title">Permintaan Pengembalian Dana</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <!-- <p>Loading...</p> -->
                <table class="table">
                    <form action="modul/batalklaim/exportReportPermintaanPengembalianDanaExcel.php" method="post" onreset="resetHandler();">

                        <td>
                            <label style="font-size: 0.8em;">Tanggal Awal</label>
                        </td>
                        <td>
                            <input id="start_date" type="date" class="form-control" name="start_date" value="start_date" onchange="validate_fileupload(this);" required>
                            <span style="color: red; font-size: 13px;" id="msgerrorstartdate"></span>
                            <tr>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <label style="font-size: 0.8em;">Tanggal Akhir</label>
                            </td>
                            <td>
                                <input id="end_date" type="date" class="form-control" name="end_date" value="end_date" onchange="validate_fileupload(this);" required>
                                <span style="color: red; font-size: 13px;" id="msgerrorenddate"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input style="margin-top: 10px; float: right; " class='btn btn-primary btn-sm' type="submit" value="Download .xls" name="download" id="downloadButton">
                                <input type="reset" value="Reset" class='btn btn-primary btn-sm' style="margin-top: 10px; float: right; margin-right: 15px;">
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    function validate_fileupload(input_element) {
        var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());

        if (startDate > endDate) {
            document.getElementById("msgerrorstartdate").innerHTML = "Tanggal awal tidak boleh melebihi Tanggal Akhir";
            document.getElementById("downloadButton").disabled = true;
        } else {
            document.getElementById("msgerrorstartdate").innerHTML = "";
            document.getElementById("downloadButton").disabled = false;
        }

        
    }

    
        
    function test(noRek, noKlaim, ketTolak){
            alert(ketTolak);
        }


    function resetHandler() {
        document.getElementById("msgerrorstartdate").innerHTML = "";
        document.getElementById("downloadButton").disabled = false;
    }

    $(document).ready(function() {

        $('#myModal').on('show.bs.modal', function(e) {
            var loadurl = $(e.relatedTarget).data('whatever');
            $(this).find('.modal-body').load(loadurl);
        });

        // var getUrlParameter = function getUrlParameter(sParam) {
        //     var sPageURL = window.location.search.substring(1),
        //         sURLVariables = sPageURL.split('&'),
        //         sParameterName,
        //         i;

        //     for (i = 0; i < sURLVariables.length; i++) {
        //         sParameterName = sURLVariables[i].split('=');

        //         if (sParameterName[0] === sParam) {
        //             return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[
        //                 1]);
        //         }
        //     }
        //     return false;
        // };

        fetching();

        function fetching() {
            $('#loadingMessage').show();
            var url_string = window.location.href
            var url = new URL(url_string);
            // var norek = getUrlParameter('norek');

            $.ajax({
                "url": "modul/batalklaim/fetch/fetchListBatalKlaim.php",
                "type": "POST",
                success: function(html) {
                    var o = JSON.parse(html);
                    var t = $('#user_data').DataTable({
                        "scrollX": true,
                        dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5',
                            <?php 
                            if($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'ask.klaim'){;
                            ?>
                            {
                                text: 'Download Permintaan Pengembalian Dana',
                                action: function(e, dt, node, config) {
                                    $('#myModal').modal('show');
                                }
                            }
                            <?php
                            }?>
                            
                        ],
                        "columns": o.columns,
                        "data": o.data
                    });
                    $('#loadingMessage').hide();
                }
            });
        }

        // function update_data(id, column_name, value) {
        //     $.ajax({
        //         url: "update.php",
        //         method: "POST",
        //         data: {
        //             id: id,
        //             column_name: column_name,
        //             value: value
        //         },
        //         success: function(data) {
        //             $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
        //             $('#user_data').DataTable().destroy();
        //             fetch_data();
        //         }
        //     });
        //     setInterval(function() {
        //         $('#alert_message').html('');
        //     }, 5000);
        // }

        // $(document).on('blur', '.update', function() {
        //     var id = $(this).data("id");
        //     var column_name = $(this).data("column");
        //     var value = $(this).text();
        //     update_data(id, column_name, value);
        // });

        $("#kirimUlang").click(function(){
            alert("oke");
        })
        $(document).ready(function() {
            $('[data-toggle="tooltipResend"]').tooltip();
            $('[data-toggle="tooltipDownload"]').tooltip();
        });


    });
</script>