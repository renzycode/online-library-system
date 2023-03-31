<?php

include_once "../includes/functions.php";

session_start();
session_unset();
session_destroy();



redirectURL('login.php');




