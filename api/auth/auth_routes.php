<?php
//QJ_LOGIN


define('QJ_LOGIN_ROUTE_REGISTER_VIPSTER', "POST /register/vipster");
define('QJ_LOGIN_ROUTE_GETTOKEN', "POST /login");
define('QJ_LOGIN_ROUTE_CHECKTOKEN', "GET /login/@token");
define('QJ_LOGIN_ROUTE_AUTH'    , "POST /login/@id:[0-9]+");

define('QJ_LOGIN_ROUTE_CHANGETOKEN', "POST /changegroup");

Flight::route(QJ_LOGIN_ROUTE_REGISTER_VIPSTER, function($token){    
	Flight::setCrossDomainHeaders();
    $data = QJFlightHelper::getData();//data
    $flightdata = Flight::request()->data;


    if(!isset($data["loginname"]) || $data["loginname"] == ""){
    	Flight::returnwitherror(QJERROR_REGISTRATION_LOGINNAME_REQUIRED); //EXIT
    }
    if(!isset($data["password"]) || $data["password"] == ""){
    	Flight::returnwitherror(QJERROR_REGISTRATION_PASSWORD_REQUIRED); //EXIT
    }
  

/*
    $db = QJDB::$medoo;
    $db->insert("qj_user",[
    		"loginname"=> $data["loginname"],
    		"password"=> $data["password"],
    	]);
    	*/

    Flight::jsoncallback(array('message'=>'just testing!',"data"=>$data,"flightdata"=>$flightdata));
});


Flight::route("GET /test", function($token){
    Flight::setCrossDomainHeaders();
    Flight::jsoncallback(array('message'=>'just testing!'));
});



Flight::route(QJ_LOGIN_ROUTE_CHECKTOKEN, function($token){
    Flight::setCrossDomainHeaders();
    
    $tokenObj = Flight::DecodeToken($token);
    $tokenValidation = Flight::ValidateToken($tokenObj);
    Flight::jsoncallback($tokenValidation);
});



Flight::route(QJ_LOGIN_ROUTE_CHANGETOKEN, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();    
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    //FIX: agregar validacion para que solo pueda cambiar a grupos permitidos para el usuario
    $user = Flight::DB_GetUserByID($tokenData->_user_id,$data['_group_id']);    
    $rta['response']['token'] = base64_encode(json_encode(array(
                "_user_id" => $user["_id"]
                ,"_group_id"=> $user["_group_id"]
                ,"_profile_id"=>$user["_profile_id"]
                ,"tokenExp" => $tokenData->tokenExp
                ,'timeOffset'=> $tokenData->timeOffset
                )));
    $rta['response']['tokenExp'] = $tokenData->tokenExp;
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(QJ_LOGIN_ROUTE_GETTOKEN, function(){
    Flight::setCrossDomainHeaders();
	

    $data = QJFlightHelper::getData();//data

    $user = Flight::DB_GetUserByCredentials($data["loginname"],$data["password"], $data["_group_id"]);
    if($user == null){
        $res = array(
                "ok"=>false
                ,"message"=>"Invalid credentials"
                ,'errorcode'=>QJERRORCODES::$API_INVALID_CREDENTIALS);
        Flight::jsoncallback($res);
    }

    $seconds = (60 * 60) * 24;  //EXPIRATION TIME
    $tokenReq = $data["tokenReq"];
    $tokenExp = $data["tokenReq"] + (1000 * $seconds);

    $serverReqTime = get_millis();
    $serverReqTimeOffset =  $serverReqTime - $tokenReq;

    $res = array(
            "ok"=>true
            ,"message"=>"Everything works just fine"
            ,"loginname" => $data["loginname"]
            ,"token" =>  base64_encode(json_encode(array(
                "_user_id" => $user["_id"]
                ,"_group_id"=> $user["_group_id"]
                ,"_profile_id"=>$user["_profile_id"]
                ,"tokenExp" => $tokenExp
                ,'timeOffset'=> $serverReqTimeOffset
                ))) 
            ,"tokenReq" => $tokenReq
            ,"tokenExp" => $tokenExp
        );
    Flight::jsoncallback($res);
    //Flight::jsoncallback(array("post_loginname"=>$data["loginname"]));
});

?>