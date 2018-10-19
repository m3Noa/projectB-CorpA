<?php
require_once('sys_includes.php');
$page_title = "Users Manage";

// Define variables and initialize with empty values
if(!empty($_SESSION["id"])) $userid = $_SESSION["id"];
if(!empty($_SESSION["username"])) $username = $_SESSION["username"];
if(!empty($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
if(!empty($_SESSION["usercorpid"])) $usercorpid = $_SESSION["usercorpid"];

if(isset($_REQUEST["file-id"]) && isset($_REQUEST["fileUrl"])){
    // Get parameters
    $fileid = urldecode($_REQUEST["file-id"]); // Decode URL-encoded string
    $filepath = urldecode($_REQUEST["fileUrl"]);
    
    // Process download
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
		// Log action
		log_action($link, 4, $userid, $username, $fileid, "", 0, "");
		echo "file downloaded successfully.";
        exit;
    } else {
		echo "Error: File does not exist!";
		
	}
}
?>