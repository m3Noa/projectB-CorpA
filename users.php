<?php
/**
 * Users Manage page for logged in system users.
 *
 */
$allowed_levels = array(9,8,7);
require_once('sys_includes.php');
$page_title = "Users Manage";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

include('includes/header.php');
include('includes/side_menu.php');

$content_title = $note = "";


// Prepare the sql statement
$sql = "SELECT * FROM ca_users";
$content_title = "All Corporation";

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
									<h4><?php echo $content_title; ?> User Profiles</h4>
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
										}</style>
<?php 
	// Execute the prepared query
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			echo '<table cellspacing="5" border="1" cellpadding="5">';
				echo "<tr>";
					echo "<th>User ID</th>";
					echo "<th>User Account Name</th>";
					echo "<th>User Display Name</th>";
					echo "<th>Email</th>";
					echo "<th>Active</th>";
					echo "<th>Action</th>";
				echo "</tr>";
			while($row = mysqli_fetch_array($result)){
			if($userlevel >= $row['level'] && ($userlevel == 8 && $usercorpid == $row['id']) || $userlevel == 9)
				$function_txt ='<a href="users-edit.php?user-id=' . $row['id']. '"><button type="button">Edit</button></a>
			<a href="users-delete.php?user-id=' . $row['id'] . '"><button type="button">Delete</button></a>';
			else 
				$function_txt = "";
				echo "<tr>";
					echo "<td>" . $row['id'] . "</td>";
					echo "<td>" . $row['user'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['email'] . "</td>";
					echo "<td>" . $row['active'] . "</td>";
					echo '<td><a href="users-details.php?user-id=' . $row['id']. '"><button type="button">View Details</button></a>'. $function_txt .'</td>';
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