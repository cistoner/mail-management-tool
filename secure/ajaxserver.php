<?php
session_start();
$checkVar = true;

/**
 * if CSQ has not been sent then user should be sent
 * an error message
 */
if(!isset($_POST['csq']))
{
    if(isset($_POST['retrieve']) && $_POST['retrieve'] == 'true')
	{
		/** for normal ajax requests **/
		include 'subajaxserver.php';
		exit;
	}
	echo "1001: Insufficient parameters!";
	exit;
}

/**
 * Including all required files and libraries
 * that might be required for operation
 */
include '../config/config.php';
include '../libs/error.php';
include '../libs/db.php';
include '../libs/log.php';
include '../libs/access.php';
include '../libs/login.php';

/**
 * Code to authenticate the admin
 * from existing data in session
 */
include 'authentication.php';

/**
 * including other libraries
 * now that user is authenticated
 */

include '../libs/subscriber.php';
include '../libs/groups.php';
include '../libs/mail.php';


/**
 * Considering: database is still connected
 */

/**
 * including file to do all CSQ operation
 * we are sure CSQ exists in this page as
 * a $_POST data
 */
include 'csqserver.php';
dbase::close_connection();
	
	
	


?>