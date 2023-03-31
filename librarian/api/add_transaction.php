<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_transaction'])){

        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ? AND borrower_status = "rejected"';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['borrower_id']));
        $result = $statement->fetch();

        if($result['borrower_id']==$_POST['borrower_id']){
            redirectURL('../transaction.php?add=error&borrower=rejected');
            exit();
        }

        $params = array($_POST['borrower_id']);
        $sql = 'SELECT * FROM borrower_table WHERE borrower_id = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $result = $statement->fetch();
        if($result>0){

            $runquery="true";

            if(!empty($_POST['book_id'])){
                $params = array($_POST['book_id']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book1');
                    $runquery="";
                    exit();
                }
                elseif($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book1unavailable');
                    $runquery="";
                    exit();
                }else{
                    
                }
            }
            
            if($runquery=="true"){
                $params = array(
                    $_POST['librarian_id'],
                    $_POST['borrower_id'],
                    $_POST['book_id'],
                    $_POST['borrow_date'].' '.date("g:i a", strtotime($_POST['borrow_time'])),
                    $_POST['due_date'].' '.date("g:i a", strtotime($_POST['due_time'])),
                    '------',
                    '------',
                    '----',
                    '----',
                    'On Borrow',
                );
                $sql = 'INSERT INTO transaction_table(
                    librarian_id,
                    borrower_id,
                    book_id,
                    transaction_borrow_datetime,
                    transaction_due_datetime,
                    transaction_datetime_return,
                    transaction_datetime_lapse,
                    transaction_penalty,
                    transaction_paid,
                    transaction_status
                    ) 
                VALUES(?,?,?,?,?,?,?,?,?,?)';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                printInConsole('Add Transaction Successfully!');
                
                $book = array(
                    $_POST['book_id'],
                );
    
                $sql = 'UPDATE catalog_table SET 
                catalog_status = "Unavailable"
                WHERE book_id = ?';
        
                $statement = $pdo->prepare($sql);
            
                $statement->execute(array($_POST['book_id']));
                
    
    
                redirectURL('../transaction.php?add=success');
            }
            
        
        
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
