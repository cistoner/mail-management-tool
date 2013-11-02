<?php
/**
 * dummy config file 
 * this is the format of config file that shall be used by
 * all data here shall be taken by user at the time of installation
 */
 if(!isset($checkVar)) 
 {
	header("location: ../../index.php");
	exit;
 }
 define("username_key","");
 define("password_key","");
 define("password_salt","temporarypasswordsalt");