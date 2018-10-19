<?
/**
 * The Main Menu of User Dashboard. At the moment it's mainly html hardcode.
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
						<?php if($userlevel > 7) {?><li>
							<a href="files-upload.php"><span class="submenu_label">Upload</span></a>
						</li>
						<li class="divider"></li><?php }?>
						<li>
							<a href="files-manage.php"><span class="submenu_label">List Files</span></a>
						</li>
						<li class="divider"></li>
						<!--li>
							<a href="files-categories.php"><span class="submenu_label">Categories</span></a>
						</li-->
					</ul>
				</li>
				<li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-address-card fa-fw"></i><span class="menu_label">Corporation Profiles</span></a>
					<ul class="dropdown_content" style="display: none;">
						<?php if($userlevel > 7) {?><li>
							<a href="com_profiles-add.php"><span class="submenu_label">Add/Edit Profile</span></a>
						</li>
						<li class="divider"></li><?php }?>
						<li>
							<a href="com_profiles.php"><span class="submenu_label">List Profiles</span></a>
						</li>
					</ul>
				</li>
				<li class="has_dropdown">
					<a class="nav_top_level" href="#"><i class="fa fa-users fa-fw"></i><span class="menu_label">System Users</span></a>
					<ul class="dropdown_content" style="display: none;">
						<?php if($userlevel > 7) {?><li>
							<a href="users-add.php"><span class="submenu_label">Add New User</span></a>
						</li>
						<li class="divider"></li><?php }?>
						<li>
							<a href="users.php"><span class="submenu_label">List Users</span></a>
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
							<a href="users-edit.php?user-id=<?php echo $_SESSION["id"];?>"><span class="submenu_label">Change User Profile</span></a>
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