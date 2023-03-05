<?php


$mysqli = new mysqli("localhost","root","","library_management_system");

// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}else{
    echo "<script>console.log('connected successfully to MySQL');</script>";
}