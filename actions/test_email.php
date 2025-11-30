<?php
require_once("../functions/send_mail.php");

$to = "henryowusu023@gmail.com"; // Using the email from settings
$subject = "Test Email from AfriConnect";
$body = "This is a test email to verify that the email system is working correctly after the fix.";

if(send_general_email($to, $subject, $body)){
    echo "Email sent successfully to $to";
} else {
    echo "Failed to send email.";
}
?>
