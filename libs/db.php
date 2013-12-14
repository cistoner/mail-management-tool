<?php
/*
 * this library will handle all database operations 
 * including features to connect and disconnect
 * we shall be using mysql_ functions instead of mysqli_ functions for now
 * shall change later 
 * @author: minhaz
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}

/**
 * class dbase: handles database connection and disconnecion operation
 * uses static functions and mysql_ fucntions
 * expects config page to be included
*/

class dbase{
	public static $con;
	public static function start_connection()
	{
		self::$con = mysql_connect(HOST,USER,PASSWORD);
		mysql_select_db(_DB_MAIN,self::$con);
	}
	public static function close_connection()
	{
		if(isset(self::$con))
		{
			mysql_close(self::$con);
		}
	}
};


?>