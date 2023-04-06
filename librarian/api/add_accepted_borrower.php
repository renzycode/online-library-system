<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['register'])){

        $sql = 'SELECT * FROM borrower_table 
        WHERE borrower_email = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['email']));
        $borrower = $statement->fetch();

        if(isset($borrower['borrower_email'])){
            if(!empty($borrower)){
                if($borrower['borrower_email']==$_POST['email']){
                    redirectURL('../borrower.php?borrower=accepted&add=error&error=emailalreadyused');
                    exit();
                }
            }
        }

        $filename=$_FILES["idpicture"]["name"];
        $tempname=$_FILES["idpicture"]["tmp_name"];
        $folder='../../assets/image/idpictures/'.$filename;
    
        $sql = 'INSERT INTO borrower_table(
            borrower_fname,
            borrower_lname,
            borrower_address,
            borrower_contact,
            borrower_email,
            borrower_id_image_name,
            borrower_status
            ) 
        VALUES(
            :fname,
            :lname,
            :address,
            :contact,
            :email,
            :id_image_name,
            :status
            )';
    
        $statement = $pdo->prepare($sql);
    
        if(move_uploaded_file($tempname,$folder)){

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
            $mail->addAddress($_POST['email']);//paolopabilona7@gmail.com
            //$mail->addReplyTo($senders_email);
            $mail->isHTML(true);                           // Set email content format to HTML
            $mail->Subject ='You have accepted as a borrower';
            $mail->Body ='
            
            Hello, '.$_POST['fname'].' You\'ve been accepted as a borrower.
            <br> 
            You can now borrow books from our physical library.
            <br> 
            <br> 
            <br> 
            - Online Library System
            <br> 
            - onlinelibrarysystem001@gmail.com
            ';

            $statement->execute([
                ':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':address' => $_POST['address'],
                ':contact' => $_POST['contact'],
                ':email' => $_POST['email'],
                ':id_image_name' => $filename,
                ':status' => 'accepted'
            ]);

            if($mail->send()){
                redirectURL('../borrower.php?borrower=accepted&add=success');
                exit();
            }else{
                redirectURL('../borrower.php?borrower=accepted&add=error&mailer=error');
                exit();
            }

            //header('Location: index.php?register=success');
            printInConsole('borrower accepted successfully!');
            redirectURL('../borrower.php?borrower=accepted&add=success');
        }
    }else{
        printInConsole('accepted error!');
        redirectURL('../borrower.php?borrower=accepted&add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
