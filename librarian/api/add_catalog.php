<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_catalog'])){

        //check if catalog number is existing
        $sql = 'SELECT * FROM catalog_table WHERE catalog_number = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['catalog_number']));
        $check_catalog_number = $statement->fetch();
        if(!empty($check_catalog_number)){
            if($_POST['catalog_number']==$check_catalog_number['catalog_number']){
                redirectURL('../catalog.php?add=error&error=catalognumberexisting');
                exit();
            }
        }

        //store all author names in array
        $authors = '';
        for($num = 1; $num <= 20; $num++){
            if($num==1){
                if(isset($_POST['catalog_author'.$num])){
                    $authors = $authors.$_POST['catalog_author'.$num];
                }
            }else{
                if(isset($_POST['catalog_author'.$num])){
                    $authors = $authors.','.$_POST['catalog_author'.$num];
                }
            }
            
        }
        $author_names = preg_split("/\,/", $authors);
        
        //check duplicate name
        if (count($author_names, SORT_REGULAR) != count(array_unique($author_names, SORT_REGULAR))){
            redirectURL('../catalog.php?add=error&error=duplicateauthorid');
            exit();
        }

        //check if author is valid or is there
        foreach($author_names as $author_name){
            $sql = 'SELECT * FROM author_table WHERE author_fullname LIKE \'%'.$author_name.'%\' ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $check_author = $statement->fetch();

            if(!isset($check_author['author_fullname'])){
                redirectURL('../catalog.php?add=error&error=authoridnotfound');
                exit();
            }
        }

        //check if rfid existing
        $sql = "SELECT * FROM catalog_table WHERE rfid_code = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['rfid_code']));
        $fetched = $statement->fetch();

        //store catalog details in catalog table
        if(isset($fetched['rfid_code'])){
            if($fetched['rfid_code']==$_POST['rfid_code']){
                redirectURL('../catalog.php?add=error&error=rfidexisting');
                exit();
            }
        }
        
        
        $sql = 'INSERT INTO catalog_table(
            librarian_id,
            rfid_code,
            catalog_number,
            catalog_book_title,
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
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            $_POST['librarian_id'],
            $_POST['rfid_code'],
            $_POST['catalog_number'],
            $_POST['catalog_book_title'],
            $_POST['catalog_publisher'],
            $_POST['catalog_year'],
            $_POST['catalog_date_received'],
            $_POST['catalog_class'],
            $_POST['catalog_edition'],
            $_POST['catalog_volumes'],
            $_POST['catalog_source_of_fund'],
            $_POST['catalog_cost_price'],
            $_POST['catalog_location_symbol'],
            $_POST['catalog_class_number'],
            $_POST['catalog_author_number'],
            $_POST['catalog_copyright_date'],
            $_POST['catalog_status']
        ));


        //convert authornames to ids array
        $author_ids_str = '';
        foreach($author_names as $author_name){
            $sql = 'SELECT * FROM author_table WHERE author_fullname LIKE \'%'.$author_name.'%\' ';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $author_fetched = $statement->fetch();
            if(empty($author_ids_str)){
                $author_ids_str = $author_ids_str.$author_fetched['author_id'];
            }else{
                $author_ids_str = $author_ids_str.', '.$author_fetched['author_id'];
            }
        }
        $author_ids = preg_split("/\,/", $author_ids_str);


        //check newly added catalog
        $sql = "SELECT MAX(book_id) as max_id FROM catalog_table";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $fetched = $statement->fetch();

        //store in bridge table
        foreach($author_ids as $author_id){
            $sql = 'INSERT INTO author_book_bridge_table (author_id, book_id) VALUES (?,?)';
            $statement = $pdo->prepare($sql);
            $statement->execute(array($author_id,$fetched['max_id']));
        }

        redirectURL('../catalog.php?add=success');
        exit();
    
        
    }else{
        printInConsole('add error!');
        redirectURL('../catalog.php?add=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');