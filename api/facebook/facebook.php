<?php
define('FACEBOOK_ROUTE_TEST', "GET /status");
define('FACEBOOK_ROUTE_LOGIN', "GET /login");
define('FACEBOOK_ROUTE_LOGIN_VIPSTER', "GET /loginurl/vipster");
define('FACEBOOK_ROUTE_REDIRECT_TO_VIPSTER_APP', "GET /fbredirecttovipsterapp/@code:[0-9]+");

Flight::route(FACEBOOK_ROUTE_LOGIN_VIPSTER, function($appname){
    Flight::setCrossDomainHeaders();
    $ok = true;
    $message = "Everything work just fine";
    $app_id = "815991785078819";
    $app_secret = "0809caf4baa43669dd406aa41e77d231";
    //---------------------------------------------------------
    Facebook\FacebookSession::setDefaultApplication($app_id,$app_secret); 
    $helper = new FacebookRedirectLoginHelper('');
    $fburl = $helper->getLoginUrl();
    //---------------------------------------------------------
    $rta = array(
        "ok"=>$ok,
        "message"=>$message,
        "fburl"=>$fburl
    );
    Flight::jsoncallback($rta);
});



Flight::route(FACEBOOK_ROUTE_REDIRECT_TO_VIPSTER_APP, function(){

});

Flight::route(FACEBOOK_ROUTE_LOGIN, function($code){
//---------------------------------------------------------
//---------------------------------------------------------
    $message = "QJ/Facebook API.";
    $trace = [];
    $graph = array();
    $fb_token = "";
    $app_id = "815991785078819";
    $app_secret = "0809caf4baa43669dd406aa41e77d231";
    $route = "http://www.quadramma.com/pruebas/qjarvis/api/facebook/fbredirecttovipsterapp";
//---------------------------------------------------------
//---------------------------------------------------------
    try{
        $trace[]= "[session.save_path ->" . ROOT . "]";
        ini_set('session.save_path',ROOT);
        session_start();// init app with app id and secret
        Facebook\FacebookSession::setDefaultApplication( $app_id,$app_secret); 
        $trace[]= "[setDefaultApplication success]";
    }catch ( Exception $e ) {
        $trace[]= "[FacebookSession setDefaultApplication exception -> " . $e ."]"; 
    }
    //CASO: No tenemos token
    $helper = new Facebook\FacebookRedirectLoginHelper($route,$app_id,$app_secret);
    try {
        $session = $helper->getSessionFromRedirect();
        $trace[]= "[getSessionFromRedirect success]";
    } catch( Facebook\FacebookRequestException $ex ) {
        $error = $ex;
        $trace[]= "[getSessionFromRedirect  failure ->".$ex."]";  // When Facebook returns an error
    } catch( Exception $ex ) {
        $trace[]= "[getSessionFromRedirect  failure ->".$ex."]"; // When validation fails or other local issues
    }
    if ( isset( $session ) ) { // see if we have a session
        $trace[]= "[session isset  success]"; 
    }else{
        $trace[]= "[session isset  failure]"; 

        echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
        exit;
    }
//---------------------------------------------------------
//---------------------------------------------------------
   $rta = array(
        "response"=> array(
                "ok"=>true,
                "graph"=> $graph,
                "trace"=> $trace,
                "message"=>$message,
                "fb_token"=>$fb_token
            )
   );
   Flight::jsoncallback($rta['response']);
});

Flight::route(FACEBOOK_ROUTE_TEST, function(){
//---------------------------------------------------------
//---------------------------------------------------------
    $message = "QJ/Facebook API.";
    $trace = [];
    $graph = array();
    $fb_token = "";
    $app_id = "815991785078819";
    $app_secret = "0809caf4baa43669dd406aa41e77d231";
    $route = "http://www.quadramma.com/pruebas/qjarvis/api/facebook/test";
//---------------------------------------------------------
    
    try{
        $trace[]= "[session.save_path ->" . ROOT . "]";
        ini_set('session.save_path',ROOT);
        session_start();
        // init app with app id and secret
        Facebook\FacebookSession::setDefaultApplication( $app_id,$app_secret); 
        $trace[]= "[setDefaultApplication success]";
    }catch ( Exception $e ) {
        $trace[]= "[FacebookSession setDefaultApplication exception -> " . $e ."]"; 
    }
    
     //CASO: No tenemos token
    $helper = new Facebook\FacebookRedirectLoginHelper($route,$app_id,$app_secret);
    try {
        $session = $helper->getSessionFromRedirect();
        $trace[]= "[getSessionFromRedirect success]";
    } catch( Facebook\FacebookRequestException $ex ) {
        $error = $ex;
        $trace[]= "[getSessionFromRedirect  failure ->".$ex."]";  // When Facebook returns an error
    } catch( Exception $ex ) {
        $trace[]= "[getSessionFromRedirect  failure ->".$ex."]"; // When validation fails or other local issues
    }


    if ( isset( $session ) ) { // see if we have a session
        $fb_token = $session->getToken();// save the session
        $trace[]= "[getToken  success]"; 
    }else{
        $trace[]= "[getToken  failure -> session isset failed".$ex."]"; 
    }

    if($session != null){
        $requestME = new FacebookRequest( $session, 'GET', '/me' ); // graph api request for user data
        $trace[]= "[FacebookRequest requestME  created]"; 
        $responseME = $requestME->execute();
        $trace[]= "[FacebookRequest responseME  success]"; 
        $graphObject = $response->getGraphObject()->asArray(); // get response
        $trace[]= "[FacebookRequest responseME graphObject success]"; 
        // print profile data
        //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
        $graph = $graphObject;
        // print logout url using session and redirect_uri (logout.php page should destroy the session)
        //echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';
    } else {
        //echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
        $trace[]= "[FacebookSession null -> nothing happens]";     
    }
   
//---------------------------------------------------------
//---------------------------------------------------------
//---------------------------------------------------------
   $rta = array(
        "response"=> array(
                "ok"=>true,
                "graph"=> $graph,
                "trace"=> $trace,
                "message"=>$message,
                "fb_token"=>$fb_token
            )
   );
   Flight::jsoncallback($rta['response']);
});

?>