<?php
/**
 * Edit User Profile page for logged in system users.
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "User Profile Edit";


// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');


$edit_username = $edit_realname = $edit_password = $old_password = $edit_email = $edit_address = $edit_phone = $username_err = $realname_err = $email_err = $corpid_err = $level_err = "";
$edit_level = $edit_active = $edit_corpid = 0;

if(isset($_REQUEST["user-id"])){
    // Get parameters
    $edit_userid = urldecode($_REQUEST["user-id"]); // Decode URL-encoded string

	// Prepare the sql statement
	$sql = "SELECT user, name, password, email, level, address, phone, active, corp_id FROM ca_users WHERE id = ?";
	
	if($stmt = mysqli_prepare($link, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "i", $param_id);
		
		// Set parameters
		$param_id = $edit_userid;
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			// Store result
			mysqli_stmt_store_result($stmt);
			
			// Check if username exists, if yes then verify password
			if(mysqli_stmt_num_rows($stmt) == 1){                    
				// Bind result variables
				mysqli_stmt_bind_result($stmt, $param_username, $param_realname, $param_password, $param_email, $param_level, $param_address, $param_phone, $param_active, $param_corpid);
				
				if(mysqli_stmt_fetch($stmt)){					
					// Store data in session variables
					$edit_username = $param_username;
					$edit_realname = $param_realname;
					$old_password = $param_password;
					$edit_email = $param_email;
					$edit_level = $param_level;
					$edit_address = $param_address;
					$edit_phone = $param_phone;
					$edit_active = $param_active; 
					$edit_corpid = $param_corpid;
				}
			} else{
				// Display an error message if username doesn't exist
				$note = "No matched user found.";
			}
		} else{
			$note = "Oops! Something went wrong. Please try again.";
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
	if($userlevel == 9) 
		$edit_corpid = urldecode($_POST["corp-id"]);
	else	
		$edit_corpid = $usercorpid;
	
	$old_password = $_POST["identifier"];
	$edit_userid = urldecode($_POST["user-id"]);

	if(empty(trim($_POST["username"]))) {
		$username_err = "Please enter a nickname for the user.";
	}
	else
		$edit_username = trim($_POST["username"]);
	
	if(empty(trim($_POST["email"]))) {
		$email_err = "Please enter the user email.";
	}	
	else
		$edit_email = trim($_POST["email"]);
	
	
	if(!empty(trim($_POST["password"]))) 
		$edit_password = trim($_POST["password"]);
	
	if(!empty(urldecode($_POST["level"]))) $edit_level = urldecode($_POST["level"]);
	if($edit_level > $userlevel) 
		$level_err = "You cannot set User Level higher than your own User Level.";
	
	if(!empty(trim($_POST["realname"]))) $edit_realname = trim($_POST["realname"]);
	if(!empty(trim($_POST["phone"]))) $edit_phone = trim($_POST["phone"]);
	if(!empty(urldecode($_POST["active"]))) $edit_active = urldecode($_POST["active"]); 
	if(!empty(trim($_POST["address"]))) $edit_address = trim($_POST["address"]);

	// #### Update into database after check all the information
	if($username_err == "" && $email_err == "" && $level_err == "") {
		// Prepare the insert statement
		$sql = "UPDATE ca_users SET user = ?, name = ?, password = ?, email = ?, address = ?, phone = ?, active = ?, level = ?, corp_id = ? WHERE id = " . $edit_userid;
		$note .= "SQL querry prepared.";

		// hash the password before adding to the database
		if($edit_password != "") $edit_password = password_hash($edit_password, PASSWORD_DEFAULT);
		else $edit_password = $old_password;
		$note .= "New password has been hashed.";
	
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssssiii", $edit_username, $edit_realname, $edit_password, $edit_email, $edit_address, $edit_phone, $edit_active,  $edit_level, $edit_corpid);
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Log action
				log_action($link, 6, $userid, $username, 0, "", $edit_userid, $edit_username);

				$note .= "User profile was updated successfully.";
			} else {
				$note .=  "Something went wrong when connecting to database. Please try again later."; // $sql_err 
				//die("ERROR: Could not connect. " . mysqli_connect_error());

			}
			// Close statement
			 mysqli_stmt_close($stmt);
		}
			 
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
							<h4>Edit User Profile</h4>
							<div class="widget_int">
								<div>
									<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
										<fieldset>
											<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
												<label for="username">Username:</label>
												<input type="hidden" id="user-id" name="user-id" value="<?php echo $edit_userid; ?>">
												<input class="form-control" value="<?php echo $edit_username; ?>" name="username" id="username">
												<span class="help-block"><?php echo $username_err; ?></span>
											</div>
											<div class="form-group">
												<label for="realname">Display Name:</label>
												<input class="form-control" value="<?php echo $edit_realname; ?>" name="realname" id="realname">
												<span class="help-block"><?php echo $realname_err; ?></span>
											</div>
											<?php if($edit_userid != $_SESSION["id"]) {?><div class="form-group">
												<label for="password">Password:</label>
												<input type="hidden" id="identifier" name="identifier" value="<?php echo $old_password; ?>">
												<input class="form-control" value="<?php echo $edit_password; ?>" name="password" id="password">
												<span class="help-block"><?php if(!empty($password_err)) echo $password_err; ?></span>
											</div><?php }?>
											<?php if ($userlevel == 9) {?>
											<div class="form-group">
												<label for="corp-id">Corporation ID:</label>
												<input class="form-control" value="<?php echo $edit_corpid; ?>" name="corp-id" id="corp-id">
												<span class="help-block"><?php echo $corpid_err; ?></span>
											</div>
											<?php }?>
											<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
												<label for="email">Email:</label>
												<input class="form-control" value="<?php echo $edit_email; ?>" type="text" name="email" id="email">
												<span class="help-block"><?php echo $email_err; ?></span>
											</div>
											<div class="form-group">
												<label for="email">Address:</label>
												<input class="form-control" value="<?php echo $edit_address; ?>" type="text" name="address" id="address">
											</div>
											<div class="form-group">
												<label for="email">Phone:</label>
												<input class="form-control" value="<?php echo $edit_phone; ?>" type="text" name="phone" id="phone">
											</div>
											<div class="form-group">
												<label for="email">Active:</label>
												<input class="form-control" value="<?php echo $edit_active; ?>" type="text" name="active" id="active">
											</div>
											<div class="form-group <?php echo (!empty($level_err)) ? 'has-error' : ''; ?>">
												<label for="email">User Account Level:</label>
												<input class="form-control" value="<?php echo $edit_level; ?>" type="text" name="level" id="level">
												<span class="help-block"><?php echo $level_err; ?></span>
											</div>
											<div class="inside_form_buttons">
												<button type="submit" id="submit" class="btn btn-wide btn-primary">Update User Info</button>
											</div>
										</fieldset>
										<hr>
										<p class="note"><strong>Note:</strong> You can only set User Account Level equal or less than Your Account Level.
										<br>Admin Level: 9
										<br>Corporation Manager: 8
										<br>
										<?php if(!empty($note)) echo $note; ?></p>
										
									</form>
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