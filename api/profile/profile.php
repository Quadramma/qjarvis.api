<?php
define('PROFILE_ROUTE_COMBOBOX_ALL', "GET /combobox_all");
define('PROFILE_ROUTE_SINGLE', "GET /single/@_id:[0-9]+");
define('PROFILE_ROUTE_SAVE', "POST /save");
define('PROFILE_ROUTE_DELETE', "POST /delete");

Flight::route(PROFILE_ROUTE_DELETE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->delete('qj_profile',[
        "_id"=>$data["_id"]
    ]);
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(PROFILE_ROUTE_SAVE, function($id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    if(QJDB::$medoo->has('qj_profile',['_id'=>$data['_id']])){
        QJDB::$medoo->update('qj_profile',[
            "description"   =>  $data["description"]
        ],[
            "_id"=>$data["_id"]
        ]);    
    }else{
        QJDB::$medoo->insert('qj_profile',[
            "description"   =>  $data["description"]
        ]);    
    }
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(PROFILE_ROUTE_COMBOBOX_ALL, function($_user_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "prf._id";
    $cols = $cols. ","."prf.description";
    //
    $sql = "SELECT ".$cols." FROM qj_profile prf";
    //
    $items = DB::query($sql,array(
        ));
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

Flight::route(PROFILE_ROUTE_SINGLE, function($_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $rta['response']['item'] = Flight::getProfileByID($_id);
    Flight::jsoncallback($rta['response']);
});
Flight::map("getProfileByID",function($_id){
    $cols = "p.*";
    $sql = "SELECT ".$cols." FROM qj_profile p WHERE p._id = %i_id";
    $item = DB::query($sql,array(
        "id" => $_id,
    ));
    $item = sizeof($item) > 0 ? $item[0] : null;
    return $item;
});


?>