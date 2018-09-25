<?
/**
 * The Main Menu of User Dashboard. At the moment it's mainly html hardcore.
 *
 * TO DO: Rewrite the content to make it more dynamic
 */

?>
		<!-- #### Main Menu #### -->
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
		<!-- #### /End Main Menu #### -->