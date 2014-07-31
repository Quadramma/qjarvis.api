<?php
define('ROOT', dirname(dirname(__FILE__)) ); //public/API/
include ROOT . '/config/includes.php'; 		//QJARVIS API
//

//CHAT
require 'qjchat_routes.php';   
require 'qjchat.php';   

//USES
use Ratchet\Server\IoServer;
use QJChat\Chat;

//ROUTES
Flight::route('/server', function(){
    Flight::setCrossDomainHeaders();
    
    require ROOT . '/vendor/autoload.php';
    $server = IoServer::factory(
        new Chat(),
        8080
    );
    $server->run();
});


Flight::route('/status', function(){
    Flight::setCrossDomainHeaders();
    $request = Flight::request();
    $res = array(
      "ok"=>true,
      "title"=> "QJarvis API | QJChat Status",
      );
    Flight::jsoncallback($res);
});


//
Flight::start();
?>
