<?php

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; 
 
// Include library files 
require 'phpmailer/src/Exception.php'; 
require 'phpmailer/src/PHPMailer.php'; 
require 'phpmailer/src/SMTP.php'; 
 
// Create an instance; Pass `true` to enable exceptions 
 $mail = new PHPMailer; 
 

// function send_email($body,$to,$bcc,$from,$subject,$attach_file)
// {
// 	try 
// 	{			
			
// 				if(isset($to))
// 				{
// 					$to=$to;
// 					$bcc=$bcc;
// 					$subject = $subject; 
// 					$from = $from; 
// 					$body = $body;
// 					$mail = new PHPMailer;
// 					$mail->SMTPDebug = 0;                               // Enable verbose debug output
// 					$mail->isSMTP();                                      // Set mailer to use SMTP
// 					$mail->Host = 'mail.zuku.co.in';  // Specify main and backup SMTP servers
// 					$mail->SMTPAuth = true;                               // Enable SMTP authentication		
// 					$mail->Username = 'jay@zuku.co.in';                 // SMTP username
// 					$mail->Password = 'Uj=XhK2o7&}q';                           // SMTP password
// 					$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
// 					$mail->Port = 465;                                    // TCP port to connect to
// 					$mail->SetFrom($from,$subject);		
// 					$mail->addAddress($to,$subject);
// 					$mail->AddAttachment('5ebe60eecc8e9profile.png');	
// 				 	//$mail->addBCC($bcc);
// 					$mail->isHTML(true);
// 					$mail->Subject = $subject;
// 					$mail->Body    = $body;
					
					 
// 					if(!$mail->send()) {
// 						echo 'Message could not be sent.';
// 						echo 'Mailer Error: ' . $mail->ErrorInfo;
// 						exit;
// 					}
// 					else{
						
// 					} 							
// 				}				
// 	}
// 	catch(Exception $e) {
// 		echo $e;
// 	}
// }

// $body = '<h1>How to Send Email from Localhost using PHP by CodexWorld</h1>'; 
// $body .= '<p>This HTML email is sent from the localhost server using PHP by <b>CodexWorld</b></p>';
// $to = 'jigneshmakwana87@gmail.com';
// $bcc = '';
// $from = 'jigneshmakwana87@gmail.com';
// $subject = 'Email from Localhost by CodexWorld';
// $attach_file = './5ebe60eecc8e9profile.png';
// send_email($body,$to,$bcc,$from,$subject,$attach_file);
//  exit;
// Server settings 
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output 
$mail->isSMTP();                            // Set mailer to use SMTP 
$mail->Host = 'mail.zuku.co.in';           // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;                     // Enable SMTP authentication 
$mail->Username = 'jay@zuku.co.in';       // SMTP username 
$mail->Password = 'Uj=XhK2o7&}q';         // SMTP password 
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 465;                          // TCP port to connect to 
 
// Sender info 
$mail->setFrom('dev.zuku@gmail.com', 'SenderName'); 
$mail->addReplyTo('dev.zuku@gmail.com', 'SenderName'); 
 
// Add a recipient 
$mail->addAddress('dev.zuku@gmail.com'); 
 
//$mail->addCC('cc@example.com'); 
//$mail->addBCC('bcc@example.com'); 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Mail subject 
$mail->Subject = 'Email from Localhost '; 
 
// Mail body content 
$bodyContent = '<h1> Email from Localhost </h1>'; 
$bodyContent .= '<p>This HTML email is sent from the localhost server using PHP by <b>CodexWorld</b></p>'; 
$mail->Body    = $bodyContent; 
//$mail->AddAttachment('./5ebe60eecc8e9profile.png');	 
// Send email 
if(!$mail->send()) { 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
    echo 'Message has been sent.'; 
}

?>
