<?php
error_reporting(1);
// include "modul/subrogasi/upload_rc.php";
?>
<div id="page-wrapper">
    <div class="main-page">
        <h3 class="title1">Monitoring UCL</h3>
        <div class="tables">
            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <div class="container">
                    <div class="column">
                        <div class="col-md-8">
                            <form action="modul/claim/upload_rc_claim.php" method="post" enctype="multipart/form-data">
                                <!-- <form action="media.php?module=doSubroUploadRC" method="post" enctype="multipart/form-data"> -->
                                Pilih file RC:
                                <br>
                                <div class="input-group-sm col-md-6">
                                    <input type="file" [accept]="accept" name="fileToUpload" id="fileToUpload"
                                        (change)="processFile(imageInput)" class="form-control">
                                </div>
                                <div class="input-group-append col-md-2" style="margin-left: -20px; margin-top: 3px;">
                                    <select name="bank">
                                        <option value="BRI">Bank BRI</option>
                                        <!-- <option value="Mandiri">Bank Mandiri</option>
											<option value="BNI">Bank BNI</option>
											<option value="BTN">Bank BTN</option> -->
                                    </select>
                                </div>
                                <div class="input-group-append col-md-2">
                                    <button type="submit" value="submit" name="submit"
                                        class="btn btn-outline-success btn-sm" data-toggle="tooltip"
                                        data-placement="bottom" title="Upload"><i class="fa fa-upload"></i></button>
                                </div>
                        </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="config/download_template_RC.php" method="post">
                            Download template Excel
                            <br>
                            <input class="btn" type="submit" name="submit" value="Download File" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>