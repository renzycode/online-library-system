<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_all_rejected_borrowers'])){

    $sql = 'DELETE FROM borrower_table WHERE borrower_status = "rejected" ';

    $statement = $pdo->prepare($sql);

    if($statement->execute()){
        redirectURL('../borrower.php?borrower=rejected&deleteall=success');
    }
}
redirectURL('../borrower.php?borrower=rejected&deleteall=error');