<?php
define('ROOT', dirname(dirname(__FILE__)) ); //public/API/
include ROOT . '/config/includes.php'; 		//QJARVIS API
// include required files form Facebook SDK
// added in v4.0.5
require_once( ROOT . "/libs/" . 'Facebook/FacebookHttpable.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookCurl.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookCurlHttpClient.php' );
// added in v4.0.0
require_once( ROOT . "/libs/" . 'Facebook/FacebookSession.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookRequest.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookResponse.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookSDKException.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookRequestException.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookOtherException.php' );
require_once( ROOT . "/libs/" . 'Facebook/FacebookAuthorizationException.php' );
require_once( ROOT . "/libs/" . 'Facebook/GraphObject.php' );
require_once( ROOT . "/libs/" . 'Facebook/GraphSessionInfo.php' );
//
// added in v4.0.5
use Facebook\FacebookHttpable;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
 
// added in v4.0.0
use Facebook\FacebookSession as FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
//ROUTES
require 'facebook.php';    
//
Flight::start();
?>
