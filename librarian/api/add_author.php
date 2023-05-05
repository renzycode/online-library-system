<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_author'])){
        
        $sql = 'SELECT * FROM author_table WHERE author_fname=? AND author_lname=?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            $_POST['author_fname'],
            $_POST['author_lname']
        ));
        $authors= $statement->fetch();
        if(!empty($authors)){
            redirectURL('../author_table.php?add=error&error=authoralready');
            exit();
        }


        $sql = 'INSERT INTO author_table(
            librarian_id,
            author_fname,
            author_lname
            ) 
        VALUES(?,?,?)';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            $_POST['librarian_id'],
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
