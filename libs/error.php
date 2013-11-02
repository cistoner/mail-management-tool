<?php
/**
 * this library will handle all error handling operations
 * libraries will extend Exception class to create specific exceptions
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}
 
/**
 * exception handler for any database query error
 */
class dbError extends Exception { };

?>