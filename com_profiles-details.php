<?php
/**
 * Corporation Profiles Details page for logged in system users.
 * 
 * TO DO: Change the UI to display profile photo if exists
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "Corporation Profile Details";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

$filename = $filedesc = $fileUrl = "";
$filename_err = $fileDesc_err = $sql_err = $cmt_err = $note = "";

if(!isset($_REQUEST["corp-id"])){
	header("location: com_profiles.php");
	exit;
} else {
	$corpid = $_REQUEST['corp-id'];
	// Prepare the sql statement
	$sql = "SELECT * FROM ca_corps WHERE id=".$corpid;
}

include('includes/header.php');
include('includes/side_menu.php');

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
														$function_txt ='<a href="com_profiles-edit.php?corp-id=' . $row['id'] . '"><button type="button">Edit Profile</button></a>
													<a href="com_profiles-delete.php?corp-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
													else 
														$function_txt = "";
													
													echo "<span class='field-block'> Corporation Name: " . $row['name'] . "</span>";
													echo "<span class='field-block'> Created By: " . $row['created_by'] . "</span>";
													echo "<span class='field-block'> Created Date: " . $row['timestamp'] . "</span>";
													echo "<span class='field-block'> Address: " . $row['address'] . "</span>";
													echo "<span class='field-block'> Phone Number: " . $row['phone'] . "</span>";
													$row['description'] = str_replace("\n","<br>", $row['description']);
													echo "<span class='field-block'> Description:</span><div class='desc'>" . $row['description'] . "</div>";
													echo '<span class="field-block"> <a href="files-manage.php?corp-id=' . $row['id'] . '"><button type="button">Show  Corporation Files</button></a>'. $function_txt .'</span>';
																								
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