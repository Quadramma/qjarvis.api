<?php
//USER
define('USERGROUP_ROUTE_COMBOBOX', "GET /combobox");
define('USERGROUP_ROUTE_COMBOBOX_ACCESS', "GET /combobox_access");
define('USERGROUP_ROUTE_LVWDATA', "GET /lvwdata");
define('USERGROUP_ROUTE_SINGLE', "GET /single/@_id:[0-9]+");
define('USERGROUP_ROUTE_SAVE', "POST /save");
define('USERGROUP_ROUTE_DELETE', "POST /delete");

Flight::route(USERGROUP_ROUTE_LVWDATA, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "usrgrp.*";
    $cols = $cols . ",p.description as profileDescription";
    $sql = "SELECT ".$cols." FROM qj_usergroup usrgrp";
    $sql = $sql . " INNER JOIN qj_profile p on p._id = usrgrp._id_profile";
    $rta['response']['items'] = DB::query($sql,array(
    ));
    //
    Flight::jsoncallback($rta['response']);
});
Flight::route(USERGROUP_ROUTE_DELETE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->delete('qj_usergroup',[
        "_id"=>$data["_id"]
    ]);
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(USERGROUP_ROUTE_SAVE, function($id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $fields = [
            "description"   =>  $data["description"],
            "_id_profile"   =>  $data["_id_profile"]
        ];
    if(QJDB::$medoo->has('qj_usergroup',['_id'=>$data['_id']])){
        QJDB::$medoo->update('qj_usergroup',$fields,[
            "_id"=>$data["_id"]
        ]);    
    }else{
        QJDB::$medoo->insert('qj_usergroup',$fields);    
    }
    //

    $rta['response']['post']= $data;

    Flight::jsoncallback($rta['response']);
});



Flight::route(USERGROUP_ROUTE_SINGLE, function($_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $rta['response']['item'] = Flight::getUsergroupByID($_id);
    Flight::jsoncallback($rta['response']);
});
Flight::map("getUsergroupByID",function($_id){
    $cols = "p.*";
    $sql = "SELECT ".$cols." FROM qj_usergroup p WHERE p._id = %i_id";
    $item = DB::query($sql,array(
        "id" => $_id,
    ));
    $item = sizeof($item) > 0 ? $item[0] : null;
    return $item;
});


Flight::route(USERGROUP_ROUTE_COMBOBOX_ACCESS, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
  	$cols = "usrgrp.*";
    //$cols = $cols. ",(select 1 from qj_user u where u._id = %i_id_user and u._usergroup_id = usrgrp._id) as access";
    $sql = "SELECT ".$cols." FROM qj_usergroup usrgrp";
    $sql = $sql . " INNER JOIN qj_user u on u._id = %i_id_user and u._usergroup_id = usrgrp._id ";
    $rta['response']['items'] = DB::query($sql,array(
      "id_user" => $tokenData->_user_id
    ));
    //$rta['response']['items'] = QJDB::$medoo->select('qj_usergroup','*');
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(USERGROUP_ROUTE_COMBOBOX, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $rta['response']['items'] = QJDB::$medoo->select('qj_usergroup','*');
    //
    Flight::jsoncallback($rta['response']);
});


?>