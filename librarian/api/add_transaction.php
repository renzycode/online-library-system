<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_transaction'])){


        date_default_timezone_set("Asia/Hong_Kong");

        $dueDateTime = strtotime($_POST['due_date']);
        
        $dueDateTimeConverted = date("Y-m-d", $dueDateTime);
        $currentDateTimeConverted = date("Y-m-d");
        
        $due_date_time=strtotime($dueDateTimeConverted);
        $current_date_time=strtotime($currentDateTimeConverted);
        
        $difference=$current_date_time-$due_date_time;
        
        $hours=($difference / 3600);
        $days=($hours/24);

        if($days>=0){
            redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&error=duedatetime');
            exit();
        }

        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ? AND borrower_status = "rejected"';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['borrower_id']));
        $result = $statement->fetch();

        if(isset($result['borrower_id'])){
            if(!empty($result)){
                if($result['borrower_id']==$_POST['borrower_id']){
                    redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&borrower=rejected');
                    exit();
                }
            }
        }

        $params = array($_POST['borrower_id']);
        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $result = $statement->fetch();
        if($result>0){

            $runquery="true";

            if(!empty($_POST['book_id'])){
                $params = array($_POST['book_id']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&error=book1');
                    $runquery="";
                    exit();
                }
                elseif($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&error=book1unavailable');
                    $runquery="";
                    exit();
                }else{
                    
                }
            }
            $due_date = $_POST['due_date'];
            if($runquery=="true"){
                $params = array(
                    $_POST['librarian_id'],
                    $_POST['borrower_id'],
                    $_POST['book_id'],
                    date("Y-m-d", strtotime(date("Y-m-d"))),
                    $due_date,
                    '------',
                    '------',
                    '----',
                    '----',
                    'On Borrow',
                );
                $sql = 'INSERT INTO transaction_table(
                    librarian_id,
                    borrower_id,
                    book_id,
                    transaction_borrow_datetime,
                    transaction_due_datetime,
                    transaction_datetime_return,
                    transaction_datetime_lapse,
                    transaction_penalty,
                    transaction_paid,
                    transaction_status
                    ) 
                VALUES(?,?,?,?,?,?,?,?,?,?)';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                printInConsole('Add Transaction Successfully!');
                
                $book = array(
                    $_POST['book_id'],
                );
    
                $sql = 'UPDATE catalog_table SET 
                catalog_status = "Unavailable"
                WHERE book_id = ?';
        
                $statement = $pdo->prepare($sql);
            
                $statement->execute(array($_POST['book_id']));
                
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute(array($_POST['book_id']));
                $book = $statement->fetch();

                $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute(array($_POST['borrower_id']));
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
                $mail->Subject ='You borrowed a book';
                $mail->Body ='
                Hello, '.$borrower['borrower_fname'].' You borrowed a book titled '.$book['catalog_book_title'].'. Keep in mind that your due date is '.$due_date.'.
                <br> 
                Make sure you return the borrowed book on time, or else you have to pay a penalty.
                <br> 
                <br> 
                <br> 
                - Online Library System
                <br> 
                - onlinelibrarysystem001@gmail.com
                ';
                if($mail->send()){
                    redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=success');
                    exit();
                }else{
                    redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&mailer=error');
                    exit();
                }

    
                redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=success');
                exit();
            }
            
        
        
        }else{
            printInConsole('add transaction error!');
            redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error&error=borrower');
            exit();
        }

        
    }else{
        printInConsole('add transaction error!');
        redirectURL('../transaction.php?borrower='.$_POST['borrower_id'].'&add=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}
exit();
