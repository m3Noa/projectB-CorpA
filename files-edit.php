<?php
/**
 * Edit File page for logged in system users.
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "File Upload";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');

$fName = $fDesc = $fUrl = $filename = $filetype = $fileUrl = $filename_err = $fileDesc_err = $sql_err = $note = "";
$filesize = 0;

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

$maxsize = MAX_FILESIZE * 1024 * 1024; // Test value: 5MB
	
	
if(isset($_REQUEST["file-id"])){
    // Get parameters
    $fileid = urldecode($_REQUEST["file-id"]); // Decode URL-encoded string

	// Prepare the sql statement
	$sql = "SELECT url, original_url, filename, description, corp_id FROM ca_files WHERE id = ?";
	
	if($stmt = mysqli_prepare($link, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "i", $param_id);
		
		// Set parameters
		$param_id = $fileid;
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			// Store result
			mysqli_stmt_store_result($stmt);
			
			// Check if username exists, if yes then verify password
			if(mysqli_stmt_num_rows($stmt) == 1){                    
				// Bind result variables
				mysqli_stmt_bind_result($stmt, $url, $org_url, $filename, $description, $corpid);
				
				if(mysqli_stmt_fetch($stmt)){					
					// Store data in session variables
					$fName = $filename;
					$fDesc = $description;
					$fCorpid = $corpid;
					$fUrl = $url;
					$fileUrl = $org_url;
				}
			} else{
				// Display an error message if username doesn't exist
				$note = "No matched file found.";
			}
		} else{
			$note = "Oops! Something went wrong. Please try again later.";
		}
		// Close statement
		mysqli_stmt_close($stmt);
	}

		 
	// Close connection
	////mysqli_close($link);

}



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
	
	$fileid = urldecode($_POST["file-id"]);
	$fUrl = urldecode($_POST["fUrl"]);
	
	if($userlevel == 9) 
		$fCorpid = urldecode($_POST["corp-id"]);
	else	
		$fCorpid = $usercorpid;
	
	// Upload file from URL
	if(!empty(trim($_POST["fileUrl"])))
	{
		$fUrl = trim($_POST["fileUrl"]);
		
		// Verify file extension
		$ext = pathinfo($fUrl, PATHINFO_EXTENSION);
		if(!array_key_exists($ext, $allowed)) $file_err = "Error: Please select a valid file format. File Extension: ".$ext;
		
		// Verify file size
		$data = file_get_contents($fUrl);
		$filesize = strlen($data);
		if(!$filesize || $filesize > $maxsize) 
			$file_err = "Error: File size is larger than the allowed limit or empty. ".$clen;
		else {
			
			$fileUrl = 'upload/'.str_replace(" ", "_", $fName).'_upload.'.$ext;
			file_put_contents($fileUrl, $data);
		}
	} else
	// Check if file was uploaded from local computer without errors
	if($filename_err == "" && $fileDesc_err == ""){
		if(isset($_FILES["resource"]) && $_FILES["resource"]["error"] == 0) {
			$filename = $_FILES["resource"]["name"];
			$filetype = $_FILES["resource"]["type"];
			$filesize = $_FILES["resource"]["size"];
		
			// Verify file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
		
			// Verify file size
			if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
		
			// Verify MIME type of the file
			if(in_array($filetype, $allowed)){
				// Check whether file exists before uploading it
				if(file_exists("upload/" . $_FILES["resource"]["name"])){
					$note = $_FILES["resource"]["name"] . " is already exists.";
				} else{
					// Get the actual file URL that stored on the server
					$fUrl = "upload/" . $_FILES["resource"]["name"];
					move_uploaded_file($_FILES["resource"]["tmp_name"], $fUrl);
					$note = "New resource file uploaded.";
				} 
			}
		} else{
			$note = "Only update file info. Resource file remains the same."; 
		}

		// #### Insert into database after file has been uploaded
		// Prepare the insert statement
		$sql = "UPDATE ca_files SET url = ?, original_url = ?, filename = ?, description = ?, corp_id = ? WHERE id = " . $fileid;
		
		
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssi", $fUrl, $fileUrl, $fName, $fDesc, $fCorpid);
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Log action
				log_action($link, 19, $userid, $username, $fileid, $fName, 0, "");
				$note .= "Your file was updated successfully.";
			} else {
				//$note =  "Something went wrong when connecting to database. Please try again later."; // $sql_err 
				die("ERROR: Could not connect. " . mysqli_connect_error());

			}
			// Close statement
			 mysqli_stmt_close($stmt);
		}
		 
		

	} else{
		$note = "Error: " . $_FILES["resource"]["error"];
	}
}
		// Close connection
		//mysqli_close($link);

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
												<input type="hidden" id="file-id" name="file-id" value="<?php echo $fileid; ?>">
												<input class="form-control" value="<?php echo $fName; ?>" name="filename" id="filename">
												<span><?php echo $filename_err; ?></span>
											</div>
											<div class="form-group">
												<label for="fileDesc">File Description:</label>
												<textarea class="form-control" name="fileDesc" id="fileDesc" rows="10"><?php echo $fDesc; ?></textarea>
												<span><?php echo $fileDesc_err; ?></span>
											</div>
											<?php if ($userlevel == 9) {?>
											<div class="form-group">
												<label for="fileDesc">Corporation:</label>
												<input class="form-control" value="<?php echo $fCorpid; ?>" name="corp-id" id="corp-id">
												<span><?php if(!empty($fileCorp_err)) echo $fileCorp_err; ?></span>
											</div>
											<?php }?>
											<div class="form-group">
												<label for="fileUrl">Upload From URL:</label>
												<input class="form-control" value="<?php echo $fileUrl; ?>" type="text" name="fileUrl" id="fileUrl">
											</div>
											<div class="form-group">
												<label for="fileSelect">Upload From Computer:</label>
												<input type="hidden" id="fUrl" name="fUrl" value="<?php echo $fUrl; ?>">
												<input style="width: 100%; line-height: 30px; padding: 10px 20px" type="file" name="resource" id="fileSelect">
												<hr>
												<span><?php echo $note; ?></span>
											</div>
											<div class="inside_form_buttons">
												<button type="submit" id="submit" class="btn btn-wide btn-primary">Update File</button>
											</div>
										</fieldset>
										<hr>
										<p class="note"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png, .pdf, .txt, .doc, .rtf, .xls, .ppt, .mp3, .mp4, .zip formats allowed to a max size of 5 MB.</p>
										
									</form>
									<div>
										<hr>
										<?php // Debug code
										if($note != ""){
											echo "<b>System Message</b>: " . $note . "<br>";
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
<?php
// Close connection
mysqli_close($link);
										
?>
</body>
</html>