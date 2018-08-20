<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
 
// Include file
require_once "includes/connect.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, user, password FROM ca_users WHERE user = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: home.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered is invalid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
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
				<span class="navbar-brand">Corporate Alliance</span>
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
						<div class="white-box">
							<div class="white-box-interior">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="login_admin" method="post" id="login_form">
									<fieldset>
										<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
											<label for="username">Username / E-mail</label>
											<input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control" autofocus />
											<span class="help-block"><?php echo $username_err; ?></span>
										</div>

										<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
											<label for="password">Password</label>
											<input type="password" name="password" id="password" class="form-control" />
											<span class="help-block"><?php echo $password_err; ?></span>
										</div>

										<div class="inside_form_buttons">
											<button type="submit" id="submit" class="btn btn-wide btn-primary">Log in</button>
										</div>

									</fieldset>
								</form>

								<div class="login_form_links">
									<p id="reset_pass_link">Forgot your password? <a href="#">Set up a new one.</a></p>
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
		<script src="includes/js/jen/jen.js"></script>
		<script src="includes/js/js.cookie.js"></script>
		<script src="includes/js/main.js"></script>
		<script src="includes/js/js.functions.php"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script src="includes/js/chosen/chosen.jquery.min.js"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

	</body>
</html>
