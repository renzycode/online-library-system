<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['add_librarian'])){

        $sql = 'SELECT * FROM librarian_table 
        WHERE librarian_uname = ? OR librarian_email = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute(array($_POST['uname'],$_POST['email']));
        $librarian = $statement->fetch();

        if($librarian['librarian_uname']==$_POST['uname']){
            redirectURL('../librarian_table.php?add=error&error=unameexisting');
            exit();
        }

        if($librarian['librarian_email']==$_POST['email']){
            redirectURL('../librarian_table.php?add=error&error=emailexisting');
            exit();
        }


        $filename=$_FILES["idpicture"]["name"];
        $tempname=$_FILES["idpicture"]["tmp_name"];
        $folder='../../assets/image/idpictures/'.$filename;
    
        $sql = 'INSERT INTO librarian_table(
            librarian_uname,
            librarian_password,
            librarian_fname,
            librarian_lname,
            librarian_address,
            librarian_contact,
            librarian_email,
            librarian_image_name
            ) 
        VALUES(?,?,?,?,?,?,?,?)';
    
        $statement = $pdo->prepare($sql);
        
        $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if(move_uploaded_file($tempname,$folder)){
            $statement->execute(array(
                $_POST['uname'],
                $encrypted_password,
                $_POST['fname'],
                $_POST['lname'],
                $_POST['address'],
                $_POST['contact'],
                $_POST['email'],
                $filename
            ));
            printInConsole('librarian added successfully!');
            redirectURL('../librarian_table.php?add=success');
        }
    }else{
        printInConsole('add error!');
        redirectURL('../librarian_table.php?add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
