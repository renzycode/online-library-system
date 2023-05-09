<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_catalog'])){

    $catalog_id = $_POST['id'];

    //delete in transaction table
    $sql = 'DELETE FROM transaction_table WHERE book_id = ? ';
    $statement = $pdo->prepare($sql);

    if($statement->execute(array($catalog_id))){

        //delete in author table
        $catalog_id = $_POST['id'];
        $sql = 'DELETE FROM author_book_bridge_table WHERE book_id = ? ';
        $statement = $pdo->prepare($sql);
    
        if($statement->execute(array($catalog_id))){

            //delete in catalog table
            $sql = 'DELETE FROM catalog_table WHERE book_id = ? ';
            $statement = $pdo->prepare($sql);

            if($statement->execute(array($catalog_id))){
                redirectURL('../catalog.php?delete=success');
            }
        }

    }else{
        redirectURL('../catalog.php?delete=error');
    }
}
redirectURL('../catalog.php?delete=error');