<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/

Coded by: 	Gary Abraham
Date:		22 Agustus 2017
-->
<?php
	error_reporting(0);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Askrindo BRI - Klaim | Log In</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Powered by: Holy Spirit... Gary Keren :D" />
<link rel="shortcut icon" href="images/logofav.png"/>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		
		<!-- main content start
		<div id="page-wrapper" style="margin: 0;">
			<div class="main-page login-page ">
				<h3 class="title1">Askrindo BNI - Klaim</h3>
				<div class="widget-shadow">
					<div class="login-top">
						<h4>Silahkan masuk dengan menggunakan username dan password</h4>
					</div>
					<div class="login-body">
						<form action="cek_login.php" method="post">
							<input type="text" class="user" name="username" placeholder="Username" required="">
							<input type="password" name="password" class="lock" placeholder="Password">
							<input type="submit" name="Sign In" value="Sign In">
						</form>
					</div>
				</div>
			</div>
		</div>-->
		<div id="page-wrapper" style="margin: 0; background: url('images/B1.jpg') 50% / cover fixed;">
			<div class="row" style="position: relative; top: 50%;transform: translateY(50%); background-color: rgba(255, 255, 255, 0.7)">
				<div class="col-md-4">
					<br/><br/><br/><img src="images/new_logo.png" style="float: right;">
				</div>
				<div class="col-md-4">
					<div class="main-page login-page " style="width: 100%;">
						<!--<h3 class="title1">Admin Web</h3>-->
						<div style="background: transparent;">
							<!--<div class="login-top">
								<h4>Silahkan masuk dengan menggunakan username dan password</h4>
							</div>-->
							<div class="login-body">
								<form action="cek_login.php" method="post">
									<input type="text" class="user" name="username" placeholder="Username" required="">
									<input type="password" name="password" class="lock" placeholder="Password">
									<input type="submit" value="Log In" style="background: #176AB4;">
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<br/><br/><br/><img src="images/Logo_BRI.png">
				</div>
				<div class="clearfix"> </div>
			</div>
			
		</div>
		<!--footer-->
		<div class="footer">
		   <p>&copy; 2017 Askrindo - Divisi Teknologi Informasi. Indonesia</p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
</body>
</html>