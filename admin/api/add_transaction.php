<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_transaction'])){
    
        $params = array(
            1,
            $_POST['catalog_id_1'],
            $_POST['catalog_id_2'],
            $_POST['catalog_id_3'],
            $_POST['catalog_id_4'],
            $_POST['catalog_id_5'],
            $_POST['borrower_id'],
            $_POST['borrow_date'].'|'.$_POST['borrow_time'],
            $_POST['return_date'].'|'.$_POST['return_time'],
            'On Borrow',
        );

        $sql = 'INSERT INTO transaction_table(
            librarian_id,
            catalog_id_1,
            catalog_id_2,
            catalog_id_3,
            catalog_id_4,
            catalog_id_5,
            borrower_id,
            transaction_borrow_datetime,
            transaction_return_datetime,
            transaction_status
            ) 
        VALUES(?,?,?,?,?,?,?,?,?,?)';
    
        $statement = $pdo->prepare($sql);

        $statement->execute($params);

        printInConsole('Add Transaction Successfully!');
        redirectURL('../transaction.php?add=success');
    }else{
        printInConsole('Add Transaction Error!');
        redirectURL('../transaction.php?add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
