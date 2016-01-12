<?php

$to = "no-reply@aego.fr";
$subject = "The mail subject goes here";
$content= "And this is the mail content!";
$headers = "From:no-reply@aego.fr\r\n";

$isSent = mail($to, $subject, $content, $headers);
echo "Votre email a été envoyé : $isSent";

?>