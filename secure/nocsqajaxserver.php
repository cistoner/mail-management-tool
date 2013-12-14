<?php
session_start();
$checkVar = true;

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
include '../libs/accounts.php';

/**
 * connecting to mysql database
 */
dbase::start_connection();

if(isset($_POST['task']))
{
	if($_POST['task'] == "AddAccount")
	{
		if(isset($_POST['username']))
		{
			$email = $_POST['username'] ."@" .domain;
			$query = mysql_query("INSERT INTO `email_accounts`(`email`, `date`, `admin_id`) 
			VALUES ('$email','" .time() ."','" .$_SESSION['id'] ."')");
			if(!$query)
			{
				echo mysql_error();
				exit;
			}
			else
			{
				echo "
					<tr>
						<td>#</td>
						<td>$email</td>
						<td> <span class='label label-important'>just now</span> </td>
						<td> -- </td>
						<td> -- </td>
					</tr>
				";
			}
		}
	}
	else
	{
		echo "1003";
		exit;
	}
}
/**
 * Considering: database is still connected
 */
dbase::close_connection();


echo "1003";	
exit;	
?>