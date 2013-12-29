<?php
/**
 * this class will handle all mail operations like sending individual || bulk mails ||
 * framing of the mail ... the format [UI] of mail shall be kept in a XML default one
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}
 include 'class.phpmailer.php';
 /*
  * class to send a single mail, frame a mail , save mail UI to file
 */
class mail
{
	/**
	 * function to get total no of mails sent
	 * return type: int
	 */
	public static function getSentMailCount()
	{
		$query = mysql_query("SELECT count(*) FROM mails;");
		$row = mysql_fetch_array($query);
		return ($row[0]);
	}
	public static function sendMail($subject , $recipient , $text , $attachement="default image url" , $sender="admin@mmt.org")
	{			
				

	}
};
 
 /*
	class to send bulk mails from array of email ids or from database directly
 */
class bulkmail extends mail
{

};

?>