<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_GET['paid'])){
        if($_GET['paid']=='yes'){
            $sql = 'UPDATE transaction_table SET 
            transaction_paid = "Yes" WHERE transaction_id = ? ';
            $statement = $pdo->prepare($sql);

            if($statement->execute(array($_GET['transaction_id']))){
                redirectURL('../transaction_table.php?transaction=returned&edit=success');
            }
            redirectURL('../transaction_table.php?transaction=returned&edit=error');

        }elseif($_GET['paid']=='no'){
            $sql = 'UPDATE transaction_table SET 
            transaction_paid = "No" WHERE transaction_id = ? ';
            $statement = $pdo->prepare($sql);

            if($statement->execute(array($_GET['transaction_id']))){
                redirectURL('../transaction_table.php?transaction=returned&edit=success');
            }
            redirectURL('../transaction_table.php?transaction=returned&edit=error');
        }
    }else{
        printInConsole('Edit Transaction Error!');
        redirectURL('../transaction_table.php?transaction=returned&edit=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
