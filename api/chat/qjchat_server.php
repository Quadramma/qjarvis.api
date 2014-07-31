<?php
define('ROOT', dirname(dirname(__FILE__)) ); //public/API/
include ROOT . '/config/includes_server.php'; 		//QJARVIS API
require ROOT . '/vendor/autoload.php';
require 'qjchat.php';   

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use QJChat\Chat;
	

  $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        1340
    );

$server->run();


?>