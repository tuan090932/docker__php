<?php

session_start();
$user = $_SESSION['user'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../app/Routing/Routes.php';
//require_once './app/Routing/Routes.php';

//phpinfo();
