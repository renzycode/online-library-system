<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_author'])){
    

        $sql = 'UPDATE author_table SET 
        author_fullname = ?
        WHERE author_id = ? ';
    
        $statement = $pdo->prepare($sql);
    
        $statement->execute(array($_POST['author_fullname'],$_POST['author_id']));

        printInConsole('author Edited Successfully!');
        redirectURL('../author_table.php?edit=success');
        exit();
        
    }else{
        printInConsole('edit error!');
        redirectURL('../author_table.php?edit=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
