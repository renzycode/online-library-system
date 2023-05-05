<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_catalog'])){
    
            $sql = 'UPDATE catalog_table SET 
            catalog_number = ?,
            catalog_book_title = ?,
            catalog_publisher = ?,
            catalog_year = ?,
            catalog_date_received = ?,
            catalog_class = ?,
            catalog_edition = ?,
            catalog_volumes = ?,
            catalog_pages = ?,
            catalog_source_of_fund = ?,
            catalog_cost_price = ?,
            catalog_location_symbol = ?,
            catalog_class_number = ?,
            catalog_copyright_date = ?,
            catalog_status = ?
            WHERE book_id = ? ';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute(array(
                $_POST['catalog_number'],
                $_POST['catalog_book_title'],
                $_POST['catalog_publisher'],
                $_POST['catalog_year'],
                $_POST['catalog_date_received'],
                $_POST['catalog_class'],
                $_POST['catalog_edition'],
                $_POST['catalog_volumes'],
                $_POST['catalog_pages'],
                $_POST['catalog_source_of_fund'],
                $_POST['catalog_cost_price'],
                $_POST['catalog_location_symbol'],
                $_POST['catalog_class_number'],
                $_POST['catalog_copyright_date'],
                $_POST['catalog_status'],
                $_POST['book_id']
            ));

            printInConsole('Borrower Registered Successfully!');
            redirectURL('../catalog.php?edit=success');
            exit();
        
    }else{
        printInConsole('edit error!');
        redirectURL('../catalog.php?edit=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
