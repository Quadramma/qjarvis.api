<?php
Flight::map("setCrossDomainHeaders",function(){
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
});
Flight::route("OPTIONS *",function(){
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
});

Flight::route("OPTIONS /*/*",function(){
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
});
?>