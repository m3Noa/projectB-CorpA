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


// Define variables and initialize with empty values
$username = $_SESSION["username"];
$userlevel = $_SESSION["userlevel"];
$usercorpid = $_SESSION["usercorpid"];

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
	
		// Verify file size
		$maxsize = MAX_FILESIZE * 1024 * 1024; // Test value: 5MB
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
				$sql = "INSERT INTO ca_files (url, filename, description, uploader, corp_id) VALUES (?, ?, ?, ?, ?)";
				
				// Get the actual file URL that stored on the server
				$fileUrl = "upload/" . $_FILES["resource"]["name"];
				
				if($stmt = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "ssssi", $fileUrl, $fName, $fDesc, $username, $usercorpid);
										
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