<h1>This is the Linode!</h1>

<?php
$to = '9692348@gmail.com';
$subject = 'Testing PHP Mail';
$message = 'This is a test email.';
$headers = 'From: gilbert67@gmail.com' . "\r\n";

if(mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully.';
} else {
    echo 'Failed to send email.';
}
?>
