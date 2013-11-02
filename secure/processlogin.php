<?php 
/**
 * Code to recieve login credentials from login page and 
 * authenticate it and give further instruction to browser
 */
session_start();
$checkVar = true;
include '../config/config.php';		//main configuration file
include '../libs/error.php';		//error handeling library
include '../libs/db.php';
include '../libs/log.php';			//logging library
include '../libs/login.php';		//login library

/*
 	// --code to check for http referer as it should be 
	// --domain_name/folder_name/login.php
	$referer = null;
	if(isset($_SERVER['HTTP_REFERER']))
		$referer = $_SERVER['HTTP_REFERER'];
*/

/**
 * code to check captcha in case of 
 * login failure exceeding threshold limit
 */
if(isset($_SESSION['failure']) && $_SESSION['failure'] > login::$maxInvalidAttempts)
{
		
}

if(isset($_POST['username']) && isset($_POST['password']))
{
	dbase::start_connection();
	$username = preg_replace("/[^A-Za-z0-9]+/","",$_POST['username']);
	if( strcmp($username,$_POST['username']) )
	{
		/**
		 * Means invalid charecters in username
		 * save this to log
		 * and increment $_SESSION['failure'] by one
		 */
		log::saveLog("INVALID CAHRS IN USERNAME");
		login::increaseFailureCount();
		dbase::close_connection();	
		header("location: ../login.php?message=invalid+chars+username&success=false");
		exit;
	}
	$password = preg_replace("/[^A-Za-z0-9-_@.!&()]+/","",$_POST['password']);
	if( strcmp($password, $_POST['password']) )
	{
		
		/**
		 * Means invalid charecters in password
		 * save this to log
		 * and increment $_SESSION['failure'] by one
		 */
		log::saveLog("INVALID CAHRS IN PASSWORD");
		login::increaseFailureCount();
		dbase::close_connection();	
		header("location: ../login.php?message=invalid+chars+password&success=false");
		exit;
	}
	$enc_password = md5(password_salt .$password);			//encrypted password
	$status = -1;
	try 
	{
		$status = login::authenticate($username, $enc_password);
	} 
	catch(dbError $ex)
	{
		/** 
		 * for debugging: shall be changed to some action later
		 */
		echo $ex->getMessage();
		exit;
	}
	catch (InvalidUsername $ex)
	{
		log::saveLog("INVALID CAHRS IN USERNAME");
		login::increaseFailureCount();
		dbase::close_connection();	
		header("location: ../login.php?message=invalid+chars+in+username&success=false");
		exit;	
	}
	catch (InvalidPassword $ex)
	{
		log::saveLog("INVALID CAHRS IN PASSWORD");
		login::increaseFailureCount();
		dbase::close_connection();	
		header("location: ../login.php?message=invalid+chars+in+password&success=false");
		exit;
	}
	if ($status == 2)
	{
		/**
		 * succesful login
		 * tasks: unset failure session entry
		 * get user id and save it to session
		 * set username and enc_password to session
		 * set last activity for that user
		 * redirect to dashboard
		 */
		if(isset($_SESSION['failure'])) unset($_SESSION['failure']);
		$query = mysql_query("SELECT `id` FROM `admin` WHERE `username` = '" .$username ."';");
		if(!$query)
		{
			/** 
			 * do not expect this to happen 
			 * so reporting mysql error for debugging purpose
			 */
			echo mysql_error();
			exit;
		}
		if(!mysql_num_rows($query))
		{
			/**
			 * this cannot happen as user has just been authenticated against same db 
			 * but in worst case if user was deleted very next moment
			 * user need to be redirected after loging
			 */
			log::saveLog("USER DELETED WHILE LOGIN");
			dbase::close_connection();	
			header("location: ../login.php?message=user+does+not+exist&success=false");
			exit;
		}
		$row = mysql_fetch_array($query);
		
		/**
		 * storing login data to session
		 */
		$_SESSION['id'] = $row[0];
		$_SESSION[username_key] = $username;
		$_SESSION[password_key] = $enc_password;
		
		/**
		 * saving last activity time of logged in users
		 */
		$time = time();
		$query = mysql_query("UPDATE `admin` SET `last_activity`='$time',`last_login`='$time' WHERE `username` = '$username';");
		if(!$query)
		{
			/** 
			 * do not expect this to happen 
			 * so reporting mysql error for debugging purpose
			 */
			echo mysql_error();
			exit;
		}
		dbase::close_connection();	
		header("location: ../index.php");
		exit;
	}
	else
	{
		/**
		 * unsucessful login
		 */
		log::saveLog("LOGIN FAILURE");
		login::increaseFailureCount();
		dbase::close_connection();	
		header("location: ../login.php?message=invalid+username+or+password&success=false");	
		exit;
	}
}
else 
{
	//save this to log --that an attempt was made to reach this page without post data
	header("location: ../login.php?message=invalid+login+attempt");
}

?>