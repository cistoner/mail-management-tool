<?php
/**
 * Authentication page for ajax-server
 */

if(!isset($checkVar))
{
    header("location: ../../index.php");
    exit;
}

/**
 * checking if session data are set
 */
if(!isset($_SESSION[username_key]) || !isset($_SESSION[password_key]) || !isset($_SESSION['id']))
{
	echo -1;
	exit;
}
dbase::start_connection();
$status = -1;
try 
{
	$status = login::authenticate($_SESSION[username_key], $_SESSION[password_key]);
} 
catch(dbError $ex)
{
	log::saveLog("[ajaxserver] DB_ERROR IN AUTHENTICATION: " .$ex->getMessage());
	dbase::close_connection();
	echo -1;
	exit;
}
catch (InvalidUsername $ex)
{
	log::saveLog("[ajaxserver] INVALID CAHRS IN USERNAME - IN_SESSION [SEVERE]");
	dbase::close_connection();	
	echo -1;
	exit;	
}
catch (InvalidPassword $ex)
{
	log::saveLog("[ajaxserver] INVALID CAHRS IN PASSWORD - IN_SESSION [SEVERE]");
	dbase::close_connection();	
	echo -1;
	exit;
}

/**
 * if the session username and password are correct then 
 * status returned must be 2
 */
if($status != 2)
{
	log::saveLog("[ajaxserver] INVALID CREDENTIALS IN SESSION - [SEVERE]");
	dbase::close_connection();
	echo -1;
	exit;
}
else 
{
	/**
	 * this means successful login
	 */
	$query = mysql_query("SELECT last_activity FROM admin WHERE id = '" .$_SESSION['id'] ."';");
	if(!$query)
	{
		/*
		 * for debugging purpose
		 */
		echo mysql_error();
		dbase::close_connection();	
		exit;
	}
	if(!mysql_num_rows($query))
	{
		/**
		 * this case shall never happer other than when user has been deleted
		 */
		unset($_SESSION['id']);
		session_destroy();
		log::saveLog("[ajaxserver] USER DELETED WHEN LOGGED IN ");
		dbase::close_connection();	
		echo -1;
		exit;	
	}
	$row = mysql_fetch_array($query);	
	$lastActivity = $row[0];
	
	/**
	 * this means that the user didnot do any activity for last 
	 * few minutes hence session expires
	 */
	if( time() - $lastActivity > login::$sessionTimeout )
	{
		log::saveLog("[ajaxserver] SESSION EXPIRED FOR USER ID " .$_SESSION['id']);
		unset($_SESSION['id']);
		unset($_SESSION[username_key]);
		unset($_SESSION[password_key]);
		session_destroy();
		dbase::close_connection();	
		echo -1;
		exit;	
	}
	
	/**
	 * update last user activity
	 */
	mysql_query("UPDATE admin SET last_activity = '" .time() ."' WHERE id = '" .$_SESSION['id'] ."';");
	
	/**
	 * code to get access from db
	 * and store it to class object
	 */
	$accessObj = new access($_SESSION['id']);
	
	/*
	 * ignoring the noacess case for now
	 */
	try
	{
		$accessObj->getAccessFromDB();
	}
	catch(noAccess $ex)
	{
		/* do nothig for now */		
	}
}

?>