<?php
/**
 * this library will hold the function and classes for logging functionality 
 * we will need to maintain logs of all error and important events that occur
 * logs should have a certain nomenclature so that user can upload it to 
 * cistoner secured server to check for corrections!
 * log file should to inaccesible to any one outside 
 * dependency: db library
 * 
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}

 class log
 {

 	/**
 	 * function to save log to database
 	 * @param string $log
 	 */
 	public static function saveLog($log)
 	{
 	  	$filename = __FILE__;
 	  	$time = time();
 	  	$query = mysql_query("INSERT INTO `log`(`data`, `filename`, `time`) 
 	  	VALUES ('$log','$filename','$time')");
 	  	if(!$query)
 	  	{
 	  		throw new dbError(mysql_error());
 	  		return false;
 	  	}
 	  	return true;
 	}
 	
 };
 
 ?>