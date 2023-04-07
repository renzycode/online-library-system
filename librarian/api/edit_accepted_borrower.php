<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['edit_accepted_borrower'])){

    $sql = 'UPDATE borrower_table SET 
    borrower_fname = ?, 
    borrower_lname = ?, 
    borrower_address = ?, 
    borrower_contact = ?, 
    borrower_email = ?
    WHERE borrower_id= ? ';

    $statement = $pdo->prepare($sql);


    $datas = array(
        $_POST['fname'],
        $_POST['lname'],
        $_POST['address'],
        $_POST['contact'],
        $_POST['email'],
        $_POST['id']
    );

    if($statement->execute($datas)){
        redirectURL('../borrower.php?borrower=accepted&edit=success');
        exit();
    }
}
redirectURL('../borrower.php?borrower=accepted&edit=error');