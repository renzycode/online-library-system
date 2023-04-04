<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_POST['register'])){
        $filename=$_FILES["idpicture"]["name"];
        $tempname=$_FILES["idpicture"]["tmp_name"];
        $folder='../../assets/image/idpictures/'.$filename;
    
        $sql = 'INSERT INTO borrower_table(
            borrower_fname,
            borrower_lname,
            borrower_address,
            borrower_contact,
            borrower_email,
            borrower_id_image_name,
            borrower_status
            ) 
        VALUES(
            :fname,
            :lname,
            :address,
            :contact,
            :email,
            :id_image_name,
            :status
            )';
    
        $statement = $pdo->prepare($sql);
    
        if(move_uploaded_file($tempname,$folder)){
            $statement->execute([
                ':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':address' => $_POST['address'],
                ':contact' => $_POST['contact'],
                ':email' => $_POST['email'],
                ':id_image_name' => $filename,
                ':status' => 'accepted'
            ]);
            //header('Location: index.php?register=success');
            printInConsole('borrower accepted successfully!');
            redirectURL('../borrower.php?borrower=accepted&add=success');
        }
    }else{
        printInConsole('accepted error!');
        redirectURL('../borrower.php?borrower=accepted&add=error');
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



//header('Location: index.php?register=error');
