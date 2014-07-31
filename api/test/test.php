<?php
define('TEST_ROUTE_ALL', "GET /status");
Flight::route(TEST_ROUTE_ALL, function(){
    Flight::setCrossDomainHeaders();
    $res = array(
        "ok"   => true,
        "message"=>"Api 10 puntos"
        );
    Flight::jsoncallback($res);
});
?>