<?php
/**
 * Requirements of basic system files and variables.
 */

define('ROOT_DIR', dirname(__FILE__));
define('BASE_URI', '/');

session_start();

/**
 * Database connection
 */
include(ROOT_DIR.'/includes/sys_config.php');

/* Define a maximum size (in mb.) that is allowed on each file to be uploaded. */
define('MAX_FILESIZE','2048'); 

/**
 * This values affect both validation methods (client and server side)
 * and also the maxlength value of the form fields.
 */
define('MIN_USER_CHARS', 5);
define('MAX_USER_CHARS', 60);
define('MIN_PASS_CHARS', 6);
define('MAX_PASS_CHARS', 60);

define('MIN_GENERATE_PASS_CHARS', 10);
define('MAX_GENERATE_PASS_CHARS', 20);
/*
 * Cookie expiration time (in seconds).
 * Set by default to 30 days (60*60*24*30).
 */
define('COOKIE_EXP_TIME', 60*60*24*30);

/**
 * Time (in seconds) after which the session becomes invalid.
 * Default is disabled and time is set to a huge value (1 month)
 * Need to be analyzed and adjust before enabling this function to match the real practice
 */
define('SESSION_TIMEOUT_EXPIRE', true);
$session_expire_time = 31*24*60*60; // 31 days * 24 hours * 60 minutes * 60 seconds
define('SESSION_EXPIRE_TIME', $session_expire_time);

/**
 * Define the folder where uploaded files will reside
 */
define('UPLOADED_FILES_FOLDER', ROOT_DIR.'/upload/files/');
define('UPLOADED_FILES_URL', 'upload/files/');

/** ######################################################################
 *    Other common files will be included here in the future development
 *  ######################################################################*/

/**
 * Common functions use accross the site
 */
 require_once(ROOT_DIR.'/includes/functions.php');

?>