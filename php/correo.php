<?php

require 'plugins/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;                            // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.creditosolidario.hn';              // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                               // Enable SMTP authentication
$mail->SMTPSecure = false;                               // Enable SMTP authentication
$mail->SMTPDebug = 1;                               // Enable SMTP authentication
// $mail->Username = 'convocatorias@creditosolidario.hn';// SMTP username
// $mail->Password = 'icsconvocatorias2017';             // User password         
$mail->Port = 25;                                    // TCP port to connect to

$mail->From = 'convocatorias@creditosolidario.hn';
$mail->addAddress('rick_valladares@hotmail.com', 'Ricardo Valladaresz');     // Add a recipient
$mail->addReplyTo('convocatorias@creditosolidario.hn', 'Convocatorias Crédito Solidario');

$mail->addAttachment('document.pdf');                 // Add attachments
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