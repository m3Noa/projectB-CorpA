<?php
/**
 * Reset Password page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7,0);
require_once('sys_includes.php');
$page_title = "Reset Password";

// Define variables and initialize with empty values
$username = $_SESSION["username"];
$userlevel = $_SESSION["userlevel"];
$usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget">
									<h4>Reset Password</h4>
									<div class="widget_int">
										<p>Please fill out this form to reset your password.</p>
										<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
											<div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
												<label>New Password</label>
												<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
												<span class="help-block"><?php echo $new_password_err; ?></span>
											</div>
											<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
												<label>Confirm Password</label>
												<input type="password" name="confirm_password" class="form-control">
												<span class="help-block"><?php echo $confirm_password_err; ?></span>
											</div>
											<div class="form-group">
												<input type="submit" class="btn btn-primary" value="Submit">
												<a class="btn btn-link" href="home.php">Cancel</a>
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