<?php

require(__DIR__.'/vendor/autoload.php');

$mail = new PHPMailer;

$mail->SMTPDebug = 2;                               // Enable verbose debug output
$mail->Debugoutput = 'html';

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'postmaster@sandbox504c3f44050c4ee3aa785151b4924429.mailgun.org';                 // SMTP username
$mail->Password = '5af02be0e52d7990ab876526bae4ba3e';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('no-reply@aego.fr', 'Mailer');
$mail->addAddress('edwin.polycarpe@gmail.com');               // Name is optional

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>