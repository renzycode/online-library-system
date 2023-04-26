<?php

//online db 1

//$host = 'bpoks2m9vgtiyskrronx-mysql.services.clever-cloud.com';
//$user = 'u4y7dmqjbvkykhsr';
//$password = 'JX2fJND5b2Ztt0i9bqL0';
//$db = 'bpoks2m9vgtiyskrronx';



//online db 2

$host = 'b2hqvttkuzvtui0fat1z-mysql.services.clever-cloud.com';
$user = 'u80tegkgvgyqohka';
$password = 'tIeOIgfgsNLfzTi8OJ1V';
$db = 'b2hqvttkuzvtui0fat1z';



//$host = 'localhost';
//$user = 'root';
//$password = '';
//$db = 'onlinelibrarysystem';

try {
	$pdo = new PDO("mysql:host=".$host.";dbname=".$db.";charset=UTF8", $user, $password);

	if ($pdo) {
		//echo "<script> console.log('Connected to the ".$db." database successfully!') </script>";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}