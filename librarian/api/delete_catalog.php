<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_catalog'])){

    $catalog_id = $_POST['id'];
    $sql = 'DELETE FROM transaction_table WHERE book_id = ? ';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $catalog_id);

    if($statement->execute()){

        $sql = 'DELETE FROM catalog_table WHERE book_id = ? ';

        $statement = $pdo->prepare($sql);

        $statement->bindParam(1, $catalog_id);

        if($statement->execute()){
            redirectURL('../catalog.php?delete=success');
        }
    }else{
        redirectURL('../catalog.php?delete=error');
    }
}
redirectURL('../catalog.php?delete=error');