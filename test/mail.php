
<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
//Import the PHPMailer class into the global namespace
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
use PHPMailer\PHPMailer\PHPMailer;
require_once 'PHPMailer/src/PHPMailer.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Set the hostname of the mail server
$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'AKIA5RYFVY6FV74VI4CY';
//Password to use for SMTP authentication
$mail->Password = 'ArWnvZ9V/uBVrvjNBtRpXIGBepOWpWcUHmDj/hyWTZ6Q';
//Set who the message is to be sent from
$mail->setFrom('datahanadmin@ippjoin.com', 'Datahan Admin');
//Set an alternative reply-to address
$mail->addReplyTo('datahanadmin@ippjoin.com', 'Datahan Admin');
//Set who the message is to be sent to
$mail->addAddress('alpbarutcu@gmail.com', 'Alper Barutçu');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
?>

<?php 


/*
 function sendmail($to,$subject,$message,$name)
    {
                  $mail             = new PHPMailer();
                  $body             = $message;
				  //$mail->IsSMTP();
                  $mail->SMTPAuth   = true;
                  $mail->Host       = "email-smtp.eu-west-1.amazonaws.com";
                  $mail->Port       = 25;
                  $mail->Username   = "AKIA5RYFVY6FV74VI4CY";
                  $mail->Password   = "ArWnvZ9V/uBVrvjNBtRpXIGBepOWpWcUHmDj/hyWTZ6Q";
                  $mail->SMTPSecure = 'tls';
                  $mail->SetFrom('datahanadmin@ippjoin.com', 'Datahan Admin');
                  $mail->AddReplyTo("datahanadmin@ippjoin.com","Datahan Admin");
                  $mail->Subject    = $subject;
                  $mail->AltBody    = "Any message.";
                  $mail->MsgHTML($body);
                  $mail->debug=2;
                  $address = $to;
                  $mail->AddAddress($address, $name);
                  if(!$mail->Send()) {
                    return $mail->ErrorInfo;
                  } else {
                        return 1;
                 }
    }

//var_dump(sendmail('alpbarutcu@gmail.com','deneme','test','alper'));
*/
?>
