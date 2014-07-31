<?php
define('ROOT', dirname(dirname(__FILE__)) ); //public/API/
include ROOT . '/config/includes.php'; 		//QJARVIS API
//
include ROOT . '/auth/auth_routes.php';    //ROUTES
//
Flight::start();
?>

