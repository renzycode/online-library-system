<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['accept_borrower'])){

    $sql = 'UPDATE borrower_table SET borrower_status = "accepted" WHERE borrower_id = ? ';

    $statement = $pdo->prepare($sql);

    if($statement->execute(array($_POST['id']))){


        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['id']));
        $borrower = $statement->fetch();

        include('../smtp/PHPMailerAutoload.php');

        $senders_email="onlinelibrarysystem001@gmail.com";
        $senders_email_pass="uuehhyzvhhmsjysm";
        $senders_host="smtp.gmail.com";

        $mail = new PHPMailer(); 

        //$mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = $senders_host;        //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = $senders_email; //  sender username
        $mail->Password = $senders_email_pass;          // sender password
        $mail->SMTPSecure = 'tls';                     // encryption - ssl/tls
        $mail->Port = 587;                             // port - 587/465
        $mail->setFrom("onlinelibrarysystem001@gmail.com","Online Library System");
        $mail->addAddress($borrower['borrower_email']);//paolopabilona7@gmail.com
        //$mail->addReplyTo($senders_email);
        $mail->isHTML(true);                           // Set email content format to HTML
        $mail->Subject ='You have accepted as a borrower';
        $mail->Body ='
        
        Hello, '.$borrower['borrower_fname'].' You\'ve been accepted as a borrower.
        <br> 
        You can now borrow books from our physical library.
        <br> 
        <br> 
        <br> 
        - Online Library System
        <br> 
        - onlinelibrarysystem001@gmail.com
        ';

        if($mail->send()){
            redirectURL('../borrower.php?borrower=pending&accept=success');
            exit();
        }else{
            redirectURL('../borrower.php?borrower=pending&accept=error&mailer=error');
            exit();
        }

        redirectURL('../borrower.php?borrower=pending&accept=success');
        exit();
    }
}
redirectURL('../borrower.php?borrower=pending&accept=error');
exit();