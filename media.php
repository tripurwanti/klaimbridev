<?php
session_start();
error_reporting(0);

include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "config/class_paging.php";
include "config/fungsi_thumb.php";

include "timeout.php";
//include "wall/session.php";

if ($_SESSION[login] == 1) {
    if (!cek_login()) {
        $_SESSION[login] = 0;
    }
}

if ($_SESSION[login] == 0) {
    header('location:error');
} else {
    if (empty($_SESSION['username']) and empty($_SESSION['password']) and $_SESSION['login'] == 0) {
        header('location:error');
    } else {
?>
        <!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
        <!DOCTYPE HTML>
        <html>

        <head>
            <title>Askrindo BRI - Klaim</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="keywords" content="Powered by: Holy Spirit... Gary Keren :D" />
            <link rel="shortcut icon" href="images/logofav.png" />
            <script type="application/x-javascript">
                addEventListener("load", function() {
                    setTimeout(hideURLbar, 0);
                }, false);

                function hideURLbar() {
                    window.scrollTo(0, 1);
                }
            </script>
            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
            <!-- Custom CSS -->
            <link href="css/style.css" rel='stylesheet' type='text/css' />
            <!-- font CSS -->
            <!-- font-awesome icons -->
            <link href="css/font-awesome.css" rel="stylesheet">
            <!-- //font-awesome icons -->
            <!-- js-->
            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/modernizr.custom.js"></script>
            <!--webfonts-->
            <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
            <!--//webfonts-->
            <!--animate-->
            <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
            <!-- sweet alert -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

            <script src="js/wow.min.js"></script>
            <script>
                new WOW().init();
            </script>
            <script type="text/javascript">
                /*
	function notifyBrowser(title,desc,url) {
		if (!Notification) {
			console.log('Desktop notifications not available in your browser..'); 
			return;
		}
		if (Notification.permission !== "granted") {
			Notification.requestPermission();
		} else {
			var notification = new Notification(title, {
				icon:'notif.png',
				body: desc,
			});
			// Remove the notification from Notification Center when clicked.
			notification.onclick = function () {
				window.open(url);      
			};
			// Callback function when the notification is closed.
			notification.onclose = function () {
				console.log('Notification closed');
			};
		}
	}
	setInterval(
		function(){
			var strIPClient = document.getElementById("IPClient");
			jQuery.getJSON('load_notif.php?ip='+strIPClient.value, 
			function(data){
				//if (data.nama=='') {
					//notifyBrowser(data.nama,data.status,"tes1");
				//}
				for (var i = 0, length = data.length; i < length; i++) {
					notifyBrowser(data[i].nama+" ("+data[i].ip+")","GW: "+data[i].status+" | VPN: "+data[i].status_vpn+" | HTS: "+data[i].status_hts+"","geonetwork");
					var audio = new Audio('notif.mp3');
					audio.play();
				}
			});
		}, 3000
	);
	*/
                var autorefresh = setInterval(
                    function() {
                        $("#jamjalan").load("jamjalan.php");
                        e.preventDefault();
                    }, 1000
                )

                var autorefresh = setInterval(
                    function() {
                        $("#IDNotifikasi").load("notifikasi.php");
                        e.preventDefault();
                    }, 5000
                )
            </script>
            <!--//end-animate-->
            <!-- Metis Menu -->
            <script src="js/metisMenu.min.js"></script>
            <script src="js/custom.js"></script>
            <link href="css/custom.css" rel="stylesheet">
            <style>
                #cbp-spmenu-s1::-webkit-scrollbar-track {
                    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                    background-color: #F5F5F5;
                }

                #cbp-spmenu-s1::-webkit-scrollbar {
                    width: 6px;
                    background-color: #F5F5F5;
                }

                #cbp-spmenu-s1::-webkit-scrollbar-thumb {
                    background-color: orange;
                }
            </style>
            <!--//Metis Menu -->
        </head>

        <body class="cbp-spmenu-push">
            <div class="main-content">
                <!--left-fixed -navigation-->
                <div class=" sidebar" role="navigation">
                    <div class="navbar-collapse">
                        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="media.php?module=klaim&q=2">Notifikasi <span id="IDNotifikasi"></span></a>
                                </li>
                                <li>
                                    <a href="media.php?module=home"><i class="fa fa-home nav_icon"></i>Beranda</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-files-o nav_icon"></i>Pengajuan Klaim<span class="fa arrow"></span></a>
                                    <?php
                                    //query dulu yuk!

                                    if ($_SESSION[username] == 'admin') {
                                        //Belum Diperiksa
                                        $saq1    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '0'";

                                        //Data Lengkap
                                        $saq2    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '4'";

                                        //Tidak Lengkap
                                        $saq3    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '3'";

                                        //Seluruh Data
                                        $saq4    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2";

                                        //Data Disetujui
                                        $saq5    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '2'";

                                        //Data Ditolak
                                        $saq6    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '1'";
                                    } else {
                                        //Belum Diperiksa
                                        $saq1    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '0' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";

                                        //Data Lengkap
                                        $saq2    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '4' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";

                                        //Tidak Lengkap
                                        $saq3    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '3' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";

                                        //Seluruh Data
                                        $saq4    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";

                                        //Data Disetujui
                                        $saq5    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '2' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";

                                        //Data Ditolak
                                        $saq6    = "SELECT count(no_rekening) AS banyak_data FROM pengajuan_klaim_kur_gen2 WHERE status_klaim = '1' AND substring(no_sertifikat, 4, 2) = '$_SESSION[id_kantor]';";
                                    }

                                    $naq1 = mssql_fetch_array(mssql_query($saq1));
                                    $naq2 = mssql_fetch_array(mssql_query($saq2));
                                    $naq3 = mssql_fetch_array(mssql_query($saq3));
                                    $naq4 = mssql_fetch_array(mssql_query($saq4));
                                    $naq5 = mssql_fetch_array(mssql_query($saq5));
                                    $naq6 = mssql_fetch_array(mssql_query($saq6));

                                    if ($naq1['banyak_data'] > 500) {
                                        $naq1range = "&range=500";
                                    }
                                    if ($naq2['banyak_data'] > 500) {
                                        $naq2range = "&range=500";
                                    }
                                    if ($naq3['banyak_data'] > 500) {
                                        $naq3range = "&range=500";
                                    }
                                    if ($naq4['banyak_data'] > 500) {
                                        $naq4range = "&range=500";
                                    }
                                    if ($naq5['banyak_data'] > 500) {
                                        $naq5range = "&range=500";
                                    }
                                    if ($naq6['banyak_data'] > 500) {
                                        $naq6range = "&range=500";
                                    }

                                    ?>
                                    <ul class="nav nav-second-level collapse">
                                        <!--<li>
									<a href="media.php?module=klaim&q=x">Belum Dicek</a>
								</li>-->
                                        <?php
                                        if ($_SESSION[username] == 'admin') {
                                        ?>
                                            <li>
                                                <a href="media.php?module=klaim&q=all&title=Seluruh Data">Seluruh Data
                                                    (<?php echo $naq4['banyak_data']; ?>)</a>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li>
                                                <a href="media.php?module=klaim&q=all&title=Seluruh Data">Seluruh Data
                                                    (<?php echo $naq4['banyak_data']; ?>)</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=klaim&q=0&title=Belum Diverifikasi">Belum Diverifikasi
                                                    (<?php echo $naq1['banyak_data']; ?>)</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=klaim&q=4&title=Data Lengkap">Data Lengkap
                                                    (<?php echo $naq2['banyak_data']; ?>)</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=klaim&q=3&title=Tidak Lengkap">Tidak Lengkap
                                                    (<?php echo $naq3['banyak_data']; ?>)</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=klaim&q=2&title=Data Disetujui">Data Disetujui
                                                    (<?php echo $naq5['banyak_data']; ?>)</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=klaim&q=1&title=Data Ditolak">Data Ditolak
                                                    (<?php echo $naq6['banyak_data']; ?>)</a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                    <!-- /nav-second-level -->
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-tasks nav_icon" style="color : white;"></i>Pelunasan Klaim<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <?php
                                        if ($_SESSION[username] == 'admin' || $_SESSION[username] == 'ask.keuangan') {
                                        ?>
                                            <li>
                                                <a href="media.php?module=upload"><i class="fa fa-upload nav_icon"></i>Upload RC</a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="media.php?module=listData"><i class="fa fa-list nav_icon"></i>List data
                                                RC</a>
                                        </li>
                                        <li>
                                            <a href="media.php?module=rekon"><i class="fa fa-list-ul nav_icon"></i>Report
                                                Rekon</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                                if ($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'ask.klaim') {
                                ?>

                                    <li>
                                        <a href="media.php?module=batalklaim"><i class="fa fa-home nav_icon"></i>Laporan Pembatalan Klaim Otomatis</a>
                                    </li>
                                <?php
                                }
                                if ($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'ask.keuangan') {
                                ?>
                                    <li>
                                        <a href="media.php?module=pengembaliandana"><i class="fa fa-home nav_icon"></i>Monitoring
                                            Pengembalian Dana</a>
                                    </li>
                                <?php
                                }
                                ?>

                                <?php
                                if ($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'userkp') {
                                ?>
                                    <li>
                                        <a href="#"><i class="fa fa-refresh nav_icon" style="color : white;"></i>Subrogasi<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level collapse">
                                            <li>
                                                <a href="media.php?module=subroMonitoring"><i class="fa fa-list nav_icon"></i>Monitoring Subrogasi</a>
                                            </li>
                                            <li>
                                                <a href="media.php?module=subroRejection"><i class="fa fa-list nav_icon"></i>Penolakan Subrogasi</a>
                                            </li>

                                            <li>
                                                <a href="media.php?module=subroUploadRC"><i class="fa fa-upload nav_icon"></i>Upload
                                                    RC Subrogasi</a>
                                            </li>

                                            <li>
                                                <a href="media.php?module=listRCSubrogasi"><i class="fa fa-list nav_icon"></i>Daftar
                                                    RC Subrogasi</a>
                                            </li>
                                            <!-- <li>
                                    <a href="media.php?module=listRCReconSubrogasi"><i
                                            class="fa fa-list nav_icon"></i>Daftar
                                        RC Recon Subrogasi</a>
                                </li> -->
                                            <li>
                                                <a href="media.php?module=reportRC"><i class="fa fa-list nav_icon"></i>Report
                                                    Data RC Subrogasi</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                                <li>
                                    <a href="#"><i class="fa fa-refresh nav_icon" style="color : white;"></i>Klaim Brisurf<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <!-- <li>
                                    <a href="media.php?module=subroMonitoring"><i
                                            class="fa fa-list nav_icon"></i>Monitoring Subrogasi</a>
                                </li>
                                <li>
                                    <a href="media.php?module=subroRejection"><i
                                            class="fa fa-list nav_icon"></i>Penolakan Subrogasi</a>
                                </li> -->
                                        <li>
                                            <a href="media.php?module=claimUploadRC"><i class="fa fa-upload nav_icon"></i>Upload
                                                RC Klaim</a>
                                        </li>
                                        <li>
                                            <a href="media.php?module=claimListRC"><i class="fa fa-list nav_icon"></i>Daftar RC
                                                Klaim</a>
                                        </li>
                                        <li>
                                            <a href="media.php?module=claimListReportReconRC"><i class="fa fa-list nav_icon"></i>Report Recon Klaim</a>
                                        </li>

                                    </ul>
                                </li>
                                <li>
                                    <a href="http://10.220.20.4/askred_bri" target="_blank"><i class="fa fa-home nav_icon"></i>Askred Program</a>
                                </li>
                                <?php
                                if ($_SESSION[username] == 'admin') {
                                ?>
                                    <li>
                                        <a href="media.php?module=user"><i class="fa fa-user nav_icon"></i>Data User</a>
                                    </li>
                                <?php
                                }
                                ?>

                                <li>
                                    <a href="logout.php"><i class="fa fa-times nav_icon"></i>Keluar</a>
                                </li>
                                <hr />
                                <div class="col-md-12" style="color: orange;">
                                    <?php echo $_SESSION[username]; ?><br />
                                    <b><?php echo $_SESSION[namauser]; ?></b><br /><br />
                                    <i class="fa fa-desktop nav_icon"></i>IP: <?php echo $_SERVER['REMOTE_ADDR']; ?><br /><br />
                                    <!--<i class="fa fa-building-o nav_icon"></i>Kantor Askrindo Bandung<br/><br/>
							<i class="fa fa-clock-o nav_icon"></i><?php echo date("Y-m-d H:i:s") . " WIB"; ?><br/>-->
                                </div>
                                <!--<li>
							<a href="#"><i class="fa fa-file-text nav_icon"></i>Dokumen Refund<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<!--<li>
									<a href="media.php?module=refund&q=x">Belum Dicek</a>
								</li>
								<li>
									<a href="media.php?module=refund">Seluruh Data</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
                                <!--</li>-->
                            </ul>
                            <div class="clearfix"> </div>
                            <!-- //sidebar-collapse -->
                        </nav>
                    </div>
                </div>
                <!--left-fixed -navigation-->
                <!-- header-starts -->
                <div class="sticky-header header-section ">
                    <div class="header-left">
                        <!--toggle button start-->
                        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                        <!--toggle button end-->
                        <!--logo -->
                        <div class="logo">
                            <a href="home">
                                <h1>Askrindo - BRI</h1>
                                <span>Klaim</span>
                            </a>
                        </div>
                        <!--//logo-->
                        <!--search-box
				<div class="search-box">
					<form class="input">
						<input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
						<label class="input__label" for="input-31">
							<svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
								<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
							</svg>
						</label>
					</form>
				</div><!--//end-search-box-->
                        <div class="clearfix"> </div>
                    </div>
                    <div class="header-right">
                        <!--notification menu end -->
                        <div class="profile_details">
                            <ul>
                                <li class="profile_details_drop">
                                    <b><a href="#" class="dropdown-toggle"><span id="jamjalan"></span> WIB</a></b>
                                    <!--<b><span id="jamjalan"></span></b>-->
                                </li>
                                <!--
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="images/av.jpg" alt=""> </span> 
									<div class="user-name">
										<p><?php echo $_SESSION['username_bri']; ?></p>
										<span><?php echo $_SESSION['namauser_bri']; ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
								<li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li> 
								<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
						-->
                            </ul>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <!-- //header-ends -->
                <!-- main content start-->
                <?php include "content.php"; ?>
                <!--footer-->
                <div class="footer">
                    <p>&copy; 2021 Askrindo - Divisi Teknologi Informasi. Indonesia</p>
                </div>
                <!--//footer-->
            </div>
            <!-- Classie -->
            <script src="js/classie.js"></script>
            <script>
                var menuLeft = document.getElementById('cbp-spmenu-s1'),
                    showLeftPush = document.getElementById('showLeftPush'),
                    body = document.body;

                showLeftPush.onclick = function() {
                    classie.toggle(this, 'active');
                    classie.toggle(body, 'cbp-spmenu-push-toright');
                    classie.toggle(menuLeft, 'cbp-spmenu-open');
                    disableOther('showLeftPush');
                };

                function disableOther(button) {
                    if (button !== 'showLeftPush') {
                        classie.toggle(showLeftPush, 'disabled');
                    }
                }
            </script>
            <!--scrolling js-->
            <script src="js/jquery.nicescroll.js"></script>
            <script src="js/scripts.js"></script>
            <!--//scrolling js-->
            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.js"> </script>

            <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
            <script type="text/javascript" src="js/datatables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

            <!-- sweet alert -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


        </body>

        </html>
<?php
    }
}
?>