<?php
/**
 * Files Details page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "Action Logs";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

$fName = $fDesc = $fUrl = "";
$filename_err = $fileDesc_err = $sql_err = $cmt_err = $note = "";

include('includes/header.php');
include('includes/side_menu.php');

// Prepare the sql statement
$sql = "SELECT * FROM ca_action_logs";
if($userlevel < 9) $sql.=" WHERE owner_id=".$userid." OR action_id IN (3,4,6,12)";
$sql .=" ORDER BY timestamp DESC"; 

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
													echo '<ul class="activities_log">';
													while($row = mysqli_fetch_array($result)){
														// TO DO: add delete log function for admin
														/*if(($userlevel == 8 && $usercorpid == $row['corp_id']) || $userlevel == 9) 
															$function_txt ='<a href="files-edit.php?file-id=' . $row['id'] . '"><button type="button">Edit</button></a>
														<a href="files-delete.php?file-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
														else */
															$function_txt = "";
															$log = render_log_action($row);

															echo '<li>';
															echo '	<div class="log_ico">
																	<img alt="Action icon" src="img/log_icons/'.$log['icon'].'.png">';
															echo '	</div>
																<div class="home_log_text">
																	<div class="date">'.$log['timestamp'].'</div>';
															if(!empty($log['2'])) $target = ($log['2']);
															else $target = "";
															echo '		<div class="action">
																		<span>'.$log['1'].'</span> '.$log['text'].' <span>'.$target.'</span>';
															// TO DO: add more detail log (part 3 & 4)
															
															echo '		</div>
																</div>
															</li>';
																		
													}
													echo '</ul>';
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