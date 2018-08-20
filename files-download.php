<?php
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
		echo "file downloaded successfully.";
        exit;
    } else {
		echo "Error: File does not exist!";
		
	}
}
?>