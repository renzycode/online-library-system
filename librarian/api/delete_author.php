<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_author'])){
    $sql = 'DELETE FROM author_book_bridge_table WHERE author_id = ? ';
    $statement = $pdo->prepare($sql);
    if($statement->execute(array($_POST['author_id']))){
        $sql = 'DELETE FROM author_table WHERE author_id = ? ';
        $statement = $pdo->prepare($sql);
        if($statement->execute(array($_POST['author_id']))){
            redirectURL('../author_table.php?delete=success');
        }else{
            redirectURL('../author_table.php?delete=error');
        }
    }else{
        redirectURL('../author_table.php?delete=error');
    }

    
}
redirectURL('../author_table.php?delete=error');