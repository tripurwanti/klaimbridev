<?php
error_reporting(0);
// include "../config/koneksi_askred.php";
include "../config/koneksi.php";
// include "../js/jquery.min.js";


$server3 = "10.20.10.16";
$username3 = "askrindo";
$password3 = "p@ssw0rd";
$database3 = "ASKRINDO_BRI_DEV";
$con3 = mssql_connect($server3, $username3, $password3, true);
mssql_select_db($database3, $con3) or die("Database tidak ditemukan");


$norekPinjaman = $_GET[no_fasilitas];
$sumberklaim = $_GET[sumberklaim];
$statusKlaim = $_GET[q];
$dataKlaim = mssql_query("SELECT * FROM pengajuan_klaim_kur_gen2 WHERE no_rekening ='" . $_GET[no_fasilitas] . "'", $con);
$rDataKlaim  = mssql_num_rows($dataKlaim);
$dDataKlaim = mssql_fetch_array($dataKlaim);

?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->

<!-- <script type="text/javascript" src="../Bootstrap/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../Bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../Jquery-Validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="../Javascript/ActionJS.js"></script> -->

<label style="font-size: 0.9em;margin-top: 10px; "><b>Unggah Dokumen</b></label><br />
<div style="border: 2px solid #f0f0f0; border-radius: 5px; margin-top: 10px; padding: 10px; background-color:#f0f0f0">

    <!-- <form action="#" method="POST" enctype="multipart/form-data"
        onsubmit="return confirm('Apakah dokumen yang diunggah sudah benar?');"> -->
    <!-- <form action="#" method="POST" enctype="multipart/form-data"> -->
    <form method="post" id="form">
        <!-- <form id="formUpload"> -->
        <input id='norekPinjaman' type="hidden" name="no_rekening_pinjaman" value="<?php echo $_GET[no_fasilitas]; ?>">
        <table class="table">
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen LKN</label>
                </td>
                <td colspan="2">
                    <input id="dok_lkn_id" type="text" class="form-control" name="dok_lkn">
                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SPH</label>
                </td>
                <td colspan="2">
                    <input id="dok_sph" type="file" class="form-control" name="dok_sph" value="Dokumen SPH">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">KTP</label>
                </td>
                <td colspan="2">
                    <input id="ktp" type="file" class="form-control" name="ktp" value="KTP">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SLIK</label>
                </td>
                <td colspan="2">
                    <input id="dok_slik" type="file" class="form-control" name="dok_slik" value="Dokumen SLIK">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen SKU</label>
                </td>
                <td colspan="2">
                    <input id="dok_sku" type="file" class="form-control" name="dok_sku" value="Dokumen SKU">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Rekening Koran</label>
                </td>
                <td colspan="2">
                    <input id="dok_rc" type="file" class="form-control" name="dok_rc" value="Dokumen SKU">

                </td>
            </tr>
            <tr>
                <td>
                    <label style="font-size: 0.8em;">Dokumen Tambahan</label>
                </td>
                <td>
                    <input id="dok_additional" type="file" class="form-control" name="dok_additional" value="Dokumen Tambahan">

                </td>
                <td>
                    <input id="dokumenname" type="text" class="form-control" name="dokumenname" value="Nama Dokumen">

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <!-- <input style="margin-top: 10px;" class='btn btn-primary btn-sm' type="submit" value="Unggah"
                        name="submit"> -->
                    <a href="#" type="submit" class="btn btn-success btn-sm" onclick="postValidate()" id="posting">Posting</a>
                </td>

            </tr>

        </table>

    </form>
</div>

<script type="text/javascript" language="javascript">
    // $(document).ready(function() {
    //     $("#formUpload").validate({
    //         rules: {
    //             dok_lkn: {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             dok_lkn: {
    //                 required: "Please enter some data"
    //             }
    //         }
    //     });
    // });

    // function postValidate() {
    //     var dok_lkn_temp = $("#dok_lkn_id").val();
    //     console.log("heheheh");
    // }

    // $(function() {

    //     $("#formUpload").validate({
    //         rules: {
    //             dok_lkn: {
    //                 required: true
    //             },
    //             action: "required"
    //         },
    //         messages: {
    //             dok_lkn: {
    //                 required: "Please enter some data"
    //             },
    //             action: "Please provide some data"
    //         }
    //     });
    // });
</script>