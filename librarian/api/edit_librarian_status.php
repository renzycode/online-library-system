<?php

include_once "../../includes/conn.php";
include_once "../../includes/functions.php";

try {
    if(isset($_GET['submit'])){
        if($_GET['status']=='deactivate'){

            if($_GET['librarian_id']==$_GET['id']){
                redirectURL('../librarian_table.php?editstatusdeactivate=ownaccount');
                exit();
            }

            $sql = 'UPDATE librarian_table SET 
            librarian_status = "Deactivated" WHERE librarian_id = ? ';
            $statement = $pdo->prepare($sql);

            if($statement->execute(array($_GET['id']))){
                redirectURL('../librarian_table.php?editstatusdeactivate=success');
                exit();
            }
            redirectURL('../librarian_table.php?editstatusdeactivate=error');
            exit();

        }elseif($_GET['status']=='activate'){
            $sql = 'UPDATE librarian_table SET 
            librarian_status = "Activated" WHERE librarian_id = ? ';
            $statement = $pdo->prepare($sql);

            if($statement->execute(array($_GET['id']))){
                redirectURL('../librarian_table.php?editstatusactivate=success');
                exit();
            }
            redirectURL('../librarian_table.php?editstatusactivate=error');
            exit();
        }
    }else{
        printInConsole('edit librarian error!');
        redirectURL('../librarian_table.php?edit=error');
        exit();
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
