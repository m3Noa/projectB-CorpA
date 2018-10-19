<?php
/**
 * User Deletion page for logged in system users.
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "User Deletion";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');

$edit_corpid = $edit_username = $edit_fileUrl = $edit_userid = $edit_realname = $note = "";

if(isset($_REQUEST['user-id'])) {
	// Prepare the sql statement
	$sql = "SELECT * FROM ca_users WHERE id = ".urldecode($_REQUEST["user-id"]);

	// Execute the prepared query
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result);
			$edit_userid = $row['id'];
			$edit_username = $row['user'];
			$edit_realname = $row['name'];
			$edit_corpid = $row['corp_id'];
			$edit_fileUrl = $row['avatar'];
			
			// Free result set
			mysqli_free_result($result);
		} else {
			$note = "No records matching your query were found.";
		}
	} else {
		$note = "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
}
	
if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Check user permission
	if($userlevel == 9 || ($userlevel == 8 && $usercorpid == $_POST['corp-id']) && $_POST['confirm'] == 1 && $username != $_POST['username']) {
		$table = 'ca_users';
		$condition = 'id='.$_POST['user-id'];
		$note = dbDelete($link, $table, $condition);
		if(!empty($edit_fileUrl)) unlink($edit_fileUrl);
	} else 
		$note = "You do not have permission to delete the file";

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
									<h4>Delete User Account</h4>
									<div class="widget_int">
										<div>
										<!--############ Main Content ############-->
										<style>
										td, th {
											padding: 10px;
										}
										th {
											background: #179292;
											color: #eee;
										}
										.form-group span {
											font-size: 12px;
											display: block;
										}
										</style>
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
												<fieldset>
													<div class="form-group">
														<input type="hidden" id="user-id" name="user-id" value="<?php echo $edit_userid; ?>">
														<input type="hidden" id="username" name="username" value="<?php echo $edit_username; ?>">
														<input type="hidden" id="corp-id" name="corp-id" value="<?php echo $edit_corpid; ?>">
														<input type="hidden" id="file-url" name="file-url" value="<?php echo $edit_fileUrl; ?>">
														<input type="hidden" id="confirm" name="confirm" value="1">
														<span>Username: <?php echo $edit_username; ?></span> 
														<span>Display Name: <?php echo $edit_realname; ?></span>
														<span>Corporation ID: <?php echo $edit_corpid; ?></span>
													</div>
													<div class="inside_form_buttons">
														<button type="submit" id="submit" class="btn btn-wide btn-primary">Confirm Delete</button>
													</div>
												</fieldset>
												<hr>
												<p class="note"><?php echo $note; ?></p>
												
											</form>

										<!--############ /End Main Content ############-->
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