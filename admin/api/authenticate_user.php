<?php
include_once "../../includes/conn.php";
include_once "../../includes/functions.php";


$admin = "admina";

$sql = "SELECT * FROM librarian_table WHERE librarian_uname = ?";

$statement = $pdo->prepare($sql);


$statement->bindParam(1, $admin);

$statement->execute();

$librarian = $statement->fetchAll();

if(count($librarian)>0){
    jsonResponse('success');
}

jsonResponse('error');
        