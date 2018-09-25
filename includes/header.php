<?php
/**
 * This file generates the header for the back-end and also for the default
 * template.
 *
 * Other checks for user level are performed later to generate the different
 * menu items, and the content of the page that called this file.
 *
 */

/** Check for an active session or cookie */
check_for_session();

/**
 * Check if the current user has permission to view this page.
 * If not, an error message is generated instead of the actual content.
 * The allowed levels are defined on each individual page before the
 * inclusion of this file.
 */
can_see_content($allowed_levels);

/** Check if the active account belongs to a system user or a client. */
//check_for_admin();

/** If no page title is defined, revert to a default one */
if (!isset($page_title)) { $page_title = 'System Administration'; }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $page_title;?> &raquo; Corporate Alliance</title>
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