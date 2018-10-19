<?php
/**
 * Files Details page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "Comments";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

$fileid = 0; $title = "Comment";
$filename = $action = $note = $sql = $cmt_err = "";

if(!isset($_REQUEST["comment-id"]) && !isset($_REQUEST["poster"])){
	header("location: files-manage.php");
	exit;
} else {
	if(isset($_REQUEST["comment-id"])) {
		$cmtid = $_REQUEST['comment-id'];
		// Prepare the sql statement
		if(isset($_REQUEST["action"])) {
			switch ($_REQUEST["action"]) {
				case "quote": 
					$sql = "SELECT * FROM ca_comments WHERE id=".$cmtid;
					$action = "Post New Comment With Quote:";
					break;
				case "delete":
					$sql = "SELECT * FROM ca_comments WHERE id=".$cmtid;
					$action = "Delete Comment";
					break;
			}
		} else {
			$sql = "SELECT * FROM ca_comments WHERE id=".$cmtid;
			$action = "Edit Comment:";
		}
	}
	
	if(isset($_REQUEST["poster"])) {
		$poster = $_REQUEST["poster"];
		$cmt_sql = "SELECT * FROM ca_comments WHERE user='".$poster."'";
		$title = $poster."'s Comment Lists";
	}
}

include('includes/header.php');
include('includes/side_menu.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check user permission
	if($userlevel == 9 || $userid == $_POST['poster-id'] && $_POST['confirm'] == 1) {
		$table = 'ca_comments';
		$condition = 'id='.$_POST['cmt-id'];
		$note = dbDelete($link, $table, $condition);
	} else 
		$note = "You do not have permission to delete the comment";

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
									<h4><?php echo $title;?></h4>
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
											if(!empty($sql)) {
												// Execute the prepared query
												if($result = mysqli_query($link, $sql)){
													if(mysqli_num_rows($result) == 1){
														echo '<div class="form-group file-content">';
														$row = mysqli_fetch_array($result);
														$fileid = $row['file_id'];
														echo "<span class='field-block'> File ID: " . $fileid . " <a href='files-details.php?file-id=" . $fileid . "'><b>(Link to File)</b></a></span>";
														echo "<span class='field-block'> Poster: " . $row['user'] . "</span>";
														echo "<span class='field-block'> Posteded Date: " . $row['timestamp'] . "</span>";
														echo "<span class='field-block'> Rating: " . $row['rating'] . "</span>";
														$comt_content = str_replace("\n","<br>", $row['comment']);
														if($_REQUEST["action"] == "quote") $comt_content = $row['user']." Wrote:\n[ ".$comt_content ." ]\n";
														echo "<span class='field-block'> Comment:</span><div class='desc'>" . $comt_content . "</div>";
														echo "</div>";
														// Free result set
														mysqli_free_result($result);
													} else{
														$note = "No records matching your query were found.";
													}
												} else {
													$note = "ERROR: Could not able to execute $sql. " . mysqli_error($link);
												}
											}
											
											if(!isset($_REQUEST["action"]) || $_REQUEST["action"] != "delete") {
												if(!isset($_REQUEST["poster"])) {
													// Include comment editor
													include('includes/post-comment.php');
													// get file comment
													$cmt_sql = "SELECT * FROM ca_comments WHERE file_id=".$fileid;
													echo '<div class="form-group file-content">';													
														echo '<h4>Comments</h4>';
														echo '<hr>';
												} else {
													echo '<div class="form-group file-content">';
												}
												// Execute the prepared query										
												if($comments = mysqli_query($link, $cmt_sql)){
													if(mysqli_num_rows($comments) > 0){
														while($row = mysqli_fetch_array($comments)){
														echo '<table cellspacing="5" border="1" cellpadding="5" width="100%">';
															echo "<tr>";
																echo "<th>User</th>";
																echo "<th>Comment <span class='small-note'><a href='files-details.php?file-id=" . $row['file_id'] . "'>(Posted Date: ". $row['timestamp'] . ")</a></span></th>";
																echo "<th>Rating</th>";
															echo "</tr>";
															echo "<tr>";
																echo "<td>" . $row['user'] . "</td>";
																echo "<td>" . $row['comment'] . "</td>";
																echo "<td>" . $row['rating'] . "</td>";
															echo "</tr>";
														echo "</table>";
														echo '<hr>';													
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
											} else {?>
												<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
													<fieldset>
														<div class="inside_form_buttons">
															<input type="hidden" id="cmt-id" name="cmt-id" value="<?php echo $cmtid; ?>">
															<input type="hidden" id="poster-id" name="poster-id" value="<?php echo $posterid; ?>">
															<input type="hidden" id="confirm" name="confirm" value="1">
															<button type="submit" id="submit" class="btn btn-wide btn-primary">Confirm Delete</button>
														</div>
													</fieldset>
													<hr>
													<p class="note"><?php echo $note; ?></p>
													
												</form>
	
											<?php
											}

											
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