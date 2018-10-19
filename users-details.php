<?php
/**
 * Files Details page for logged in system users.
 *
 * TO DO: Change the UI to display profile photo if exists
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "User Profile Details";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');

if(!isset($_REQUEST["user-id"])){
	header("location: users.php");
	exit;
} else {
	$view_userid = $_REQUEST['user-id'];
	// Prepare the sql statement
	$sql = "SELECT * FROM ca_users WHERE id=".$view_userid;
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
									<h4>Corporation Profile Details</h4>
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
										.field-block {
											font-size: 14px;
											display: block;
											padding: 10px;
										}
										.desc {
											text-align: justify;
											padding: 10px 20px;
											border: 1px solid #ccc;
										}
										</style>
										<?php 
											// Execute the prepared query
											if($result = mysqli_query($link, $sql)){
												if(mysqli_num_rows($result) == 1){
													echo '<div class="form-group file-content">';
													$row = mysqli_fetch_array($result);
													if(($userlevel == 8 && $usercorpid == $row['corp_id']) || $userlevel == 9) 
														$function_txt ='<a href="users-edit.php?user-id=' . $row['id'] . '"><button type="button">Edit Profile</button></a>
													<a href="users-delete.php?user-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
													else 
														$function_txt = "";
													
													echo "<span class='field-block'> Account Name: " . $row['user'] . "</span>";
													echo "<span class='field-block'> Display Name: " . $row['name'] . "</span>";
													echo "<span class='field-block'> Created By: " . $row['created_by'] . "</span>";
													echo "<span class='field-block'> Created Date: " . $row['timestamp'] . "</span>";
													echo "<span class='field-block'> Address: " . $row['address'] . "</span>";
													echo "<span class='field-block'> Phone: " . $row['phone'] . "</span>";
													echo "<span class='field-block'> Email: " . $row['email'] . "</span>";
													echo "<span class='field-block'> Corporation ID: " . $row['corp_id'] . "</span>";
													echo '<span class="field-block"> <a href="files-manage.php?uploader=' . $row['user'] . '"><button type="button">Show  User Files</button></a> <a href="comments.php?poster=' . $row['user'] . '"><button type="button">Show  User Comments</button></a>'. $function_txt .'</span>';
																								
													echo "</div>";
													// Free result set
													mysqli_free_result($result);
												} else{
													echo "No records matching your query were found.";
												}
											} else {
												echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
											}										
										?>
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