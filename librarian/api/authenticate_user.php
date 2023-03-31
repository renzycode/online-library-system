<?php
include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try{
    if(isset($_POST['login'])){
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
    
        $sql = "SELECT * FROM librarian_table WHERE librarian_uname = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $uname);
        $statement->execute();
        $librarian = $statement->fetchAll();
    
        if(!count($librarian)>0){
            jsonResponse('no-uname-found');
        }else{
    
            $sql = "SELECT librarian_pass FROM librarian_table WHERE librarian_uname = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute(array($uname));
            $pass_fetched = $statement->fetch();
    
            if(password_verify($pass,$pass_fetched['librarian_pass'])){

                $sql = "SELECT librarian_id FROM librarian_table WHERE librarian_uname = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($uname));
                $id_fetched = $statement->fetch();

                session_start();

                // Set session variables
                $_SESSION["authen"] = True;
                $_SESSION["uname"] = $uname;
                $_SESSION["librarian_id"] = $id_fetched['librarian_id'];

                jsonResponse('success');
            }else{
                jsonResponse('wrong-password');
            }
        }
    }
    redirectURL('../login.php');
}catch (Exception $e) {
    jsonResponse('Caught exception: '.$e->getMessage());
}





        