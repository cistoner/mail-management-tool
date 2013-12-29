<?php
/**
 * this file will handle all mail operations like sending individual || bulk mails ||
 * framing of the mail ... the format [UI] of mail shall be kept in a XML default one
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}
 
include 'lib/mail.php';
$mail = new mail();

if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['text']) && !empty($_POST['text']) && isset($_POST['subject']) && !empty($_POST['subject']))
{
	$text = $_POST['email'];
	$subject = $_POST['subject'];
	$recepient = $_POST['email'];
	if(isset($_POST['image']) && !empty($_POST['image']) )
	{
		$image = $_POST['image'];
		$mail->sendmail($subject,$recepient,$text,$image);
	}
	else
	{
		$mail->sendmail($subject,$recepient,$text);
	}
}