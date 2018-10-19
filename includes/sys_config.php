<?php
/**
 * Database credentials. Assuming you are running MySQL
 * server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id6863564_corpa_sql');
define('DB_PASSWORD', '1z2s3e45r6f7v');
define('DB_NAME', 'id6863564_corpa');
define('TABLES_PREFIX', 'ca_');
define('SITE_LANG','en');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
/* Check connection */
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>