<?php
error_reporting(1);
include("config/koneksi_askred.php");
$idDataRC = $_REQUEST['idDataRC'];
// include "modul/subrogasi/upload_rc.php";
?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Perbarui Tanggal Koreksi</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <div class="container">
                    <div class="column">
                        <div class="col-md-8">
                            <form action="modul/subrogasi/update_correction.php?idDataRC=<?php echo $idDataRC; ?>"
                                method="post">

                                <div class="input-group-sm col-md-4">
                                    <label for="correctiondate">Tanggal Koreksi</label>
                                    <input type="date" name="correctiondate" id="correctiondate" class="form-control">
                                </div>
                                <div class="input-group-sm col-md-4">
                                    <label for="description">Deskripsi</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                                <div class="input-group-sm col-md-4">
                                    <br>
                                    <button type="submit" value="submit" name="submit" class="btn btn-success btn-sm"
                                        data-toggle="tooltip" data-placement="bottom" title="update">Update</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>