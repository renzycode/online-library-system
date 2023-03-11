<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_catalog'])){
    $catalog_id = $_POST['id'];

    $sql = 'DELETE FROM catalog_table WHERE catalog_id = ? ';

    $statement = $pdo->prepare($sql);

    $statement->bindParam(1, $catalog_id);

    if($statement->execute()){
        redirectURL('../catalog.php?delete=success');
    }
}
redirectURL('../catalog.php?delete=error');