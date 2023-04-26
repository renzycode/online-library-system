<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_catalog'])){
    

        if(empty($_POST['rfid_code'])){
            $sql = 'UPDATE catalog_table SET 
            catalog_number = :catalog_number,
            catalog_status = :catalog_status
            WHERE book_id = :book_id ';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute([
                ':catalog_number' => $_POST['catalog_number'],
                ':catalog_status' => $_POST['catalog_status'],
                ':book_id' => $_POST['book_id']
            ]);

            printInConsole('Borrower Registered Successfully!');
            redirectURL('../catalog.php?edit=success');
            exit();
        }

        $sql = "SELECT * FROM catalog_table WHERE rfid_code = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['rfid_code']));
        $fetched = $statement->fetch();

        if(!empty($fetched)){
            if($fetched['rfid_code']==$_POST['rfid_code']){
                redirectURL('../catalog.php?edit=error&rfid=existing');
                exit();
            }
        }else{
    
    
            $sql = 'UPDATE catalog_table SET 
            rfid_code = :rfid_code,
            catalog_number = :catalog_number,
            catalog_status = :catalog_status
            WHERE book_id = :book_id ';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute([
                ':rfid_code' => $_POST['rfid_code'],
                ':catalog_number' => $_POST['catalog_number'],
                ':catalog_status' => $_POST['catalog_status'],
                ':book_id' => $_POST['book_id']
            ]);

            printInConsole('catalog edited successfully!');
            redirectURL('../catalog.php?edit=success');
            exit();
        }
        
    }else{
        printInConsole('edit error!');
        redirectURL('../catalog.php?edit=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
