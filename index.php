<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
} /*else {
	// redirect the user to the login page if not
	header("location: login.php");
    exit;
}*/

// TO DO: This page should show a landing page with the main menu on top and all public contents.
?>
<!doctype html>
<html lang="en"><head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home » Corporate Alliance</title>
	<script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/api2/v1535045166622/recaptcha__en.js"></script><script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/api2/v1535045166622/recaptcha__en.js"></script><script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/api2/v1535045166622/recaptcha__en.js"></script><script src="includes/js/jquery.1.12.4.min.js"></script>
	<link rel="stylesheet" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300">
	<link rel="stylesheet" media="all" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" media="all" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" media="all" type="text/css" href="css/main.min.css">
	<style>
	.row {
		position: relative;
	}
	.col {
		position: relative;
		z-index: 10;
		display: block;
		float: left;
		width: 100%;
	}
	.container, .full-width-content .tab-container {
    max-width: 1425px;
    width: 100%;
    margin: 0 auto;
    padding: 0 90px;
	}
	header#top {
		position: relative;
		z-index: 9998;
		width: 100%;
	}
	header .container .row {
		padding-bottom: 0px;
	}
	.row .col.span_9 {
		float: right;
	}
	.row .col.span_3, .row .col.span_9 {
		width: auto;
	}
	header#top .span_9 {
		position: static !important;
	}
	header, nav {
		display: block;
	}
	header nav > ul {
		float: right;
		overflow: visible!important;
		transition: padding 0.8s ease, margin 0.25s ease;
		min-height: 1px;
		line-height: 1px;
	}
	.sf-menu, .sf-menu * {
		list-style: none outside none;
		margin: 0;
		padding: 0;
		z-index: 10;
	}
	header nav > ul > li {
		float: left;
	}
	header nav ul li {
		float: right;
	}
	.sf-menu li {
		float: left;
		line-height: 12px!important;
		font-size: 12px!important;
		position: relative;
	}
	.sf-menu li {
		float: left;
		position: relative;
		padding-left: 30px;
	}
	.sf-menu, .sf-menu * {
		list-style: none outside none;
		margin: 0;
		padding: 0;
		z-index: 10;
	}
	header nav > ul > li > a {
		font-size: 17px;
		line-height: 23.8px;
		font-weight: 700;
		padding: 0 10px 0 10px;
		display: block;
	}
	.navbar#header {
		background: #fff;
	}
	.content-block {
		background: #fff;
		font-size: 16px;
	}
	.blocktitle-1 {
		
	}
	.blocktitle-2 {
		
	}
	.blockcontent-1 {
		width: 80%;
		margin: auto;
	}
	.blockcontent-2 {
		
	}
	.sub-blockcontent-3 {
		width: 32%;
		padding: 20px;
		text-align: center;
		display: inline-block;
	}
	.sub-blockcontent-4 {
		width: 24%;
		padding: 20px;
		text-align: center;
		display: inline-block;
	}
	.nectar-milestone {
		display: inline-block;
		padding-bottom: 25px;
		
	}
	.symbol {
		display: inline-block;
	}
	</style>
</head>

<body class="index login backend">
	<div class="container-custom">

		<header id="header" class="navbar navbar-static-top navbar-fixed-top header_unlogged">
			<div class="container" style="visibility: visible;">
				<div class="row">
					<div class="col span_3">
						<a id="logo" href="http://thecorporatealliance.co.uk">
							<img src="img/style/logo/logo.png" alt="Corporate Alliance" style="
    height: 80px;
    padding-top:  10px;
"> 
						</a>
					</div><!--/span_3-->
					<div class="col span_9 col_last">
												
						<nav>
							
							<ul class="sf-menu sf-js-enabled sf-arrows">	
								<li id="menu-item-1"><a href="index.php" style="padding-bottom: 38.5px; padding-top: 23.5px;">Home</a></li>
								<li id="menu-item-2"><a href="about-us.php" style="padding-bottom: 38.5px; padding-top: 23.5px;">About Us</a></li>
								<li id="menu-item-3"><a href="login.php" style="padding-bottom: 38.5px; padding-top: 23.5px;">Member</a></li>
								<li id="menu-item-4"><a href="register.php" style="padding-bottom: 38.5px; padding-top: 23.5px;">Join Us</a></li>
								<li id="menu-item-5"><a href="blog.php" style="padding-bottom: 38.5px; padding-top: 23.5px;">Blog</a></li>
							</ul>
						</nav>
					</div><!--/span_9-->
				</div><!--/row-->
			</div><!--/container-->
		</header>
		<div class="main_content_unlogged">
			<div id="top-slider">
				<!--placeholder-->
				<img src="img/style/corpa_slider.jpg" alt="Corporate Alliance Resource Bucket" width="100%">
			</div>
			<div class="content-block">
				<div class="blocktitle-1" style="padding-top: 0px;padding-bottom: 0px;">
					<div class="row-bg-wrap"> <div class="row-bg   " style=""></div> </div>
					<div class="col span_12 light " style="    background: #0e5f49;    padding: 10px 50px;    margin-bottom:  40px;">
						<h1 style="    font-weight:  bold;    text-align:  center;">Who we are</h1>
					</div>
				</div>			
				<div class="blockcontent-1" style="padding-top: 0px; padding-bottom: 0px; ">
							<p style="text-align: center;">The Corporate Alliance is the nationally recognised membership charity working with employers to lessen the impact of domestic violence in the workplace.</p>
				</div>
				<div class="blockcontent-1" style="padding-top: 50px;padding-bottom: 50px;margin:  auto;width: 80%;">
					<div class="sub-blockcontent-4">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 62px; line-height: 62px;"><span>25</span><span class="symbol">%</span></div> <div class="subject">of women are affected by domestic violence during their adult lifetimes</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-4">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 62px; line-height: 62px;"><span>16</span><span class="symbol">%</span></div> <div class="subject">of men are affected by domestic violence during their adult lifetimes</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-4">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 62px; line-height: 62px;"><span>75</span><span class="symbol">%</span></div> <div class="subject">of people who endure domestic violence are targetted at work</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-4">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 62px; line-height: 62px;"><span>58</span><span class="symbol">%</span></div> <div class="subject">of abused women miss at least 3 days of work a month</div> 
						</div> 
					</div> 
				</div>
			</div>
			<div class="content-block" style="
    background: #0b7d79;
    color:  #ddd;
">
				<div class="blocktitle-2" style="padding-top: 0px;padding-bottom: 0px;">
					<div class="row-bg-wrap"> <div class="row-bg   " style=""></div> </div>
					<div class="col span_12 light " style="background: #44c3a1;padding: 10px 50px;margin-bottom:  40px;">
						<h1 style="    font-weight:  bold;    text-align:  center;">Our Team Members</h1>
					</div>
				</div>			
				<div class="blockcontent-1" style="padding-top: 0px; padding-bottom: 0px; ">
							<p style="text-align: center;">We are a group of student from La Trobe University currently studying Bachelor of IT. This is our final year before graduate.</p>
				</div>
				<div class="blockcontent-1" style="padding-top: 50px; padding-bottom: 50px; ">
					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Hoang Ha Nam</span></div> <div class="subject">Project Leader</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Hana Phung</span></div> <div class="subject">Secretary</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Vincent Vu</span></div> <div class="subject">Project Assistant</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Patrick Wang</span></div> <div class="subject">Customer Service</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Molin Yuan</span></div> <div class="subject">Marketing Development</div> 
						</div> 
					</div> 

					<div class="sub-blockcontent-3">
						<div class="wpb_wrapper">
							<div class="nectar-milestone " style="font-size: 32px; line-height: 62px;"><span>Christ Li</span></div> <div class="subject">Project Development</div> 
						</div> 
					</div> 
				</div>
			
			</div>
			<div class="content-block">
			
			</div>
		</div>
		<footer>
			<div id="footer">
				Developed by Project Team B - 2018
			</div>
		</footer>
		
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="includes/js/jquery.validations.js"></script>
		<script src="includes/js/jquery.psendmodal.js"></script>
		<script src="includes/js/jen/jen.js"></script>
		<script src="includes/js/js.cookie.js"></script>
		<script src="includes/js/main.js"></script>
		<script src="includes/js/js.functions.php"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script src="includes/js/chosen/chosen.jquery.min.js"></script>
		</div> <!-- main_content -->
	 <!-- container-custom -->

	


<?php</html>