<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['book_id'])){
        if($_POST['book_id']=="----------"){
            redirectURL('../add_book_copy.php?clone=error&error=allempty');
            exit();
        }
    }
    if(isset($_POST['clone_catalog'])){

        $sql = 'SELECT * FROM catalog_table WHERE catalog_number = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['catalog_number']));
        $check_catalog_number = $statement->fetch();

        if(!empty($check_catalog_number)){
            if($_POST['catalog_number']==$check_catalog_number['catalog_number']){
                redirectURL('../add_book_copy.php?clone=error&error=catalognumberexisting');
                exit();
            }
        }
        

        if(empty($_POST['rfid_code'])){
            $sql = 'SELECT * FROM catalog_table WHERE book_id = ?';
            $statement = $pdo->prepare($sql);
            $statement->execute(array($_POST['book_id']));
            $catalog = $statement->fetch();

            $sql = 'INSERT INTO catalog_table(
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
                ':rfid_code' => $_POST['rfid_code'],
                ':catalog_number' => $_POST['catalog_number'],
                ':catalog_book_title' => $catalog['catalog_book_title'],
                ':catalog_author' => $catalog['catalog_author'],
                ':catalog_publisher' => $catalog['catalog_publisher'],
                ':catalog_year' => $catalog['catalog_year'],
                ':catalog_date_received' => $catalog['catalog_date_received'],
                ':catalog_class' => $catalog['catalog_class'],
                ':catalog_edition' => $catalog['catalog_edition'],
                ':catalog_volumes' => $catalog['catalog_volumes'],
                ':catalog_source_of_fund' => $catalog['catalog_source_of_fund'],
                ':catalog_cost_price' => $catalog['catalog_cost_price'],
                ':catalog_location_symbol' => $catalog['catalog_location_symbol'],
                ':catalog_class_number' => $catalog['catalog_class_number'],
                ':catalog_author_number' => $catalog['catalog_author_number'],
                ':catalog_copyright_date' => $catalog['catalog_copyright_date'],
                ':catalog_status' => $_POST['catalog_status']
            ]);
    
            redirectURL('../add_book_copy.php?clone=success');
            exit();
        
        }
        $sql = "SELECT * FROM catalog_table WHERE rfid_code = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['rfid_code']));
        $fetched = $statement->fetch();

        if($fetched['rfid_code']==$_POST['rfid_code']){
            redirectURL('../add_book_copy.php?clone=error&error=rfidexisting');
            exit();
        }else{
            $sql = 'INSERT INTO catalog_table(
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
                ':rfid_code' => $_POST['rfid_code'],
                ':catalog_number' => $_POST['catalog_number'],
                ':catalog_book_title' => $catalog['catalog_book_title'],
                ':catalog_author' => $catalog['catalog_author'],
                ':catalog_publisher' => $catalog['catalog_publisher'],
                ':catalog_year' => $catalog['catalog_year'],
                ':catalog_date_received' => $catalog['catalog_date_received'],
                ':catalog_class' => $catalog['catalog_class'],
                ':catalog_edition' => $catalog['catalog_edition'],
                ':catalog_volumes' => $catalog['catalog_volumes'],
                ':catalog_source_of_fund' => $catalog['catalog_source_of_fund'],
                ':catalog_cost_price' => $catalog['catalog_cost_price'],
                ':catalog_location_symbol' => $catalog['catalog_location_symbol'],
                ':catalog_class_number' => $catalog['catalog_class_number'],
                ':catalog_author_number' => $catalog['catalog_author_number'],
                ':catalog_copyright_date' => $catalog['catalog_copyright_date'],
                ':catalog_status' => $_POST['catalog_status']
            ]);
    
            redirectURL('../add_book_copy.php?clone=success');
            exit();
        }

    
        
    }else{
        printInConsole('clone error!');
        redirectURL('../add_book_copy.php?clone=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
