<?php
// Prepare the sql statement
$sql_rpanel = "SELECT * FROM ca_action_logs";
if($userlevel < 9) $sql_rpanel .=" WHERE owner_id=".$userid." OR action_id IN (3,4,6,12)";
$sql_rpanel .=" ORDER BY timestamp DESC LIMIT 10"; 
?>
					<!-- Action Log -->
					<div class="col-sm-4 container_widget_actions_log">
						<div class="widget">
							<h4>Recent activites</h4>
							<div class="widget_int">
								<!--div class="log_change_action">
									<a class="log_action btn btn-sm btn-default btn-inverse" href="#">
												All activities							</a>
									<a class="log_action btn btn-sm btn-default" href="#">
												Logins							</a>
									<a class="log_action btn btn-sm btn-default" href="#">
												Downloads							</a>
								</div-->
										<?php 
											// Execute the prepared query
											if($result = mysqli_query($link, $sql_rpanel)){
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
												echo "ERROR: Could not able to execute the sql command. " . mysqli_error($link);
											}
										?>
								<div class="view_full_log">
									<a class="btn btn-primary btn-wide" href="actions-log.php">View all</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Action Log -->