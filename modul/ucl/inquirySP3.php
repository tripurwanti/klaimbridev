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
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
                    $("#table").html("<b>Table disini ya</b>");

                    console.log("responseonya: " + response);
                    if (response == "200") {
                        Swal.fire({
                            title: "Sukses",
                            text: "Booking berhasil. Silahkan lakukan penerbitan PP di ACS",
                            icon: "success",
                            timer: 5000,
                            timerProgressBar: true,
                        })
                        $("#table").html("<b>Table disini ya</b>");
                    } else {
                        window.swal({
                            title: "Error!",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            })
        })
    });
</script>