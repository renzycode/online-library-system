<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_catalog'])){
    
        $sql = 'UPDATE catalog_table SET 
        librarian_id = :librarian_id,
        catalog_number = :catalog_number,
        catalog_book_title = :catalog_book_title,
        catalog_author = :catalog_author,
        catalog_publisher = :catalog_publisher,
        catalog_year = :catalog_year,
        catalog_date_received = :catalog_date_received,
        catalog_class = :catalog_class,
        catalog_edition = :catalog_edition,
        catalog_volumes = :catalog_volumes,
        catalog_source_of_fund = :catalog_source_of_fund,
        catalog_cost_price = :catalog_cost_price,
        catalog_location_symbol = :catalog_location_symbol,
        catalog_class_number = :catalog_class_number,
        catalog_author_number = :catalog_author_number,
        catalog_copyright_date = :catalog_copyright_date,
        catalog_status = :catalog_status
        WHERE catalog_id = :catalog_id ';
    
        $statement = $pdo->prepare($sql);
    
        $statement->execute([
            ':librarian_id' => 1,
            ':catalog_number' => $_POST['catalog_number'],
            ':catalog_book_title' => $_POST['catalog_book_title'],
            ':catalog_author' => $_POST['catalog_author'],
            ':catalog_publisher' => $_POST['catalog_publisher'],
            ':catalog_year' => $_POST['catalog_year'],
            ':catalog_date_received' => $_POST['catalog_date_received'],
            ':catalog_class' => $_POST['catalog_class'],
            ':catalog_edition' => $_POST['catalog_edition'],
            ':catalog_volumes' => $_POST['catalog_volumes'],
            ':catalog_source_of_fund' => $_POST['catalog_source_of_fund'],
            ':catalog_cost_price' => $_POST['catalog_cost_price'],
            ':catalog_location_symbol' => $_POST['catalog_location_symbol'],
            ':catalog_class_number' => $_POST['catalog_class_number'],
            ':catalog_author_number' => $_POST['catalog_author_number'],
            ':catalog_copyright_date' => $_POST['catalog_copyright_date'],
            ':catalog_status' => $_POST['catalog_status'],
            ':catalog_id' => $_POST['catalog_id']
        ]);

        printInConsole('Borrower Registered Successfully!');
        redirectURL('../catalog.php?edit=success');
    }else{
        printInConsole('Registered Error!');
        redirectURL('../catalog.php?edit=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
