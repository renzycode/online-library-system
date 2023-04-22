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
            redirectURL('../login.php?error=nouserfound');
            exit();
        }else{
    
            $sql = "SELECT librarian_password FROM librarian_table WHERE librarian_uname = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute(array($uname));
            $pass_fetched = $statement->fetch();
    
            if(password_verify($pass,$pass_fetched['librarian_password'])){


                $sql = "SELECT librarian_status FROM librarian_table WHERE librarian_uname = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($uname));
                $fetched = $statement->fetch();

                if($fetched['librarian_status']=='Deactivated'){
                    redirectURL('../login.php?error=accountdeactivated');
                    exit();
                }

                $sql = "SELECT librarian_id FROM librarian_table WHERE librarian_uname = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute(array($uname));
                $id_fetched = $statement->fetch();

                session_start();

                // Set session variables
                $_SESSION["authen"] = True;
                $_SESSION["uname"] = $uname;
                $_SESSION["librarian_id"] = $id_fetched['librarian_id'];

                redirectURL('../index.php');
                exit();
            }else{
                redirectURL('../login.php?error=wrongpassword');
                exit();
            }
        }
    }
    redirectURL('../login.php?error=1');
}catch (Exception $e) {
    redirectURL('../login.php?error=1');
}





        