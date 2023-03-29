<?php

include '../../includes/conn.php';
include '../../includes/functions.php';

if(isset($_POST['delete_transaction'])){

    $sql = 'DELETE FROM transaction_table WHERE transaction_id = ? ';

    $statement = $pdo->prepare($sql);

    $params = array(
        $_POST['id']
    );

    if($statement->execute($params)){
        redirectURL('../transaction_table.php?transaction=returned&delete=success');
    }
}
redirectURL('../transaction_table.php?transaction=returned&delete=error');