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
            'Returned',
            $_POST['transaction_id']
        );

        if($statement->execute($params)){


            $sql = 'SELECT * FROM transaction_table
            WHERE transaction_id = ? ';
            $statement = $pdo->prepare($sql);
            $params=array(
                $_POST['transaction_id']
            );
            $statement->execute($params);
            $result = $statement->fetch();
            $books = array(
                $result['book_id_1'],
                $result['book_id_2'],
                $result['book_id_3'],
                $result['book_id_4'],
                $result['book_id_5']
            );
            foreach ($books as $book){
                $sql = 'UPDATE catalog_table SET 
                catalog_status = "Available"
                WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute(array($book));
            }
        }

        


        redirectURL('../transaction_table.php?edit=success');
    }else{
        printInConsole('Edit Transaction Error!');
        redirectURL('../transaction_table.php?edit=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
