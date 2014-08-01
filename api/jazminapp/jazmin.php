<?php

define('JAZMIN_GET_ALL', "GET /all");
define('JAZMIN_GET_CAMPAIGN', "GET /campaign");
define('JAZMIN_GET_COLLECTION', "GET /collection");
define('JAZMIN_GET_LOOKBOOK', "GET /lookbook");
define('JAZMIN_GET_ACCESSORIES', "GET /accessories");
define('JAZMIN_GET_VIDEO', "GET /video");



Flight::route(JAZMIN_GET_ALL, function(){
  Flight::setCrossDomainHeaders();
  Flight::echoJazminData(Flight::getJazminData());
});

Flight::route(JAZMIN_GET_CAMPAIGN, function(){
  Flight::setCrossDomainHeaders();
  $data = Flight::getJazminData();
  Flight::echoJazminData($data->campaign);
});
Flight::route(JAZMIN_GET_COLLECTION, function(){
  Flight::setCrossDomainHeaders();
  $data = Flight::getJazminData();
  Flight::echoJazminData($data->collection);
});
Flight::route(JAZMIN_GET_LOOKBOOK, function(){
  Flight::setCrossDomainHeaders();
  $data = Flight::getJazminData();
  Flight::echoJazminData($data->lookbook);
});
Flight::route(JAZMIN_GET_ACCESSORIES, function(){
  Flight::setCrossDomainHeaders();
  $data = Flight::getJazminData();
  Flight::echoJazminData($data->accessories);
});
Flight::route(JAZMIN_GET_VIDEO, function(){
  Flight::setCrossDomainHeaders();
  $data = Flight::getJazminData();
  Flight::echoJazminData($data->video);
});

Flight::map('echoJazminData', function($data){
   Flight::jsoncallback(array(
      "ok"=>1,
      "data"=> $data,
      "errorcode"=>""
  )); 
});
Flight::map('putJazminData', function($collection){
    file_put_contents("data.json", json_encode($collection));
});
Flight::map('getJazminData', function(){
  $my_file = "data.json";
    $collection = array();
    if (file_exists($my_file)) {
      $collection =  json_decode(file_get_contents($my_file));
  }else{
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
    fclose($handle);
  }
    return $collection;
});



?>