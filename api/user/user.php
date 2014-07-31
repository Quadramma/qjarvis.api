<?php
//USER
define('USER_ROUTE_GETCURRENT', "GET /current");
define('USER_ROUTE_GETALL', "GET /all");
define('USER_ROUTE_SINGLE', "GET /single/@_user_id:[0-9]+");
define('USER_ROUTE_SAVE', "POST /save");
//


define('USER_ROUTE_COMBOBOX_ALL', "GET /combobox_all");
//

Flight::route(USER_ROUTE_COMBOBOX_ALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $items = QJDB::$medoo->select('qj_user',[
            "_id","loginname(description)"]
    );
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

Flight::route(USER_ROUTE_SAVE, function($_user_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->update('qj_user',[
            "loginname"=>$data["loginname"],
            "first_name"=>$data["first_name"],
            "last_name"=>$data["last_name"],
            "password"=> base64_encode($data["password"]),
        ],[
            "_id"=>$data["_id"]
        ]);
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(USER_ROUTE_GETCURRENT, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $user = Flight::DB_GetUserByID($tokenData->_user_id,$tokenData->_group_id);
    $rta['response']['user'] = $user;
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(USER_ROUTE_SINGLE, function($_user_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $user = Flight::DB_GetUserByID($_user_id,$tokenData->_group_id);
    $rta['response']['user'] = $user;
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(USER_ROUTE_GETALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    //$tokenData= $rta['tokenData'];
    $cols = "user.*";
    //$cols = $cols. ","."usrgrp.description as usergroup_description";
    //$cols = $cols. ","."grp.description as group_description";
    //$cols = $cols. ","."usrgrp_grp._group_id";
    //$cols = $cols. ","."usrgrp_grp._profile_id";
    //
    $sql = "SELECT ".$cols." FROM qj_user user";
    //$sql = $sql . " INNER JOIN qj_group grp on grp._id = %i_group_id";
    //$sql = $sql . " INNER JOIN qj_usergroup usrgrp on usrgrp._id = user._usergroup_id";
    //$sql = $sql . " INNER JOIN qj_usergroup_group usrgrp_grp on usrgrp_grp._usergroup_id = user._usergroup_id and _group_id = %i_group_id";
    //
    $items = DB::query($sql,array(
      //  "group_id" => QJ_GROUP_ID,
        ));
    $rta['response']['items'] = $items;
    //
    Flight::jsoncallback($rta['response']);
});


?>