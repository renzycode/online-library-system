<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_catalog'])){

        if(empty($_POST['rfid_code'])){
            $sql = 'INSERT INTO catalog_table(
                librarian_id,
                rfid_code,
                catalog_number,
                catalog_book_title,
                catalog_author,
                catalog_publisher,
                catalog_year,
                catalog_date_received,
                catalog_class,
                catalog_edition,
                catalog_volumes,
                catalog_source_of_fund,
                catalog_cost_price,
                catalog_location_symbol,
                catalog_class_number,
                catalog_author_number,
                catalog_copyright_date,
                catalog_status
                ) 
            VALUES(
                :librarian_id,
                :rfid_code,
                :catalog_number,
                :catalog_book_title,
                :catalog_author,
                :catalog_publisher,
                :catalog_year,
                :catalog_date_received,
                :catalog_class,
                :catalog_edition,
                :catalog_volumes,
                :catalog_source_of_fund,
                :catalog_cost_price,
                :catalog_location_symbol,
                :catalog_class_number,
                :catalog_author_number,
                :catalog_copyright_date,
                :catalog_status
                )';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute([
                ':librarian_id' => $_POST['librarian_id'],
                ':rfid_code' => $_POST['rfid_code'],
                ':catalog_number' => $_POST['catalog_number'],
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
                ':catalog_status' => $_POST['catalog_status']
            ]);
    
            redirectURL('../catalog.php?add=success');
        
        }
        $sql = "SELECT * FROM catalog_table WHERE rfid_code = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['rfid_code']));
        $fetched = $statement->fetch();

        if($fetched['rfid_code']==$_POST['rfid_code']){
            redirectURL('../catalog.php?add=error&rfid=existing');
        }else{
            $sql = 'INSERT INTO catalog_table(
                librarian_id,
                rfid_code,
                catalog_number,
                catalog_book_title,
                catalog_author,
                catalog_publisher,
                catalog_year,
                catalog_date_received,
                catalog_class,
                catalog_edition,
                catalog_volumes,
                catalog_source_of_fund,
                catalog_cost_price,
                catalog_location_symbol,
                catalog_class_number,
                catalog_author_number,
                catalog_copyright_date,
                catalog_status
                ) 
            VALUES(
                :librarian_id,
                :rfid_code,
                :catalog_number,
                :catalog_book_title,
                :catalog_author,
                :catalog_publisher,
                :catalog_year,
                :catalog_date_received,
                :catalog_class,
                :catalog_edition,
                :catalog_volumes,
                :catalog_source_of_fund,
                :catalog_cost_price,
                :catalog_location_symbol,
                :catalog_class_number,
                :catalog_author_number,
                :catalog_copyright_date,
                :catalog_status
                )';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute([
                ':librarian_id' => $_POST['librarian_id'],
                ':rfid_code' => $_POST['rfid_code'],
                ':catalog_number' => $_POST['catalog_number'],
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
                ':catalog_status' => $_POST['catalog_status']
            ]);
    
            redirectURL('../catalog.php?add=success');
        }

    
        
    }else{
        printInConsole('Registered Error!');
        redirectURL('../catalog.php?add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
