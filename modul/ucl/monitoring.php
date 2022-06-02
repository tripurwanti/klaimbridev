<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<?php
error_reporting(1);
?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Monitoring Bank Garansi</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <div class="row">
                    <form method="post" id="form">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="status">Status</label><br>
                                <select class="form-control" id="status">
                                    <option disabled selected>Pilih Salah satu</option>
                                    <option value="1">Booking UCL Sukses</option>
                                    <option value="2">Booking UCL Gagal</option>
                                    <option value="3">Proses Covering</option>
                                    <option value="4">Premi Lunas</option>
                                    <option value="5">Terbit PP</option>
                                    <option value="6">Terbit BG</option>
                                    <option value="7">Terbit Polis</option>
                                    <option value="8">Dalursa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jenisBG">Jenis Bank Garansi</label><br>
                                <select class="form-control" id="jenisBG">
                                    <option disabled selected>Pilih Salah satu</option>
                                    <option value="KBG - Jaminan Pelaksanaan">KBG - Jaminan Pelaksanaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="noSP3">Nomor SP3</label><br>
                                <input type="name" name="noSP3" class="form-control" id="noSP3" placeholder="Nomor SP3">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="global">Pencarian Global</label><br>
                                <input type="name" name="global" class="form-control" id="global" placeholder="Pencarian Global">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <br>
                                <a href="#" id="reset" name="reset" style="width:48%;" class="btn btn-primary">Reset</a>
                                <a href="#" name="submit" id="submit" style="width:48%;" class="btn btn-primary">Submit</a>
                            </div>
                        </div>
                        <div class="col-lg-2">
                        </div>
                    </form>
                </div>
            </div>

            <div id="modalinsert"></div>


            <div class="container">
                <!-- The Modal -->
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Modal Heading</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>No SP3</label>
                                    </div>
                                    <div class="col-md-8">
                                        <label id="noPp" placeholder="Nomor SP3"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p id="description" style="text-align: center; border: 1px solid #767474; padding: 5px 0px"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Booking UCL</p>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="#" style="width:40%" class="btn btn-primary" id="bookingUCL">Booking</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Download PP/SP3</p>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="#" style="width:40%" class="btn btn-primary" id="downloadPP">Download</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Download BG</p>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="#" style="width:40%" class="btn btn-primary" id="downloadBG">Download</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Download Polis</p>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="#" style="width:40%" class="btn btn-primary" id="downloadPolis">Download</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Cancel Booking UCL</p>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="#" style="width:40%" class="btn btn-danger" id="cancelBooking">Cancel</a>
                                    </div>
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>No PP</th>
                            <th>Nomor Perjanjian</th>
                            <th>Nama Proyek</th>
                            <th>Jenis Bank Garansi</th>
                            <th>Nama Principal</th>
                            <th>Alamat Principal</th>
                            <th>Nama Obligee</th>
                            <th>Alamat Obligee</th>
                            <th>Mata Uang</th>
                            <th>Nilai Proyek</th>
                            <th>Nilai Penjaminan</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th>Download PP / SP3</th>
                            <th>Booking UCL</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                    </tbody>
                </table>
            </div>
            <div id="table"></div>
        </div>
    </div>
</div>
<script>
    function bookingUCL(noPP) {
        $("#submit").click(function() {
            window.swal({
                title: "Checking...",
                text: "Please wait",
                showConfirmButton: false,
                allowOutsideClick: false,
            });
            $.ajax({
                url: "modul/ucl/controller/bookingUCL.php",
                type: "POST",
                noPP: noPP,
                success: function(response) {
                    Swal.close();
                    var resp = JSON.parse(response);
                }
            })
        });
    }
    $(document).ready(function() {

        $("#reset").click(function() {
            $("#status").prop('selectedIndex', 0);
            $("#jenisBG").prop('selectedIndex', 0);
            $("#noSP3").val("");
            $("#global").val("");
        })

        $("#submit").click(function() {
            var status = $("#status").val();
            var noSP3 = $("#noSP3").val();
            var jenisBG = $("#jenisBG").val();
            var global = $("#global").val();
            var val = {
                status: status,
                noSP3: noSP3,
                jenisBG: jenisBG,
                global: global
            };
            window.swal({
                title: "Checking...",
                text: "Please wait",
                showConfirmButton: false,
                allowOutsideClick: false,
            });
            $.ajax({
                url: "modul/ucl/controller/monitoring.php",
                type: "POST",
                data: val,
                success: function(response) {
                    Swal.close();
                    var resp = JSON.parse(response);
                    var no = 1;
                    for (var data of resp['content']) {
                        var text = data['noPp'];
                        var id = text.replace(/\//g, "");
                        $("#table-content").html(
                            "<input type='hidden' value='" + data['status'] + "' id='status_" + id + "'></input>" +
                            "<tr>" +
                            "<td>" + no + "</td>" +
                            "<td>" + convertStatus(data['status']) + "</td>" +
                            "<td><button type='button' href='#' class='btn btn-primary edit' value='" + data['noPp'] + "'>Detail</button></td>" +
                            "<td>" + data['noPp'] + "</td>" +
                            "<td>" + data['nomorPerjanjian'] + "</td>" +
                            "<td>" + data['namaProyek'] + "</td>" +
                            "<td>" + data['jenisBg'] + "</td>" +
                            "<td>" + data['namaPrincipal'] + "</td>" +
                            "<td>" + data['alamatPrincipal'] + "</td>" +
                            "<td>" + data['namaObligee'] + "</td>" +
                            "<td>" + data['alamatObligee'] + "</td>" +
                            "<td>" + data['currency'] + "</td>" +
                            "<td>" + data['nilaiProyek'] + "</td>" +
                            "<td>" + data['nilaiPenjaminan'] + "</td>" +
                            "<td>" + data['tanggalAwal'] + "</td>" +
                            "<td>" + data['tanggalAkhir'] + "</td>" +
                            "<td><a href='#' class='btn btn-primary'>Download</a></td>" +
                            "<td><a href='#' id='buttonBookingUCL' onclick=bookingUCL('" + data['noPp'] + "') class='btn btn-success'>Booking UCL</a></td>" +
                            "</tr>");
                        if (data['status'] == 1) {
                            $('#buttonBookingUCL').attr('disabled', 'disabled');
                        }
                    }


                }
            })
        });

        $(document).on('click', '.edit', function() {
            var noPp = $(this).val();
            var text = noPp;
            var id = text.replace(/\//g, "");
            var status = document.getElementById('status_' + id).value;
            $('#edit').modal('show');
            $("#noPp").text(noPp);
            var description = "";
            if (status == 1) {
                disableButton([1, 3, 4, 5]);
                $("#description").text("Booking berhasil. Silahkan lakukan penerbitan PP di ACS");
            } else if (status == 2) {
                disableButton([1, 3, 4, 5]);
                $("#description").text("Booking gagal. Silahkan lakukan pembatalan PP di ACS");
            } else if (status == 7) {
                disableButton([1, 3, 4, 5]);
                $("#description").text("SP3 ini sedang dalam proses pengajuan polis");
            } else if (status == 6) {
                disableButton([1, 3, 4]);
                $("#description").text("SP3 ini sedang dalam masa daluarsa");
            } else if (status == 4) {
                disableButton([1, 3, 4, 5]);
                $("#description").text("PP / SP3 berhasil terbit");
            } else if (status == 8) {
                disableButton([1, 4, 5]);
                $("#description").text("BG berhasil diproses. Silahkan lakukan realisasi PP dan terbit Polis di ACS");
            } else if (status == 9) {
                disableButton([1,5]);
                $("#description").text("Berhasil terbit polis");
            } else if (status == 10) {
                disableButton([1, 4, 5]);
                $("#description").text("BG berhasil diproses. Silahkan lakukan realisasi PP dan terbit Polis di ACS");
            }
        });

        function disableButton(statusArray) {
            for (const status of statusArray) {
                if (status == 1) {
                    $("#bookingUCL").attr('disabled', 'disabled');
                }
                if (status == 2) {
                    $("#downloadPP").attr('disabled', 'disabled');
                }
                if (status == 3) {
                    $("#downloadBG").attr('disabled', 'disabled');
                }
                if (status == 4) {
                    $("#downloadPolis").attr('disabled', 'disabled');
                }
                if (status == 5) {
                    $("#cancelBooking").attr('disabled', 'disabled');
                }
            }
        }

        function convertStatus(status) {
            switch (status) {
                case 0:
                    return "Data Tersedia";
                    break;
                case 1:
                    return "Booking UCL Sukses";
                    break;
                default:
                    return "Tidak terdaftar";
                    break;
            }
        }

        function convertTanggal(date) {
            // split(date)
        }
    });
</script>