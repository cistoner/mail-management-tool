<?php
/*
 * this class will handle all mail operations like sending individual || bulk mails ||
 * framing of the mail ... the format [UI] of mail shall be kept in a XML default one
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}
 
 /*
  * class to send a single mail, frame a mail , save mail UI to file
 */
class mail
{
	
};
 
 /*
	class to send bulk mails from array of email ids or from database directly
 */
class bulkmail extends mail
{

};

?>