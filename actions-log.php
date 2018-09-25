<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Action Log » Corporate Alliance</title>
	<script src="includes/js/jquery.1.12.4.min.js"></script>
	<link rel="stylesheet" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" />
	<link rel="stylesheet" media="all" type="text/css" href="assets/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" media="all" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" media="all" type="text/css" href="css/main.min.css" />
</head>

<body class="home logged-in logged-as-admin dashboard hide_title menu_hidden backend" data-gr-c-s-loaded="true">
	<div class="container-custom">
		<header class="navbar navbar-static-top navbar-fixed-top" id="header">
			<ul class="nav pull-left nav_toggler">
				<li>
					<a class="toggle_main_menu" href="#"><i class="fa fa-bars"></i><span>Toogle menu</span></a>
				</li>
			</ul>

			<div class="navbar-header">
				<span class="navbar-brand">Corporate Alliance</span>
			</div>

			<ul class="nav pull-right nav_account">
				<li id="header_welcome">
					<span> <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
				</li>
				<li>
					<a class="my_account" href="#"><i class="fa fa-user-circle"></i> My Account</a>
				</li>
				<li>
					<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
				<li class="current_nav active">
					<a class="nav_top_level" href="home.php"><i class="fa fa-tachometer fa-fw"></i><span class="menu_label">Dashboard</span></a>
				</li>
				<li class="separator"></li><li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-file fa-fw"></i><span class="menu_label">Files</span></a>
					<ul class="dropdown_content" style="display: none;">
						<li>
							<a href="files-upload.php"><span class="submenu_label">Upload</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="files-manage.php"><span class="submenu_label">Manage files</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="files-categories.php"><span class="submenu_label">Categories</span></a>
						</li>
					</ul>
				</li>
				<li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-address-card fa-fw"></i><span class="menu_label">Company Profiles</span></a>
					<ul class="dropdown_content" style="display: none;">
						<li>
							<a href="com_profiles-add.php"><span class="submenu_label">Add New Profile</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="com_profiles.php"><span class="submenu_label">Manage Profiles</span></a>
						</li>
					</ul>
				</li>
				<li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-users fa-fw"></i><span class="menu_label">System Users</span></a>
					<ul class="dropdown_content" style="display: none;">
						<li>
							<a href="users-add.php"><span class="submenu_label">Add New User</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="users.php"><span class="submenu_label">Manage users</span></a>
						</li>
					</ul>
				</li>
				<li class="separator"></li><li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-wrench fa-fw"></i><span class="menu_label">Admin Tools</span></a>
					<ul class="dropdown_content" style="display: none;">
						<li>
							<a href="actions-log.php"><span class="submenu_label">Actions log</span></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="resetpwd.php"><span class="submenu_label">Change Password</span></a>
						</li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">
				
				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Dashboard</h2>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget">
									<h4>Welcome Board </h4>
									<div class="widget_int">
										<p>This feature is still in development. Please come back later!</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="widget">
									<h4>Widget</h4>
									<div class="widget_int">
							Widget Content			
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget">
									<h4>Statistics</h4>
									<div class="widget_int">
									Widget Content
									</div>
								</div>
							</div>
						</div>
					</div>
	
					<div class="col-sm-4 container_widget_actions_log">
						<div class="widget">
							<h4>Recent activites (Demo)</h4>
							<div class="widget_int">
								<div class="log_change_action">
									<a class="log_action btn btn-sm btn-default btn-inverse" href="#">
												All activities							</a>
									<a class="log_action btn btn-sm btn-default" href="#">
												Logins							</a>
									<a class="log_action btn btn-sm btn-default" href="#">
												Downloads							</a>
								</div>
								<ul class="activities_log">
									<li>
										<div class="log_ico">
											<img alt="Action icon" src="img/log_icons/login.png">
										</div>
										<div class="home_log_text">
											<div class="date">20/08/2018</div>
											<div class="action">
												<span>System Admin</span> logged in to the system. 							
											</div>
										</div>
									</li>
								</ul>
								<div class="view_full_log">
									<a class="btn btn-primary btn-wide" href="#">View all</a>
								</div>
							</div>
						</div>
					</div>
	
				</div> <!-- row -->
			</div> <!-- container-fluid -->

			<footer>
				<div id="footer">
					Developed by Project Team B - 2018
				</div>
			</footer>
			<script src="assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="includes/js/jquery.validations.js"></script>
			<script src="includes/js/jquery.psendmodal.js"></script>
			<script src="includes/js/js.cookie.js"></script>
			<script src="includes/js/main.js"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->	
</body>
</html>