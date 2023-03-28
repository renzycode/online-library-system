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

            if($_POST['book_id_1'] == $_POST['book_id_2']){
                if(!empty($_POST['book_id_1']) &&  !empty($_POST['book_id_2'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_1'] == $_POST['book_id_3']){
                if(!empty($_POST['book_id_1']) &&  !empty($_POST['book_id_3'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_1'] == $_POST['book_id_4']){
                if(!empty($_POST['book_id_1']) &&  !empty($_POST['book_id_4'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_1'] == $_POST['book_id_5']){
                if(!empty($_POST['book_id_1']) &&  !empty($_POST['book_id_5'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_2'] == $_POST['book_id_3']){
                if(!empty($_POST['book_id_2']) &&  !empty($_POST['book_id_3'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_2'] == $_POST['book_id_4']){
                if(!empty($_POST['book_id_2']) &&  !empty($_POST['book_id_4'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_2'] == $_POST['book_id_5']){
                if(!empty($_POST['book_id_2']) &&  !empty($_POST['book_id_5'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_3'] == $_POST['book_id_4']){
                if(!empty($_POST['book_id_3']) &&  !empty($_POST['book_id_4'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_3'] == $_POST['book_id_5']){
                if(!empty($_POST['book_id_3']) &&  !empty($_POST['book_id_5'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            if($_POST['book_id_4'] == $_POST['book_id_5']){
                if(!empty($_POST['book_id_4']) &&  !empty($_POST['book_id_5'])){
                    redirectURL('../transaction.php?add=error&error=duplicatebook');
                exit();
                }
            } 

            $runquery="true";

            if(!empty($_POST['book_id_1'])){
                $params = array($_POST['book_id_1']);
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

            if(!empty($_POST['book_id_2'])){
                $params = array($_POST['book_id_2']);
                $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetch();
                if($result<=0){
                    redirectURL('../transaction.php?add=error&error=book2');
                    $runquery="";
                    exit();
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book2unavailable');
                    $runquery="";
                    exit();
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
                    $runquery="";
                    exit();
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book3unavailable');
                    $runquery="";
                    exit();
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
                    $runquery="";
                    exit();
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book4unavailable');
                    $runquery="";
                    exit();
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
                    $runquery="";
                    exit();
                }
                if($result['catalog_status']=='Unavailable'){
                    redirectURL('../transaction.php?add=error&error=book5unavailable');
                    $runquery="";
                    exit();
                }
            }
            
            if($runquery=="true"){
                $params = array(
                    $_POST['librarian_id'],
                    $_POST['borrower_id'],
                    $_POST['book_id_1'],
                    $_POST['book_id_2'],
                    $_POST['book_id_3'],
                    $_POST['book_id_4'],
                    $_POST['book_id_5'],
                    $_POST['borrow_date'].' '.$_POST['borrow_time'],
                    $_POST['return_date'].' '.$_POST['return_time'],
                    'Pending',
                    'Pending',
                    'On Borrow',
                );
                $sql = 'INSERT INTO transaction_table(
                    librarian_id,
                    borrower_id,
                    book_id_1,
                    book_id_2,
                    book_id_3,
                    book_id_4,
                    book_id_5,
                    transaction_borrow_datetime,
                    transaction_return_datetime,
                    transaction_datetime_return,
                    transaction_datetime_lapse,
                    transaction_status
                    ) 
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?)';
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
