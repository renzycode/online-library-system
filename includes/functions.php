<?php

function printInConsole($message){
    echo '<script> console.log("'.$message.'") </script>';
}

function redirectURL($url){
    echo '<script> window.location.href = "'.$url.'"; </script>';
}

function jsonResponse($args){
    ob_end_clean();
    header('Content-type: application/json');
    echo json_encode(array('msg'=>$args));
    exit();
}