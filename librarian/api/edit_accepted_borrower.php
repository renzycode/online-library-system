<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['edit_accepted_borrower'])){

    if(!isset($_FILES["idpicture"]["name"]) || empty($_FILES["idpicture"]["name"]) ){
        $sql = 'UPDATE borrower_table SET 
        borrower_fname = ?, 
        borrower_lname = ?, 
        borrower_address = ?, 
        borrower_contact = ?, 
        borrower_email = ?
        WHERE borrower_id= ? ';

        $statement = $pdo->prepare($sql);


        $datas = array(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['address'],
            $_POST['contact'],
            $_POST['email'],
            $_POST['id']
        );

        if($statement->execute($datas)){
            redirectURL('../borrower.php?borrower=accepted&edit=success');
            exit();
        }
    }else{
        $filename=$_FILES["idpicture"]["name"];
        $tempname=$_FILES["idpicture"]["tmp_name"];
        $folder='../../assets/image/idpictures/'.$filename;

        $sql = 'UPDATE borrower_table SET 
        borrower_fname = ?, 
        borrower_lname = ?, 
        borrower_address = ?, 
        borrower_contact = ?, 
        borrower_email = ?,
        borrower_id_image_name = ?
        WHERE borrower_id= ? ';

        $statement = $pdo->prepare($sql);


        $datas = array(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['address'],
            $_POST['contact'],
            $_POST['email'],
            $filename,
            $_POST['id']
        );
        if(move_uploaded_file($tempname,$folder)){
            if($statement->execute($datas)){
                redirectURL('../borrower.php?borrower=accepted&edit=success');
                exit();
            }
        }
    }
}
redirectURL('../borrower.php?borrower=accepted&edit=error');