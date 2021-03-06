<?php
/**
 * Files Details page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "Files Details";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

$fName = $fDesc = $fUrl = "";
$filename_err = $fileDesc_err = $sql_err = $note = $owner = "";

include('includes/header.php');
include('includes/side_menu.php');

// Prepare the sql statement
$sql = "SELECT * FROM ca_files";

// Select only a specific Corporation
if(isset($_REQUEST["corp-id"])) {
	$sql .= " WHERE corp_id = ". $_REQUEST['corp-id'];
	$owner = "Corporation ". $_REQUEST['corp-id'] . "'s ";
}
// Select files from only a specific user
else 
	if(isset($_REQUEST["uploader"])) {
		$sql .= " WHERE uploader = '". $_REQUEST['uploader']."'";
		$owner = "User ". $_REQUEST['uploader'] . "'s ";
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
									<h4>Uploaded Files</h4>
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
										.small-note {
											font-size: 9px;
											display: block;
										}
										</style>
										<?php 
											// Execute the prepared query
											if($result = mysqli_query($link, $sql)){
												if(mysqli_num_rows($result) > 0){
													echo '<table cellspacing="5" border="1" cellpadding="5">';
														echo "<tr>";
															echo "<th>File ID</th>";
															echo "<th>File Name</th>";
															echo "<th>File Description</th>";
															echo "<th>Uploader</th>";
															//echo "<th>File URL</th>";
															echo "<th>Upload Date</th>";
															echo "<th>Action</th>";
														echo "</tr>";
													while($row = mysqli_fetch_array($result)){
													if(($userlevel == 8 && $usercorpid == $row['corp_id']) || $userlevel == 9) 
														$function_txt ='<a href="files-edit.php?file-id=' . $row['id'] . '"><button type="button">Edit</button></a>
													<a href="files-delete.php?file-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
													else 
														$function_txt = "";
														echo "<tr>";
															echo "<td>" . $row['id'] . "</td>";
															echo "<td>" . $row['filename'] . "</td>";
															$tempDesc = (strlen($row['description']) > 50) ? substr($row['description'], 0, 50) : $row['description'];
															echo "<td>" . $tempDesc . "...</td>";
															echo "<td>" . $row['uploader'] . "<span class='small-note'>(Corp ID: ". $row['corp_id'] .")</span></td>";
															//echo "<td>" . $row['url'] . "</td>";
															echo "<td>" . $row['timestamp'] . "</td>";
															echo '<td><a href="files-details.php?file-id=' . $row['id'] .'"><button type="button">View Details</button></a>
															<a href="files-download.php?file-id=' . $row['id'] . '&fileUrl='. $row['url'] . '"><button type="button">Download</button></a>'. $function_txt .'</td>';
														echo "</tr>";
													}
													echo "</table>";
													// Free result set
													mysqli_free_result($result);
												} else{
													echo "No records matching your query were found.";
												}
											} else{
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