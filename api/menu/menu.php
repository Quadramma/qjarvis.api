<?php
//MODULE
define('MODULE_ROUTE_GETMENU_COMBOBOX_ALL', "GET /combobox_all");

define('MENU_ROUTE_POST_SAVE', "POST /save");
define('MENU_ROUTE_GET_SINGLE', "GET /single/@id:[0-9]+");
//

Flight::map('menu_combobox_all',function($tokenData){
	$cols = "menu.*";
    //
    $sql = "SELECT ".$cols." FROM qj_menu menu";
    //
    $rta = DB::query($sql,array(
        "group_id" => $tokenData->_group_id,
        "profile_id" => $tokenData->_profile_id,
        ));
    return $rta;
});

Flight::route(MODULE_ROUTE_GETMENU_COMBOBOX_ALL, function(){
    Flight::setCrossDomainHeaders();
    $tokenData = Flight::ValidateToken();
    $message = 'Everything works just fine';
    $sessionInfo = Flight::tokenExpiredSeconds($tokenData) . " seconds remain";
    //-------------------------
    $items = Flight::menu_combobox_all($tokenData);
    //-------------------------
    $rta = array(
        'ok' => true,
        'message'=>$message,
        'sessionInfo'=>$sessionInfo,
        'items'=> $items,
    );
    Flight::jsoncallback($rta);
});


Flight::route(MENU_ROUTE_POST_SAVE, function($id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    if(QJDB::$medoo->has('qj_menu',['_id'=>$data['_id']])){
        QJDB::$medoo->update('qj_menu',[
            "description"   =>  $data["description"],
            "_group_id"     =>  $data["_group_id"],
            "_profile_id"   =>  $data["_profile_id"]
        ],[
            "_id"=>$data["_id"]
        ]);    
    }else{
        QJDB::$medoo->insert('qj_menu',[
            "description"   =>  $data["description"],
            "_group_id"     =>  $data["_group_id"],
            "_profile_id"   =>  $data["_profile_id"]
        ]);    
    }
    
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(MENU_ROUTE_GET_SINGLE, function($id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "menu.*";
    $sql = "SELECT ".$cols." FROM qj_menu menu WHERE menu._id = %i_menu_id";
    $items = DB::query($sql,array('menu_id'=>$id));
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});
?>