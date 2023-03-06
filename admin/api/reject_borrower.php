<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['reject_borrower'])){

    $sql = 'UPDATE borrower_table SET borrower_status = "rejected" WHERE borrower_id = :borrower_id ';

    $statement = $pdo->prepare($sql);

    $statement->bindParam(':borrower_id', $_POST['id']);

    if($statement->execute()){
        redirectURL('../borrower.php');
    }
}