@ -0,0 +1,31 @@
<?php

include('librarian/smtp/PHPMailerAutoload.php');


$senders_email="onlinelibrarysystem001@gmail.com";
$senders_email_pass="uuehhyzvhhmsjysm";
$senders_host="smtp.gmail.com";

$send_to = "paolopabilona7@gmail.com";

$mail = new PHPMailer(); 

$mail->SMTPDebug = 3;//debugging
$mail->IsSMTP();
$mail->Host = $senders_host;//smtp host
$mail->SMTPAuth = true;
$mail->Username = $senders_email;//sender username
$mail->Password = $senders_email_pass;//sender password
$mail->SMTPSecure = 'tls';//encryption - ssl/tls
$mail->Port = 587;// port - 587/465
$mail->setFrom("onlinelibrarysystem001@gmail.com", "Online Library System");
$mail->addAddress($send_to);//paolopabilona7@gmail.com
//$mail->addReplyTo($senders_email);
$mail->isHTML(true);// Set email content format to HTML
$mail->Subject ='You have accepted as a borrower';
$mail->Body ='Hello testing';

if($mail->send()){
    echo 'success';
}else{
    echo 'error';
}