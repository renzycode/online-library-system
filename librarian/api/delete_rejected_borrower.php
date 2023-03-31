<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_rejected_borrower'])){

    $sql = 'DELETE FROM borrower_table WHERE borrower_id = :borrower_id ';

    $statement = $pdo->prepare($sql);

    $statement->bindParam(':borrower_id', $_POST['id']);

    if($statement->execute()){
        redirectURL('../borrower.php?borrower=rejected&delete=success');
    }
}
redirectURL('../borrower.php?borrower=rejected&delete=error');