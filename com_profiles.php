<?php
/**
 * Upload page for logged in system users.
 *
 */
$allowed_levels = array(9,8);
require_once('sys_includes.php');
$page_title = "Corporation Profiles";

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
									<h4>Welcome Board </h4>
									<div class="widget_int">
										<p>This feature is still in development. Please come back later!</p>
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
</body>
</html>