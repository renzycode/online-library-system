<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_transaction'])){
    
        $sql = 'UPDATE transaction_table SET 
        transaction_status = ?
        WHERE transaction_id = ? ';
    
        $statement = $pdo->prepare($sql);
    

        $params=array(
            $_POST['transaction_status'],
            $_POST['transaction_id']
        );


        $statement->execute($params);

        printInConsole('Transaction Edited Successfully!');
        redirectURL('../transaction_table.php?edit=success');
    }else{
        printInConsole('Edit Transaction Error!');
        redirectURL('../transaction_table.php?edit=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
