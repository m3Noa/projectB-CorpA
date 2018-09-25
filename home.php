<?php
/**
 * Upload page for logged in system users.
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "File Upload";

include('includes/header.php');
include('includes/side_menu.php');

?>
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
										<p>Hi, <b><?php echo htmlspecialchars($_SESSION["realname"]); ?></b>. Welcome to User Dashboard.</p>
										<hr>
										<p>(Maybe follow with a List of Recent News/Blog Posts)</p>
									</div>
								</div>
							</div>
						</div>
	
						<?php include('includes/widgets.php');?>	
					</div>
		
					<?php include('includes/right_panel.php');?>	
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