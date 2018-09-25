<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if no then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
	header("location: login.php");
	exit;
}

// Include file
require_once "includes/connect.php";

// Define variables and initialize with empty values
$username = $_SESSION["username"];
$fName = $fDesc = $fUrl = $filename = $filetype = $fileUrl = $filename_err = $fileDesc_err = $sql_err = $note = "";
$filesize = 0;


// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Check required information
	if(empty(trim($_POST["filename"]))) {
		$filename_err = "Please enter a name for the file.";
	}
	else
		$fName = trim($_POST["filename"]);
	if(empty(trim($_POST["fileDesc"]))) {
		$fileDesc_err = "Please enter the file description.";
	}	
	else
		$fDesc = trim($_POST["fileDesc"]);
	
	// To Do: write code for upload file from URL
	// for now it only recieve the input url and do nothing
	if(!empty(trim($_POST["fileUrl"]))) $fUrl = trim($_POST["fileUrl"]);
	
	
	// Check if file was uploaded from local computer without errors
	if(isset($_FILES["resource"]) && $_FILES["resource"]["error"] == 0 && $filename_err == "" && $fileDesc_err == ""){
		$allowed = array(
			// image types
			"jpg" => "image/jpg", 
			"jpeg" => "image/jpeg", 
			"gif" => "image/gif", 
			"png" => "image/png",
			// document types
			'pdf' => 'application/pdf',
			'txt' => 'text/plain',
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			// audio/video files
			'mp3' => 'audio/mpeg',
			'mp4' => 'video/mp4',
			// archive files
			'zip' => 'application/zip',
			);
		$filename = $_FILES["resource"]["name"];
		$filetype = $_FILES["resource"]["type"];
		$filesize = $_FILES["resource"]["size"];
	
		// Verify file extension
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
	
		// Verify file size - 5MB maximum
		$maxsize = 5 * 1024 * 1024;
		if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
	
		// Verify MIME type of the file
		if(in_array($filetype, $allowed)){
			// Check whether file exists before uploading it
			if(file_exists("upload/" . $_FILES["resource"]["name"])){
				$note = $_FILES["resource"]["name"] . " is already exists.";
			} else{
				move_uploaded_file($_FILES["resource"]["tmp_name"], "upload/" . $_FILES["resource"]["name"]);
				
				// #### Insert into database after file has been uploaded
				// Prepare the insert statement
				$sql = "INSERT INTO ca_files (url, filename, description, uploader) VALUES (?, ?, ?, ?)";
				
				// Get the actual file URL that stored on the server
				$fileUrl = "upload/" . $_FILES["resource"]["name"];
				
				if($stmt = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "ssss", $fileUrl, $fName, $fDesc, $username);
										
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						// Redirect to login page
						//header("location: login.php");
						$note = "Your file was uploaded successfully.";
					} else {
						$sql_err =  "Something went wrong. Please try again later.";
					}
				}
				 
				// Close statement
				mysqli_stmt_close($stmt);
				
				// Close connection
				mysqli_close($link);
			} 
		} else{
			$note = "Error: There was a problem uploading your file. Please try again."; 
		}
	} else{
		$note = "Error: " . $_FILES["resource"]["error"];
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Upload File &raquo; Corporate Alliance</title>
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
					<span> System Admin</span>
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
							<h4>Upload File</h4>
							<div class="widget_int">
								<div>
									<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
										<fieldset>
											<div class="form-group">
												<label for="filename">File Name:</label>
												<input class="form-control" value="<?php echo $fName; ?>" name="filename" id="filename">
												<span><?php echo $filename_err; ?></span>
											</div>
											<div class="form-group">
												<label for="fileDesc">File Description:</label>
												<input class="form-control" value="<?php echo $fDesc; ?>" name="fileDesc" id="fileDesc">
												<span><?php echo $fileDesc_err; ?></span>
											</div>
											<div class="form-group">
												<label for="fileUrl">Upload From URL:</label>
												<input class="form-control" value="<?php echo $fUrl; ?>" type="text" name="fileUrl" id="fileUrl">
											</div>
											<div class="form-group">
												<label for="fileSelect">Upload From Computer:</label>
												<input style="width: 100%; line-height: 30px; padding: 10px 20px" type="file" name="resource" id="fileSelect">
												<hr>
												<span><?php echo $note; ?></span>
											</div>
											<div class="inside_form_buttons">
												<button type="submit" id="submit" class="btn btn-wide btn-primary">Upload File</button>
											</div>
										</fieldset>
										<hr>
										<p class="note"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png, .pdf, .txt, .doc, .rtf, .xls, .ppt, .mp3, .mp4, .zip formats allowed to a max size of 5 MB.</p>
										
									</form>
									<div>
										<hr>
										<?php // Debug code
										if($note != ""){
											echo "Error: " . $note . "<br>";
										} else{
											echo "File Name: " . $filename . "<br>";
											echo "File Type: " . $filetype . "<br>";
											echo "File Size: " . ($filesize / 1024) . " KB<br>";
											echo "Stored in: " . $fileUrl;
										}
										?>	
									</div>
								</div>
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