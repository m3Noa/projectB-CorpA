<?php
/**
 * Define the common functions that can be accessed from anywhere.
 *
 */


/**
 * Used on header.php to check if there is an active session or valid
 * cookie before generating the content.
 * If none is found, redirect to the log in form.
 */
function check_for_session( $redirect = true )
{
	$is_logged_now = false;
	if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true) {
		$is_logged_now = true;
	}

	if ( !$is_logged_now && $redirect == true ) {
		header("location:login.php"); // " . BASE_URI . "
	}
	return $is_logged_now;
}

/**
 * Used on header.php to check if the current logged in system user has the
 * permission to view this page.
 */
function can_see_content($allowed_levels) {
	$permission = false;
	if(isset($allowed_levels)) {
		/**
		 * We are doing 2 checks.
		 * First, we look for a cookie, and if it set, then we get the associated
		 * userlevel to see if we are allowed to enter the current page.
		*/
		if (isset($_COOKIE['userlevel']) && in_array($_COOKIE['userlevel'],$allowed_levels)) {
			$permission = true;
		}
		/**
		 * The second second check looks for a session, and if found see if the user
		 * level is among those defined by the page.
		 *
		 * $allowed_levels in defined on each page before the inclusion of header.php
		*/
		if (isset($_SESSION['userlevel']) && in_array($_SESSION['userlevel'],$allowed_levels)) {
			$permission = true;
		}
		/**
		 * After the checks, if the user is allowed, continue.
		 * If not, show the "Not allowed message", then the footer, then die(); so the
		 * actual page content is not generated.
		*/
	}
	if (!$permission) {
		ob_end_clean();
		$page_title = 'Access denied';
	?>
			<!doctype html>
			<html lang="<?php echo SITE_LANG; ?>">
				<head>
					<meta charset="utf-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1">
				
					<title><?php echo $page_title;?> &raquo; Corporate Alliance</title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/jquery.1.12.4.min.js"></script>
				
					<!--[if lt IE 9]>
						<script src="<?php echo BASE_URI; ?>includes/js/html5shiv.min.js"></script>
						<script src="<?php echo BASE_URI; ?>includes/js/respond.min.js"></script>
					<![endif]-->
				</head>
				<body class="backend forbidden">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<h2><?php echo $page_title; ?></h2>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="whiteform whitebox">
									<?php
										echo "Your account type doesn't allow you to view this page. Please contact a system administrator if you need to access this function.";
									?>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>
	<?php
		die();
	}
}

/**
 * Delete from database function
 */
function dbDelete($link, $table, $condition) {
	$sql = "DELETE FROM ".$table." WHERE ".$condition;
	
	if($stmt = mysqli_prepare($link, $sql)){
	
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			return "Data has been deleted from the Database";
		} else{
			return "Oops! Something went wrong. Please try again later.";
		}
		// Close statement
		mysqli_stmt_close($stmt);       
	} else {
			return "The Deletion has not completed. Please try again later.";
		}
} 

/**
 * Create new action log
 */
function log_action($link, $action_id, $owner_id, $owner_user, $affected_file, $affected_file_name, $affected_account, $affected_account_name) {
	$sql = "INSERT INTO ca_action_logs (action_id, owner_id, owner_user, affected_file, affected_file_name, affected_account, affected_account_name) VALUES (?,?,?,?,?,?,?)";
	

	if($stmt = mysqli_prepare($link, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "iisisis", $action_id, $owner_id, $owner_user, $affected_file, $affected_file_name, $affected_account, $affected_account_name);
	
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			return "Data has been added to the Database";
		} else{
			return "Oops! Something went wrong. Please try again later.";
		}
		// Close statement
		mysqli_stmt_close($stmt);       
	} else {
			return "Unsucessful. Please try again later.";
		}
} 

/**
 * Renders an action recorded on the log.
 */
function render_log_action($params)
{
	$action = $params['action_id'];
	$timestamp = $params['timestamp'];
	$owner_id = $params['owner_id'];
	$owner_user = $params['owner_user'];
	$affected_file = $params['affected_file'];
	$affected_file_name = $params['affected_file_name'];
	$affected_account = $params['affected_account'];
	$affected_account_name = $params['affected_account_name'];

	switch ($action) {
		case 0:
			$action_ico = 'install';
			$action_text = 'System was installed';
			break;
		case 1:
			$action_ico = 'login';
			$part1 = $owner_user;
			$action_text = 'logged in to the system.';
			break;
		case 2:
			$action_ico = 'user-add';
			$part1 = $owner_user;
			$action_text = 'created the user account';
			$part2 = $affected_account_name;
			break;
		case 3:
			$action_ico = 'file-add';
			$part1 = $owner_user;
			$action_text = '(user) uploaded the file';
			$part2 = $affected_file_name;
			break;
		case 4:
			$action_ico = 'file-download';
			$part1 = $owner_user;
			$action_text = '(user) downloaded the file';
			$part2 = $affected_file_name;
			$part3 = 'assigned to:';
			$part4 = $affected_account_name;
			break;
		case 5:
			$action_ico = 'file-delete';
			$part1 = $owner_user;
			$action_text = 'deleted the file';
			$part2 = $affected_file_name;
			break;
		case 6:
			$action_ico = 'user-edit';
			$part1 = $owner_user;
			$action_text = 'edited the user';
			$part2 = $affected_account_name;
			break;
		case 7:
			$action_ico = 'group-edit';
			$part1 = $owner_user;
			$action_text = 'edited the group';
			$part2 = $affected_account_name;
			break;
		case 8:
			$action_ico = 'user-delete';
			$part1 = $owner_user;
			$action_text = 'deleted the user';
			$part2 = $affected_account_name;
			break;
		case 9:
			$action_ico = 'group-delete';
			$part1 = $owner_user;
			$action_text = 'deleted the group';
			$part2 = $affected_account_name;
			break;
		case 10:
			$action_ico = 'user-activate';
			$part1 = $owner_user;
			$action_text = 'activated the user';
			$part2 = $affected_account_name;
			break;
		case 11:
			$action_ico = 'user-deactivate';
			$part1 = $owner_user;
			$action_text = 'deactivated the user';
			$part2 = $affected_account_name;
			break;
		case 12:
			$action_ico = 'file-comment';
			$part1 = $owner_user;
			$action_text = 'posted new comment to the file';
			$part2 = $affected_file_name;
			$part3 = 'to:';
			$part4 = $affected_account_name;
			break;
		case 13:
			$action_ico = 'file-comment-delete';
			$part1 = $owner_user;
			$action_text = 'deleted a comment on the file';
			$part2 = $affected_file_name;
			$part3 = 'to:';
			$part4 = $affected_account_name;
			break;
		case 14:
			$action_ico = 'group-add';
			$part1 = $owner_user;
			$action_text = 'created the group';
			$part2 = $affected_account_name;
			break;
		case 15:
			$action_ico = 'login';
			$part1 = $owner_user;
			$action_text = 'logged in to the system.';
			break;
		case 16:
			$action_ico = 'user-activate';
			$part1 = $owner_user;
			$action_text = 'activated the user';
			$part2 = $affected_account_name;
			break;
		case 17:
			$action_ico = 'user-deactivate';
			$part1 = $owner_user;
			$action_text = 'deactivated the user';
			$part2 = $affected_account_name;
			break;
		case 18:
			$action_ico = 'logout';
			$part1 = $owner_user;
			$action_text = 'logged out of the system.';
			break;
		case 19:
			$action_ico = 'file-edit';
			$part1 = $owner_user;
			$action_text = '(user) edited the file';
			$part2 = $affected_file_name;
			break;
		case 20:
			$action_ico = 'category-add';
			$part1 = $owner_user;
			$action_text = 'created the category';
			$part2 = $affected_account_name;
			break;
		case 21:
			$action_ico = 'category-edit';
			$part1 = $owner_user;
			$action_text = 'edited the category';
			$part2 = $affected_account_name;
			break;
		case 22:
			$action_ico = 'category-delete';
			$part1 = $owner_user;
			$action_text = 'deleted the category';
			$part2 = $affected_account_name;
			break;
	}

	$date = $timestamp;

	if (!empty($part1)) { $log['1'] = $part1; }
	if (!empty($part2)) { $log['2'] = $part2; }
	if (!empty($part3)) { $log['3'] = $part3; }
	if (!empty($part4)) { $log['4'] = $part4; }
	$log['icon'] = $action_ico;
	$log['timestamp'] = $date;
	$log['text'] = $action_text;

	return $log;
}

?>