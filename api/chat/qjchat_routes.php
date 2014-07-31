<?php

Flight::route('GET /list', function(){ //(/@id:[0-9]+)
 	$rta = Flight::proccessRequestTokenAndResponseData();	
   	$tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "cm.message";
    $cols = $cols . ",cm._id";
    $cols = $cols . ",usr.loginname";
    //
    $sql = "SELECT ".$cols." FROM qj_chat_message cm";    
    $sql = $sql . " INNER JOIN qj_user usr on usr._id = cm._user_id";
    $sql = $sql . " WHERE cm._chat_id = 1";
    //
    $items = DB::query($sql,array(
    	"id" => $tokenData->_user_id
    ));

    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

Flight::route('POST /save', function(){ //(/@id:[0-9]+)
 	$rta = Flight::proccessRequestTokenAndResponseData();	
   	$tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->insert('qj_chat_message',[
        "message"	=>	$data["message"],
        "_chat_id"	=>	$data["_chat_id"],
        "_user_id"	=>	$tokenData->_user_id
    ]);
    //
    Flight::jsoncallback($rta['response']);
});

?>