<?php
/**
 * Reset Password page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7,0);
require_once('sys_includes.php');
$page_title = "Reset Password";
 
// Define variables and initialize with empty values
$username = $password = $realname = $confirm_password = "";
$username_err = $password_err = $realname_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(strlen(trim($_POST["username"])) < MIN_USER_CHARS){
        $username_err = "Password must have atleast ".MIN_USER_CHARS." characters.";
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
                    $username = trim($_POST["username"]);
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
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	
	// Validate realname
	// For now doing nothing, assign username to realname if empty
	if(isset($_POST["realname"])) $realname = $_POST["realname"];
	else $realname = $username;
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ca_users (user, password, name, level) VALUES (?, ?, ?, 7)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_realname);
            
            // Set parameters
            $param_username = $username;
			$param_realname = $realname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				log_action($link, 2, 0, $username, 0, "", 0, "");
                // Redirect to login page
                header("location: login.php");
				exit;
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
 
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in &raquo; Corporate Alliance</title>
	<script src="includes/js/jquery.1.12.4.min.js"></script>
	<link rel="stylesheet" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" />
	<link rel="stylesheet" media="all" type="text/css" href="assets/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" media="all" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" media="all" type="text/css" href="css/main.min.css" />
</head>

<body class="index login backend">
	<div class="container-custom">
		<header id="header" class="navbar navbar-static-top navbar-fixed-top header_unlogged">
			<div class="navbar-header text-center">
				<span class="navbar-brand"><a href="index.php" style="color: white; font-weight: bold;">Corporate Alliance</a></span>
			</div>
		</header>

		<div class="main_content_unlogged">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-4 col-lg-offset-4">
						<div class="row">
							<div class="col-xs-12 branding_unlogged">
								<img src="img/style/logo/logo.png" alt="Corporate Alliance" />
							</div>
						</div>
						<div class="wrapper">
							<h2>Sign Up</h2>
							<p>Please fill this form to create an account.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
									<label>Username</label>
									<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
									<span class="help-block"><?php echo $username_err; ?></span>
								</div>    
								<div class="form-group <?php echo (!empty($realname_err)) ? 'has-error' : ''; ?>">
									<label>Contact Name</label>
									<input type="text" name="realname" class="form-control" value="<?php echo $realname; ?>">
									<span class="help-block"><?php echo $realname_err; ?></span>
								</div>    
								<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
									<label>Password</label>
									<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
									<span class="help-block"><?php echo $password_err; ?></span>
								</div>
								<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
									<label>Confirm Password</label>
									<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
									<span class="help-block"><?php echo $confirm_password_err; ?></span>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Submit">
									<input type="reset" class="btn btn-default" value="Reset">
								</div>
								<p>Already have an account? <a href="login.php">Login here</a>.</p>
							</form>
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
		<script src="includes/js/jen/jen.js"></script>
		<script src="includes/js/js.cookie.js"></script>
		<script src="includes/js/main.js"></script>
		<script src="includes/js/js.functions.php"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script src="includes/js/chosen/chosen.jquery.min.js"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

<?php
// Close connection
mysqli_close($link);
										
?>
</body>
</html>