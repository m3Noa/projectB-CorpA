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

$filename = $filedesc = $fileUrl = "";
$filename_err = $fileDesc_err = $sql_err = $cmt_err = $note = "";

if(!isset($_REQUEST["file-id"])){
	header("location: file-manage.php");
	exit;
} else {
	$fileid = $_REQUEST['file-id'];
	// Prepare the sql statement
	$sql = "SELECT * FROM ca_files WHERE id=".$fileid;
	$cmt_sql = "SELECT * FROM ca_comments WHERE file_id=".$fileid;
}

include('includes/header.php');
include('includes/side_menu.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['content'])) {
		if($_POST['file-id']>0) $fileid = $_POST['file-id'];
		$comment = $_POST['content'];
		$rating = ($_POST['rating'])? $_POST['rating']: 0 ;
		$filename = $_POST['filename'];
		// Prepare the insert statement
		$sql_post = "INSERT INTO ca_comments (user, file_id, rating, comment) VALUES (?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($link, $sql_post)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "siis", $username, $fileid, $rating, $comment);
								
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				$note = "Your comment was posted successfully.";
				// Log action
				log_action($link, 12, $userid, $username, $fileid, $filename, 0, "");
			} else {
				$sql_err =  "Something went wrong. Please try again later.";
			}
		}
		 
		// Close statement
		mysqli_stmt_close($stmt);

	} else $cmt_err = "Please make sure to write something on your comment before posting it.";
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
									<h4>File Details</h4>
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
														$function_txt ='<a href="files-edit.php?file-id=' . $row['id'] . '"><button type="button">Edit</button></a>
													<a href="files-delete.php?file-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
													else 
														$function_txt = "";
													$filename = $row['filename'];
													echo "<span class='field-block'> File Name: " . $filename . "</span>";
													echo "<span class='field-block'> Uploader: " . $row['uploader'] . "</span>";
													echo "<span class='field-block'> Uploaded Date: " . $row['timestamp'] . "</span>";
													$row['description'] = str_replace("\n","<br>", $row['description']);
													echo "<span class='field-block'> File Description:</span><div class='desc'>" . $row['description'] . "</div>";
													echo '<span class="field-block"> <a href="files-download.php?file-id=' . $row['id'] . '&fileUrl='. $row['url'] . '"><button type="button">Download</button></a>'. $function_txt .'</span>';
																								
													echo "</div>";
													// Free result set
													mysqli_free_result($result);
												} else{
													$note = "No records matching your query were found.";
												}
											} else {
												$note = "ERROR: Could not able to execute $sql. " . mysqli_error($link);
											}
											
											// Include comment editor
											include('includes/post-comment.php');
											
											// get file comment
											// Execute the prepared query
											echo '<div class="form-group file-content">';
												echo '<h4>Comments</h4>';
												echo '<hr>';
											
											if($comments = mysqli_query($link, $cmt_sql)){
												if(mysqli_num_rows($comments) > 0){
													while($row = mysqli_fetch_array($comments)){
													if(($userlevel == 8 && $usercorpid == $row['corp_id']) || $userlevel == 9 || $username == $row['user']) 
														$function_txt ='<a href="comments.php?comment-id=' . $row['id'] . '"><button type="button">Edit</button></a>
													<a href="comments.php?comment-id=' . $row['id'] . '&action=delete"><button type="button">Delete</button></a>';
													else 
														$function_txt = "";
													echo '<table cellspacing="5" border="1" cellpadding="5" width="100%">';
														echo "<tr>";
															echo "<th>User</th>";
															echo "<th>Comment <span class='small-note'>(Posted Date: ". $row['timestamp'] . ")</span></th>";
															echo "<th>Rating</th>";
														echo "</tr>";
														echo "<tr>";
															echo "<td>" . $row['user'] . "</td>";
															echo "<td>" . $row['comment'] . "</td>";
															echo "<td>" . $row['rating'] . "</td>";
														echo "</tr>";
													echo "</table>";
													echo '<div style="float: right;"><a href="comments.php?comment-id=' . $row['id'] .'&action=quote"><button type="button">Quote</button></a>
															'. $function_txt .'</div>
															<hr>';													
													}

													// Free result set
													mysqli_free_result($comments);
												} else {
													echo "No records matching your query were found.";
												}
											} else{
												echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
											}
											echo '</div>';

											
											// Close connection
											//mysqli_close($link);
										
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