<?php
//--------------------------------------------------
/*
Flight::map('error', function(Exception $ex){
    echo $ex->getTraceAsString();
});
Flight::set('flight.log_errors', true);
*/

Flight::map('notFound', function(){
    Flight::setCrossDomainHeaders();
    $message = "Route not found, sorry pal.";
    $request = Flight::request();
    $res = array(
      "ok"=>false,
      "message"=>$message,
      'url'=> $request->url,
      'errorcode'=> QJERRORCODES::$API_ROUTE_NOT_FOUND
      );
    Flight::jsoncallback($res);
});


Flight::route('/', function(){
    Flight::setCrossDomainHeaders();
    $message = "QJarvis API Ok (root)";
    $request = Flight::request();
    $res = array(
      "ok"=>true,
      "message"=>$message,
      );
    Flight::jsoncallback($res);
});


//Flight::start();
?>