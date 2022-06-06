<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Monitoring Pengembalian Dana</h3>
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

                <!-- <table id="table_batalklaim" class="table display nowrap" cellspacing="0" width="100%">
                    <thead> -->
                <!-- <th class="check">
                            <input type="checkbox" id="flowcheckall" value="" />&nbsp;All
                        </th> -->
                <!-- </thead>
                </table> -->

                <table border="0" cellspacing="5" cellpadding="5" style="float: right;">
                    <tbody>
                        <tr>
                            <td>Batch Id</td>
                            <td>:</td>
                            <td style="padding-left: 10px;"><input type="text" id="batchidSearch" name="batchidSearch">
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table id="data_batalklaim" class="table display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> <input type="checkbox" id="flowcheckall" value="" />&nbsp; Select All</th>

                            <th>Batch Id Pengembalian Dana</th>
                            <th>Status Batal</th>
                            <th>Status Dana</th>
                            <th>Kantor</th>
                            <th>No Rekening</th>
                            <th>Nama Debitur</th>
                            <th>Cabang Bank</th>
                            <th>Jumlah Net Klaim</th>
                            <th>No. Klaim</th>
                            <th>Tanggal Klaim</th>
                            <th>Ket. Tolak Bank</th>
                            <th>Tgl Kirim Bank</th>
                            <th>Tgl Request Pengembalian</th>
                        </tr>
                    </thead>

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
                <h4 class="modal-title">Konfirmasi Pengembalian Dana</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <p>Mohon upload dokumen pendukung/referensi </p>
                <p>pengembalian dana batal klaim otomatis</p>
                <table class="table">
                    <form action="modul/batalklaim/fetch/prosesPengembalianDana.php" method="POST"
                        enctype="multipart/form-data">
                        <input id='batchid' type="hidden" name="batchid" value="">

                        <!-- <tr>
                            <td>
                                <label style="font-size: 0.8em;"></label>
                            </td>
                            <td>
                            <input id="dokpendukung" type="file" class="form-control" name="dokpendukung"
                                value="dokumen pendukung" required>
                            <span style="color: red; font-size: 13px;" id="msgerrorlkn"></span>
                        </td>
                        </tr> -->
                        <tr>
                            <!-- <td>
                                <label style="font-size: 0.8em;">Tanggal Akhir</label>
                            </td> -->
                            <td>
                                <input id="bukti_dana" type="file" class="form-control" name="bukti_dana"
                                    value="Bukti Pengembalian Dana" onchange="validate_fileupload(this);" required>
                                <span style="color: red; font-size: 13px;" id="msgerrorbktdana"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input style="margin-top: 10px; float: right; " class='btn btn-primary btn-sm'
                                    type="submit" value="Submit" name="submit" id="submitDokPendukung">
                                <!-- <button onclick="myFunction()">Click me</button> -->
                                <!-- <input type="reset" value="Reset" class='btn btn-primary btn-sm'
                                    style="margin-top: 10px; float: right; margin-right: 15px;"> -->
                            </td>
                        </tr>
                    </form>
                </table>
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

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var bacthIdParam = $('#batchidSearch').val();
            var bacthId = data[2]; // use data for the age column
            if (bacthIdParam == '') {
                return true;
            } else if (bacthId.includes(bacthIdParam)) {
                return true;
            } else {
                return false;
            }
            return true;
        }
    );

    // Event listener to the two range filtering inputs to redraw on input
    $('#batchidSearch').keyup(function() {
        $('#data_batalklaim').DataTable().draw();
        $("#flowcheckall").prop('checked', false);
        $('#data_batalklaim tbody input[type="checkbox"]').prop('checked', false);
        var cols = t.column(0).nodes(),
            state = this.checked;

        for (var i = 0; i < cols.length; i += 1) {
            cols[i].querySelector("input[type='checkbox']").checked = state;
        }
    });

    // $('#data_batalklaim tbody input[type="checkbox"]').change(function() {
    //     // $('#data_batalklaim tbody input[type="checkbox"]').prop('checked', this.checked);
    //     // var cols = t.column(0).nodes();
    //     // state = this.checked;
    //     console.log('berhasil');

    //     // for (var i = 0; i < cols.length; i += 1) {
    //     //     cols[i].querySelector("input[type='checkbox']").checked = state;
    //     // }
    // });

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

    // $('#data_batalklaim tfoot th').each(function() {
    //     var title = $(this).text();
    //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    // });

    fetching();

    function fetching() {
        // var rootdir = 'klaimbridevwanti/klaimbridev/';
        $('#loadingMessage').show();
        var url_string = window.location.href
        var url = new URL(url_string);

        $('#data_batalklaim tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // var norek = getUrlParameter('norek');
        // var btnSelectAll = "<th><input type='checkbox' id='flowcheckall' value='' />&nbsp;Select All</th>"
        // $("#table_batalklaim > thead").append(btnSelectAll);
        $.ajax({
            "url": "modul/batalklaim/fetch/fetchMonitoringPengembalianDana.php",
            "type": "POST",
            success: function(html) {
                var o = JSON.parse(html);
                var t = $('#data_batalklaim').DataTable({
                    "scrollX": true,
                    dom: 'Brtip',
                    buttons: [
                        // 'excelHtml5',
                        {
                            text: 'Download',
                            action: function(e, dt, node, config) {
                                window.location.href =
                                    "modul/batalklaim/exportReportMonitoringPengembalianDanaExcel.php";
                            }
                        },
                        {
                            text: 'Update Status Pengembalian Dana',
                            action: function(e, dt, node, config) {
                                var rows = [];

                                $('.checkitem:checked').each(function() {
                                    var row = $(this).parent().parent();

                                    var batchid = {};
                                    $(row).find("td").each(function(i,
                                        obj) {
                                        if (i == 2) {
                                            batchid = $(this)
                                                .text();
                                        }
                                    })

                                    if (jQuery.inArray(batchid, rows) == -
                                        1) {
                                        rows.push(batchid);
                                    };

                                })

                                if (rows.length == 0) {
                                    window.alert(
                                        'Tidak ada data yang dipilih (dicentang)'
                                    );
                                } else {
                                    $('[name="batchid"]').val(JSON.stringify(
                                        rows));
                                    $('#myModal').modal('show');
                                }


                            }
                        }
                    ],
                    "data": o.data,
                    'columnDefs': [{
                        'targets': 1,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center',
                        'render': function(data, type, full, meta) {
                            return '<input type="checkbox" class="checkitem"  id="checkitem' +
                                data + '" value="' +
                                $('<div/>').text(data).html() + '">';
                        }
                    }]
                    // initComplete: function() {
                    //     var officeData = this.api().column(5).data();
                    //     officeData.unique().sort().each(function(d, j) {
                    //         officeSelect = $(
                    //             "<input type='checkbox' id='checkitem" + j +
                    //             "' value='" +
                    //             d +
                    //             "'></input>");

                    //         officeSelect.appendTo($(
                    //                 'table#data_batalklaim tbody td:nth-child(2)'
                    //             )
                    //             .empty());
                    //     });
                    // },
                    // fnDrawCallback: function() {
                    //     $(".checkSingle").change(function(e) {
                    //         console.log('hi');
                    //     });
                    // }

                });
                $('#loadingMessage').hide();
            }
        });

        $("#flowcheckall").click(function() {
            $('#data_batalklaim tbody input[type="checkbox"]').prop('checked', this.checked);
            var cols = t.column(0).nodes();
            state = this.checked;

            for (var i = 0; i < cols.length; i += 1) {
                cols[i].querySelector("input[type='checkbox']").checked = state;
            }
        });

    }

});

$("#data_batalklaim").on('change', "input[type='checkbox']", function(e) {
    var batchid = "";
    var rows = [];
    var row = $(this).parent().parent();
    $(row).find("td").each(function(i,
        obj) {
        if (i == 2) {
            batchid = $(this)
                .text();
        }
    });
    var isChecked = this.checked;
    var cols = $('#data_batalklaim').DataTable().rows().data();
    if (isChecked) {
        for (var i = 0; i < cols.length; i++) {
            if (batchid == cols[i][2]) {
                if (this.value != cols[i][5]) {
                    $('#checkitem' + cols[i][5]).prop('checked', true);
                }

            }
        }
    } else {
        for (var i = 0; i < cols.length; i++) {
            if (batchid == cols[i][2]) {
                if (this.value != cols[i][5]) {
                    $('#checkitem' + cols[i][5]).prop('checked', false);
                }
            }
        }
    }
});

function validate_fileupload(input_element) {

    var allowed_extensions = new Array("pdf");
    allowed_extensions = new Array("pdf", "jpg", "jpeg", "png");
    if (input_element.name == "bukti_dana") {
        el = document.getElementById("msgerrorbktdana");
    }

    var maxfilesize = 10485760; // 10MB
    var fileName = input_element.value;
    var fileSize = input_element.files[0].size;
    var file_extension = fileName.split('.').pop();
    for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
            if (fileSize <= maxfilesize) {
                el.innerHTML = "";
                document.getElementById("submitDokPendukung").disabled = false;
            } else {
                el.innerHTML = "Ukuran file tidak boleh lebih dari 10 MB";
                document.getElementById("submitDokPendukung").disabled = true;
            }

            if (document.getElementById("msgerrorbktdana").innerHTML !== "") {
                document.getElementById("submitDokPendukung").disabled = true;
            }
            return;
        }
        el.innerHTML = "Tipe file " + input_element.name + " harus .pdf/.jpg/.jpeg/.png";
        document.getElementById("submitDokPendukung").disabled = true;
    }
}
</script>