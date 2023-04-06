<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['edit_librarian'])){
    
        if(!isset($_FILES["idpicture"]["name"]) || empty($_FILES["idpicture"]["name"]) ){
            $sql = 'UPDATE librarian_table SET 
            librarian_uname=?,
            librarian_fname=?,
            librarian_lname=?,
            librarian_address=?,
            librarian_contact=?,
            librarian_email=?
            WHERE librarian_id=?';
        
            $statement = $pdo->prepare($sql);
        
            $statement->execute(array(
                $_POST['uname'],
                $_POST['fname'],
                $_POST['lname'],
                $_POST['address'],
                $_POST['contact'],
                $_POST['email'],
                $_POST['librarian_id']
            ));

            printInConsole('librarian edited successfully!');
            redirectURL('../librarian_table.php?edit=success');
            exit();
        
        }else{
            $filename=$_FILES["idpicture"]["name"];
            $tempname=$_FILES["idpicture"]["tmp_name"];
            $folder='../../assets/image/idpictures/'.$filename;
        
            $sql = 'UPDATE librarian_table SET 
            librarian_uname=?,
            librarian_fname=?,
            librarian_lname=?,
            librarian_address=?,
            librarian_contact=?,
            librarian_email=?,
            librarian_image_name=?
            WHERE librarian_id=?';
        
            $statement = $pdo->prepare($sql);
            
            if(move_uploaded_file($tempname,$folder)){
                $statement->execute(array(
                    $_POST['uname'],
                    $_POST['fname'],
                    $_POST['lname'],
                    $_POST['address'],
                    $_POST['contact'],
                    $_POST['email'],
                    $filename,
                    $_POST['librarian_id']
                ));
                printInConsole('librarian added successfully!');
                redirectURL('../librarian_table.php?edit=success');
                exit();
            }
        }
    }elseif(isset($_POST['edit_librarian_password'])){
    
            $sql = 'UPDATE librarian_table SET 
            librarian_password=?
            WHERE librarian_id=?';
        
            $statement = $pdo->prepare($sql);
        
            if($_POST['new-password']!=$_POST['confirm-new-password']){
                redirectURL('../librarian_table.php?updatepassword=notmatch');
                exit();
            }

            $encrypted_password = password_hash($_POST['new-password'], PASSWORD_DEFAULT);

            $statement->execute(array(
                $encrypted_password,
                $_POST['librarian_id']
            ));

            printInConsole('librarian password updated successfully!');
            redirectURL('../librarian_table.php?updatepassword=success');
            exit();
    }else{
        printInConsole('edit librarian error');
        redirectURL('../librarian_table.php?edit=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
