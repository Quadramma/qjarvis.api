<?php
	Flight::map("callback",function($data){
	  header("Access-Control-Allow-Headers: Content-Type");
	  header("Access-Control-Allow-Origin: *");
	  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	  echo $data;
	  exit;
	});

	Flight::map("jsoncallback",function($data){
	  header("Access-Control-Allow-Headers: Content-Type");
	  header("Access-Control-Allow-Origin: *");
	  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	  echo json_encode($data);
	  exit;
	});

	
    Flight::map('proccessRequestTokenAndResponseData',function(){
    	Flight::setCrossDomainHeaders();
	    $tokenData = Flight::ValidateToken();
	    $message = 'Everything works just fine';
	    $sessionInfo = Flight::tokenExpiredSeconds($tokenData) . " seconds remain";
	    //
		$response = array(
		        'ok' => true,
		        'message'=>$message,
		        'sessionInfo'=>$sessionInfo,
	    );
	    return array(
	    	'response'=>$response,
	    	'tokenData'=>$tokenData
	    );
    });
?>