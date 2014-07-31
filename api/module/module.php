<?php
//MODULE
define('MODULE_ROUTE_GETMENU', "GET /menu");
//

Flight::map('getMenu',function($tokenData){
	$cols = "module.*";
    //$cols = $cols. ","."module.description";
    //
    $sql = "SELECT ".$cols." FROM qj_menu_module menu_module";
    $sql = $sql . " INNER JOIN qj_menu menu on menu._id=menu_module._menu_id";
    $sql = $sql . " INNER JOIN qj_module module on module._id=menu_module._module_id";
    $sql = $sql . " WHERE ";
    $sql = $sql . "  menu._profile_id = %i_profile_id and menu._group_id = %i_group_id";
    //
    $rta = DB::query($sql,array(
        "group_id" => $tokenData->_group_id,
        "profile_id" => $tokenData->_profile_id,
        ));
    return $rta;
});

Flight::route(MODULE_ROUTE_GETMENU, function(){
    Flight::setCrossDomainHeaders();
    $tokenData = Flight::ValidateToken();
    $message = 'Everything works just fine';
    $sessionInfo = Flight::tokenExpiredSeconds($tokenData) . " seconds remain";
    //-------------------------
    $modules = Flight::getMenu($tokenData);
    //-------------------------
    $rta = array(
        'ok' => true,
        'message'=>$message,
        'sessionInfo'=>$sessionInfo,
        'modules'=> $modules,
    );
    Flight::jsoncallback($rta);
});

?>