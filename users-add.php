<?php
/**
 * Adding new user account - only for admin and manager users
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "New User Account";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');

$new_username = $new_password = $new_realname = $new_confirm_password = "";
$username_err = $password_err = $realname_err = $confirm_password_err = $note = "";
$new_level = $new_corpid = 0;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(strlen(trim($_POST["username"])) < MIN_USER_CHARS){
        $username_err = "Username must have atleast ".MIN_USER_CHARS." characters.";
    }
	else{
        // Prepare a select statement
        $sql = "SELECT id FROM ca_users WHERE user = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $new_username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
			// Close statement
			mysqli_stmt_close($stmt);       
		}
         
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < MIN_PASS_CHARS){
        $password_err = "Password must have atleast ".MIN_PASS_CHARS." characters.";
    } else{
        $new_password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $new_confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($new_password != $new_confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	
	// Validate realname
	// For now doing nothing, assign username to realname if empty
	if(isset($_POST["realname"])) $new_realname = $_POST["realname"];
	else $new_realname = $new_username;
	
	// Validate user level and corporation id
	if(isset($_POST["level"])) {
		$new_level = $_POST["level"];
		if($new_level > $userlevel) $level_err = "Cannot assign user level higher than your own level.";
	}

	if($userlevel == 9) {
		if(isset($_POST["corp-id"])) $new_corpid = $_POST["corp-id"];
	} else 
		$new_corpid = $usercorpid; // Corp Manager can only add new user that belong to the same Corporation
	
	
	
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ca_users (user, password, name, level, created_by, corp_id) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisi", $param_username, $param_password, $param_realname, $param_level, $param_creator, $param_corpid);
            
            // Set parameters
            $param_username = $new_username;
			$param_realname = $new_realname;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
			$param_level = $new_level;
			$param_creator = $username;
			$param_corpid = $new_corpid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Show success message
                $note = "Successfully Added new user.";
				// Log Action
				log_action($link, 2, $userid, $username, 0, "", 0, $new_username);
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
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

				<div class="row">
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget">
										<h4>Add New User</h4>
									<div class="widget_int">
										<p>Please fill this form to create an account.</p>
										<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
											<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
												<label>Username</label>
												<input type="text" name="username" class="form-control" value="<?php echo $new_username; ?>">
												<span class="help-block"><?php echo $username_err; ?></span>
											</div>    
											<div class="form-group <?php echo (!empty($realname_err)) ? 'has-error' : ''; ?>">
												<label>Contact Name</label>
												<input type="text" name="realname" class="form-control" value="<?php echo $new_realname; ?>">
												<span class="help-block"><?php echo $realname_err; ?></span>
											</div>    
											<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
												<label>Password</label>
												<input type="password" name="password" class="form-control" value="<?php echo $new_password; ?>">
												<span class="help-block"><?php echo $password_err; ?></span>
											</div>
											<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
												<label>Confirm Password</label>
												<input type="password" name="confirm_password" class="form-control" value="<?php echo $new_confirm_password; ?>">
												<span class="help-block"><?php echo $confirm_password_err; ?></span>
											</div>
											<div class="form-group <?php echo (!empty($realname_err)) ? 'has-error' : ''; ?>">
												<label>User Account Level</label>
												<input type="text" name="level" class="form-control" value="<?php echo $new_level; ?>">
												<span class="help-block"><?php if(!empty($level_err)) echo $level_err; ?></span>
											</div>
											<?php if($userlevel == 9) {?>
											<div class="form-group <?php echo (!empty($realname_err)) ? 'has-error' : ''; ?>">
												<label>Corporation</label>
												<input type="text" name="corp-id" class="form-control" value="<?php echo $new_corpid; ?>">
												<span class="help-block"><?php echo $realname_err; ?></span>
											</div>
											<?php }?>
											<div class="form-group">
												<input type="submit" class="btn btn-primary" value="Submit">
												<input type="reset" class="btn btn-default" value="Reset">
											</div>
											<p><?php if(!empty($note)) echo $note;?></p>
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