<?php

function printInConsole($message){
    echo '<script> console.log("'.$message.'") </script>';
}

function redirectURL($url){
    echo '<script> window.location.href = "'.$url.'"; </script>';
}