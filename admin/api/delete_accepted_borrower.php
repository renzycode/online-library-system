<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_accepted_borrower'])){


    $borrower_id = $_POST['id'];

    $sql = 'DELETE FROM transaction_table WHERE borrower_id = ? ';

    $statement = $pdo->prepare($sql);

    $statement->bindParam(1, $borrower_id);

    if($statement->execute()){
        
        $sql = 'DELETE FROM borrower_table WHERE borrower_id = ? ';

        $statement = $pdo->prepare($sql);

        $statement->bindParam(1, $borrower_id);

        if($statement->execute()){
            redirectURL('../borrower.php?borrower=accepted&delete=success');
        }
    }


    
}
redirectURL('../borrower.php?borrower=accepted&delete=error');