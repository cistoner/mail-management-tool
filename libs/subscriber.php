<?php
/**
 * this library will handle all operations related to subscribers
 * dependency: db library
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}

class subscribers
{

	/**
	 * function to return total no of subscribers
	 * return type: int
	 */
	public static function getSubscribersCount()
	{
		$query = mysql_query("SELECT count(*) FROM subscribers;");
		$row = mysql_fetch_array($query);
		return ($row[0]);
	}
};
 