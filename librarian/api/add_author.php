<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_author'])){
    
        $sql = 'INSERT INTO author_table(
            author_fname,
            author_lname
            ) 
        VALUES(?,?)';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            $_POST['author_fname'],
            $_POST['author_lname']
        ));
        printInConsole('author added successfully!');
        redirectURL('../author_table.php?add=success');
    }else{
        printInConsole('add error!');
        redirectURL('../author_table.php?add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
