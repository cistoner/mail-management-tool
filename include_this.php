<?php 
/**
 * this page shall be included in every page so that it 
 * will have all authentication code and required libraries 
 * those libraries which doesnot serve as a standard library
 * shall not be included here ans so it as to be included in specific page
 * it is needed
 */
session_start();
$checkVar = true;

/**
 * session variable to store last visited page
 */
$tempArray = explode("/",$_SERVER['PHP_SELF']);
$at = str_replace(".php","",$tempArray[count($tempArray)-1]);
unset($tmpArray);

/**
 * include important libraries here
 */
include 'config/config.php';
if(!isset($_SESSION[username_key]) || !isset($_SESSION[password_key]) || !isset($_SESSION['id']))
{
	header("location: login.php?message=session+expired");
	exit;
}
include 'libs/error.php';
include 'libs/db.php';
include 'libs/log.php';
include 'libs/login.php';
include 'libs/access.php';

dbase::start_connection();
$status = -1;
try 
{
	$status = login::authenticate($_SESSION[username_key], $_SESSION[password_key]);
} 
catch(dbError $ex)
{
	log::saveLog("DB_ERROR IN AUTHENTICATION: " .$ex->getMessage());
	dbase::close_connection();
	header("location: login.php?message=session+expired&success=false");
	exit;
}
catch (InvalidUsername $ex)
{
	log::saveLog("INVALID CAHRS IN USERNAME - IN_SESSION [SEVERE]");
	dbase::close_connection();	
	header("location: login.php?message=invalid+charecters+in+username&success=false");
	exit;	
}
catch (InvalidPassword $ex)
{
	log::saveLog("INVALID CAHRS IN PASSWORD - IN_SESSION [SEVERE]");
	dbase::close_connection();	
	header("location: login.php?message=invalid+charecters+in+password&success=false");
	exit;
}

/**
 * if the session username and password are correct then 
 * status returned must be 2
 */
if($status != 2)
{
	log::saveLog("INVALID CREDENTIALS IN SESSION - [SEVERE]");
	dbase::close_connection();
	header("location: login.php?message=session+expired&success=false");
	exit;
}
else 
{
	/**
	 * this means sucessful login
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
		log::saveLog("USER DELETED WHEN LOGGED IN ");
		dbase::close_connection();	
		
		header("location: login.php?message=user+does+not+exist+anymore&success=false");
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
		log::saveLog("SESSION EXPIRED FOR USER ID " .$_SESSION['id']);
		unset($_SESSION['id']);
		unset($_SESSION[username_key]);
		unset($_SESSION[password_key]);
		session_destroy();
		dbase::close_connection();	
		header("location: login.php?at=$at&message=session+timeout!++please+login+again&success=false");
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

include 'libs/subscriber.php';
include 'libs/mail.php';
/**
 * varables to maintain
 * > total count of subscribers
 * > total no of mails sent
 */
$subscribersCount = subscribers::getSubscribersCount();
$sentMailCount = mail::getSentMailCount();

?>