<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_transaction'])){

        $params = array($_POST['borrower_id']);
        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $result = $statement->fetch();
        if($result>0){


            if(!empty($_POST['book_id_1'])){
                $params = array($_POST['book_id_1']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book1');
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book1unavailable');
                }
            }

            if(!empty($_POST['book_id_2'])){
                $params = array($_POST['book_id_2']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book2');
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book2unavailable');
                }
            }

            if(!empty($_POST['book_id_3'])){
                $params = array($_POST['book_id_3']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book3');
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book3unavailable');
                }
            }

            if(!empty($_POST['book_id_4'])){
                $params = array($_POST['book_id_4']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book4');
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book4unavailable');
                }
            }

            if(!empty($_POST['book_id_5'])){
                $params = array($_POST['book_id_5']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book5');
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book5unavailable');
                }
            }
            
            $params = array(
                $_POST['librarian_id'],
                $_POST['book_id_1'],
                $_POST['book_id_2'],
                $_POST['book_id_3'],
                $_POST['book_id_4'],
                $_POST['book_id_5'],
                $_POST['borrower_id'],
                $_POST['borrow_date'].'|'.$_POST['borrow_time'],
                $_POST['return_date'].'|'.$_POST['return_time'],
                'On Borrow',
            );
            $sql = 'INSERT INTO transaction_table(
                librarian_id,
                book_id_1,
                book_id_2,
                book_id_3,
                book_id_4,
                book_id_5,
                borrower_id,
                transaction_borrow_datetime,
                transaction_return_datetime,
                transaction_status
                ) 
            VALUES(?,?,?,?,?,?,?,?,?,?)';
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            printInConsole('Add Transaction Successfully!');
            
            $books = array(
                $_POST['book_id_1'],
                $_POST['book_id_2'],
                $_POST['book_id_3'],
                $_POST['book_id_4'],
                $_POST['book_id_5']
            );

            foreach ($books as $book){
                $sql = 'UPDATE catalog_table SET 
                catalog_status = "Unavailable"
                WHERE book_id = ?';
        
                $statement = $pdo->prepare($sql);
            
                $statement->execute(array($book));
            }
            


            redirectURL('../transaction.php?add=success');
        
        }else{
            printInConsole('Add Transaction Error!');
            redirectURL('../transaction.php?add=error&error=borrower');
        }

        
    }else{
        printInConsole('Add Transaction Error!');
        redirectURL('../transaction.php?add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
