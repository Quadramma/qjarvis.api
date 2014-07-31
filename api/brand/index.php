<?php
define('ROOT', dirname(dirname(__FILE__)) ); //public/API/
include ROOT . '/config/includes.php'; 		//QJARVIS API
//
//ROUTES
require 'brand.php';    //ROUTES
//require 'brand_collection.php';    //ROUTES
//require 'brand_collection_category.php';    //ROUTES
//require 'brand_album.php';    //ROUTES
//require 'brand_album_items.php';    //ROUTES    
//
Flight::start();
?>
