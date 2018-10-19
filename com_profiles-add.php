<?php
/**
 * Adding new corporation profile - only for admin and manager users
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "New Corporation Profile";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');


$new_corpname = $new_address = $new_phone = $new_description = $fileUrl = "";
$corpname_err = $desc_err = $address_err = $phone_err = $note = "";
$msgtype = "help-block";

// File Types that are allowed to be uploaded
$allowed = array(
	// image types
	"jpg" => "image/jpg", 
	"jpeg" => "image/jpeg", 
	"gif" => "image/gif", 
	"png" => "image/png"
	);
$maxsize = 10 * 1024 * 1024; // corp-profile picture limit: 10 MB
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate corpname
    if(empty(trim($_POST["corpname"]))){
        $corpname_err = "Please enter Corporation Name.";
    } elseif(strlen(trim($_POST["corpname"])) < MIN_USER_CHARS){
        $corpname_err = "Corporation Name must have at least ".MIN_USER_CHARS." characters.";
    }
	else{
        // Check if the name exist
        $sql = "SELECT id FROM ca_corps WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_corpname = trim($_POST["corpname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $corpname_err = "This Corporation Name already exists.";
                } else{
                    $new_corpname = trim($_POST["corpname"]);
                }
            } else{
                $note = "Oops! Something went wrong. Please try again later.";
            }
			// Close statement
			mysqli_stmt_close($stmt);       
		}
         
    }
    
	// Validate description
    if(empty(trim($_POST["description"]))){
        $desc_err = "Corporation Description should not be empty.";
	} else 
		$new_description = trim($_POST["description"]);
	
	// Validate description
    if(empty(trim($_POST["description"]))){
        $address_err = "Corporation Address should not be empty.";
	} else 
		$new_address = trim($_POST["address"]);

	// Validate description
    if(empty(trim($_POST["description"]))){
        $phone_err = "Corporation Contact Number should not be empty.";
	} else 
		$new_phone = trim($_POST["phone"]);

	// Check if profile photo was uploaded from local computer.
	if(isset($_FILES["resource"]) && $_FILES["resource"]["error"] == 0){
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
			$filename = str_replace(" ", "_", $new_corpname);
			if(file_exists("upload/corp-profile/" . $filename)){
				unlink("upload/corp-profile/" . $filename);
			} else{
				move_uploaded_file($_FILES["resource"]["tmp_name"], "upload/corp-profile/" . $filename);
				// Get the actual file URL that stored on the server
				$fileUrl = "upload/corp-profile/" . $filename;
			} 
		} else{
			$note = "Error: There was a problem uploading your file. Please try again."; 
		}
	}

    // Check input errors before inserting in database
    if(empty($corpname_err) && empty($desc_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ca_corps (name, address, phone, description, created_by, profile_photo) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $new_corpname, $new_address, $new_phone, $new_description, $username, $fileUrl);
                        
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Show success message
                $note = "Successfully Added new Corporation Profile.";
				$msgtype = "success";
				// Log Action
				log_action($link, 14, $userid, $username, 0, "", 0, $new_corpname);
            } else {
                $note = "Something went wrong. Please try again later.";
            }
			// Close statement
			mysqli_stmt_close($stmt);
        } else $note = "Something went wrong with the SQL.";
         
    }
    
    // Close connection
    //mysqli_close($link);
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
				<style>
				.success {
					color: #393;
				}
				</style>
				<div class="row">
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget">
										<h4>Add New Corporation Profile</h4>
									<div class="widget_int">
										<p>Please fill this form to create new Corporation Profile.</p>
										<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
											<div class="form-group <?php echo (!empty($corpname_err)) ? 'has-error' : ''; ?>">
												<label>Corporation Name</label>
												<input type="text" name="corpname" class="form-control" value="<?php echo $new_corpname; ?>">
												<span class="help-block"><?php echo $corpname_err; ?></span>
											</div>    
											<div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
												<label>Corporation Address</label>
												<input type="text" name="address" class="form-control" value="<?php echo $new_address; ?>">
												<span class="help-block"><?php echo $address_err; ?></span>
											</div>    
											<div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
												<label>Contact Phone Number</label>
												<input type="text" name="phone" class="form-control" value="<?php echo $new_phone; ?>">
												<span class="help-block"><?php echo $phone_err; ?></span>
											</div>    
											<div class="form-group <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
												<label>Description</label>
												<textarea rows="10" name="description" class="form-control" placeholder="Enter description here..."><?php echo ($new_description != "") ? $new_description : ""; ?></textarea>
												<span class="help-block"><?php echo $desc_err; ?></span>
											</div>
											<div class="form-group">
												<label for="fileSelect">Corporation Profile Picture (Optional)</label>
												<input style="width: 100%; line-height: 30px; padding: 10px 20px" type="file" name="resource" id="fileSelect">
												<hr>
												<p class="<?php echo $msgtype; ?>"><?php if(!empty($note)) echo $note;?></p>
											</div>
											<div class="form-group">
												<input type="submit" class="btn btn-primary" value="Submit">
												<input type="reset" class="btn btn-default" value="Reset">
											</div>
										</form>
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