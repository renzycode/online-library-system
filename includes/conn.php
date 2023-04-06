<?php

// online db
// $host = 'b64jrih3qbsoq7z8qhd7-mysql.services.clever-cloud.com';
// $user = 'ubltee2psvzbkjll';
// $password = 'N8o0g8xlGV5l9IFVr9c0';
// $db = 'b64jrih3qbsoq7z8qhd7';

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'onlinelibrarysystem';

try {
	$pdo = new PDO("mysql:host=".$host.";dbname=".$db.";charset=UTF8", $user, $password);

	if ($pdo) {
		//echo "<script> console.log('Connected to the ".$db." database successfully!') </script>";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}

mysql://ubltee2psvzbkjll:N8o0g8xlGV5l9IFVr9c0@b64jrih3qbsoq7z8qhd7-mysql.services.clever-cloud.com:3306/b64jrih3qbsoq7z8qhd7