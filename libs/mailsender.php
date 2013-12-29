<?php 

include 'class.phpmailer.php';
if(isset($_POST['subject']) && !empty($_POST['subject']) && isset($_POST['text']) && !empty($_POST['text']) && isset($_POST['recepient']) && !empty($_POST['recepient']))
{
	$subject = $_POST['subject'];
	$text = $_POST['text'];
	$recipient = $_POST['recepient'];
				// PREPARE THE BODY OF THE MESSAGE
				$message = '<html><body>';
				$message .= $text;
				$message .= "</body></html>";
				
				
				//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
				
				$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i"; 
				if (preg_match($pattern, trim(strip_tags($recipient)))) { 
					$cleanedFrom = trim(strip_tags($recipient)); 
				} else { 
					return "The email address $recipient you entered was invalid. Please try again!"; 
				}

				//   CHANGE THE BELOW VARIABLES TO YOUR NEEDS
				 
				$to = $cleanedFrom;
				
				$email = new PHPMailer();
				$email->From      = 'admin@mmt.org';
				$email->FromName  = 'admin';
				$email->Subject   = $subject;
				$email->Body      = $message;
				$email->AddAddress( $to );
				
				/*$file_to_attach = '../uploads'.$attachement;
				$email->AddAttachment( $file_to_attach , $attachement );
				*/
				$email->isHTML(true);
				
				if($email->Send())
				{
					echo "Email Sent to $to <br>";
				}
				else
				{
					echo "error sending to $to <br>";
				}
}
if(isset($_POST['subject']) && !empty($_POST['subject']) && isset($_POST['text']) && !empty($_POST['text']) && isset($_POST['recepient']) && !empty($_POST['recepient']) && isset($_POST['attachment']) && !empty($_POST['attachment']))
{
	$subject = $_POST['subject'];
	$text = $_POST['text'];
	$recipient = $_POST['recepient'];
	$attachment = $_POST['attachment'];
				// PREPARE THE BODY OF THE MESSAGE
				$message = '<html><body>';
				$message .= $text;
				$message .= "</body></html>";
				
				
				//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
				
				$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i"; 
				if (preg_match($pattern, trim(strip_tags($recipient)))) { 
					$cleanedFrom = trim(strip_tags($recipient)); 
				} else { 
					return "The email address $recipient you entered was invalid. Please try again!"; 
				}

				//   CHANGE THE BELOW VARIABLES TO YOUR NEEDS
				 
				$to = $cleanedFrom;
				
				$email = new PHPMailer();
				$email->From      = 'admin@mmt.org';
				$email->FromName  = 'admin';
				$email->Subject   = $subject;
				$email->Body      = $message;
				$email->AddAddress( $to );
				$temp = explode("\\",$attachment);
				$attachment = $temp[count($temp)-1];
				$file_to_attach = '../uploads/'.$attachment;
				$email->AddAttachment( $file_to_attach , $attachment );
				
				$email->isHTML(true);
				
				if($email->Send())
				{
					echo "Email Sent to $to <br>";
				}
				else
				{
					echo "error sending to $to <br>".$email->ErrorInfo;
				}

}
?>