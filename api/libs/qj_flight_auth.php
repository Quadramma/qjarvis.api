<?php


	class QJERRORCODES {
	    public static $API_TOKEN_EXPIRED = 3;
	    public static $API_INVALID_TOKEN = 4;
	    public static $API_INVALID_CREDENTIALS = 5;
	    public static $API_ROUTE_NOT_FOUND = 6;
	}
	Flight::map("DecodeToken",function($token){
	    $tokenDecoded = base64_decode($token);
	    return json_decode($tokenDecoded);
	});
	Flight::map('TokenFailure',function($errorcode,$message){
		Flight::jsoncallback(array(
	    		'ok'=>false,
	    		'message'=>$message,
	    		'errorcode'=>$errorcode
	    ));
	});
	Flight::map('isTokenExpired',function($tokenData){
		$serverReqTime = get_millis();
	    $serverReqTimeFixed =  $serverReqTime + $tokenData->timeOffset;
	    $diff = $tokenData->tokenExp - $serverReqTimeFixed;
	    return ($diff < 0) ? true : false;
	});
	Flight::map('tokenExpiredSeconds',function($tokenData){
		$serverReqTime = get_millis();
	    $serverReqTimeFixed =  $serverReqTime + $tokenData->timeOffset;
	    $diff = $tokenData->tokenExp - $serverReqTimeFixed;
	    return abs($diff) / 1000;
	});
	Flight::map("ValidateToken",function(){
	    $headers = getallheaders();
    	$hasToken = (isset($headers["auth-token"])  &&$headers["auth-token"] != "");
    	$token = (isset($headers["auth-token"])?$headers["auth-token"]:"");
    	//
    	//fix
    	if(!$hasToken){
    		$hasToken = (isset($headers["Auth-Token"])  &&$headers["Auth-Token"] != "");
    		$token = (isset($headers["Auth-Token"])?$headers["Auth-Token"]:"");
    	}

	    if($hasToken){
	 		$tokenData = Flight::DecodeToken($token);
	    	/*
	 		//DB User
		    $user = Flight::DB_GetUserByID($tokenObj->_user_id);
		    
		    //Group validation
		    if($tokenObj->_group_id != $user["_group_id"]){
		        $message = "Token Validation Fail (_group_id). You try to hack something? We hire you: javi@quadramma.com";
		        $errorcode = QJERRORCODES::$API_INVALID_TOKEN;
		        $ok = false;
		    }

		    //Profile validation
		    if($tokenObj->_profile_id != $user["_profile_id"]){
		        $message = "Token Validation Fail (_profile_id). You try to hack something? We hire you: javi@quadramma.com";
		        $errorcode = QJERRORCODES::$API_INVALID_TOKEN;
		        $ok = false;
		    }
		    */
		    if(Flight::isTokenExpired($tokenData)){
		    	$seconds = Flight::tokenExpiredSeconds($tokenData);
		    	Flight::TokenFailure(QJERRORCODES::$API_TOKEN_EXPIRED,'Token expired ($seconds ago)');
		    }
			return $tokenData;
	    }else{
			Flight::TokenFailure(QJERRORCODES::$API_INVALID_TOKEN,'Invalid token (token not found in request)');
			exit;
	    }
	});


?>