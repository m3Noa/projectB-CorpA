<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
} else {
	// redirect the user to the login page if not
	header("location: login.php");
    exit;
}

// TO DO: This page should show a landing page with the main menu on top and all public contents.
?>