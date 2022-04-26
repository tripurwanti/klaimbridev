<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<?php
error_reporting(1);
?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Inquiry Data SP3 ke ACS</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <div class="row">
                    <form method="post" id="form">
                        <div class="col-md-2" style="width: 200px !important;">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Silahkan Input Nomor PP</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="name" name="noPP" class="form-control" id="noPP" placeholder="Nomor PP" aria-describedby="Nomor PP">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" name="submit" style="width:15%;" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No PP</th>
                            <th>Nomor Perjanjian</th>
                            <th>Nama Proyek</th>
                            <th>Jenis BG</th>
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
                            <th>Action</th>
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
        window.swal({
            title: "Checking...",
            text: "Please wait",
            showConfirmButton: false,
            allowOutsideClick: false
        });
        $.ajax({
            url: "modul/ucl/controller/bookingUCL.php",
            type: "POST",
            data: {
                noPP: noPP
            },
            success: function(response) {
                var resp = JSON.parse(response);
                console.log("respnya: ", resp);
                if (resp['code'] == "200") {
                    Swal.fire({
                        title: "Sukses",
                        text: "Booking berhasil. Silahkan lakukan penerbitan PP di ACS",
                        icon: "success",
                        timer: 5000,
                        timerProgressBar: true,
                    })
                } else if (resp['code'] == "409") {
                    window.swal({
                        title: resp['response'],
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    window.swal({
                        title: "Data tidak ditemukan!",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        })
    }
</script>
<script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            e.preventDefault();
            var noPP = $("#noPP").val();
            window.swal({
                title: "Checking...",
                text: "Please wait",
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: "modul/ucl/controller/inquiry.php",
                type: "POST",
                data: {
                    noPP: noPP
                },
                success: function(response) {
                    var resp = JSON.parse(response);
                    if (resp['code'] == "200") {
                        Swal.close();
                        // Swal.fire({
                        //     title: "Sukses",
                        //     text: "Booking berhasil. Silahkan lakukan penerbitan PP di ACS",
                        //     icon: "success",
                        //     timer: 5000,
                        //     timerProgressBar: true,
                        // })
                        console.log(resp);
                        $("#table-content").html("<tr>" +
                            "<td>" + resp['response']['noPP'] + "</td>" +
                            "<td>" + resp['response']['noPerjanjian'] + "</td>" +
                            "<td>" + resp['response']['namaProyek'] + "</td>" +
                            "<td>" + resp['response']['jenisBg'] + "</td>" +
                            "<td>" + resp['response']['namaPrincipal'] + "</td>" +
                            "<td>" + resp['response']['alamatPrincipal'] + "</td>" +
                            "<td>" + resp['response']['namaObligee'] + "</td>" +
                            "<td>" + resp['response']['alamatObligee'] + "</td>" +
                            "<td>" + resp['response']['mataUang'] + "</td>" +
                            "<td>" + resp['response']['nilaiProyek'] + "</td>" +
                            "<td>" + resp['response']['nilaiPenjaminan'] + "</td>" +
                            "<td>" + resp['response']['tglAwal'] + "</td>" +
                            "<td>" + resp['response']['endDate'] + "</td>" +
                            "<td><a href='#' class='btn btn-primary'>Download</a></td>" +
                            "<td><a href='#' onclick=bookingUCL('" + resp['response']['noPP'] + "') class='btn btn-success'>Booking UCL</a></td>" +
                            "</tr>");
                    } else {
                        window.swal({
                            title: "Data tidak ditemukan!",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            })
        })
    });
</script>