<?php

include_once "../includes/conn.php";
include_once "../includes/functions.php";

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
                    redirectURL('../index.php?sort_by=title&register=error&error=emailalreadyused');
                    exit();
                }
            }
        }

        $sql = 'INSERT INTO borrower_table(
            borrower_fname,
            borrower_lname,
            borrower_address,
            borrower_contact,
            borrower_email,
            borrower_status
            ) 
        VALUES(
            :fname,
            :lname,
            :address,
            :contact,
            :email,
            :status
            )';
    
        $statement = $pdo->prepare($sql);
    
        $statement->execute([
            ':fname' => $_POST['fname'],
            ':lname' => $_POST['lname'],
            ':address' => $_POST['address'],
            ':contact' => $_POST['contact'],
            ':email' => $_POST['email'],
            ':status' => 'pending'
        ]);
        printInConsole('borrower registered successfully!');
        redirectURL('../index.php?sort_by=title&register=success');
        exit();
    }else{
        printInConsole('registered error!');
        redirectURL('../index.php?sort_by=title&register=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
