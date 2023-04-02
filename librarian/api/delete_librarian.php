<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_librarian'])){

    if($_POST['id']==$_POST['my_id']){
        redirectURL('../librarian_table.php?delete=error&account=you');
        exit();
    }

    $librarian_id = $_POST['id'];
    $sql = 'DELETE FROM transaction_table WHERE librarian_id = ?';
    $statement1 = $pdo->prepare($sql);

    if($statement1->execute(array($_POST['id']))){

        $sql = 'DELETE FROM librarian_table WHERE librarian_id = ?';
        $statement2 = $pdo->prepare($sql);
        if($statement2->execute(array($_POST['id']))){
            redirectURL('../librarian_table.php?delete=success');
        }
    }
    
}
redirectURL('../librarian_table.php?delete=error');