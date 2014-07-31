<?php
//USER
define('GROUP_ROUTE_COMBOBOX', "GET /combobox_assoc");


Flight::route(GROUP_ROUTE_COMBOBOX, function($_user_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "grp._id";
    $cols = $cols. ","."grp.description";
    //
    $sql = "SELECT ".$cols." FROM qj_user user";
    $sql = $sql . " INNER JOIN qj_usergroup usrgrp on usrgrp._id = user._usergroup_id";
    $sql = $sql . " INNER JOIN qj_usergroup_group usrgrp_grp on usrgrp_grp._usergroup_id = user._usergroup_id";
    $sql = $sql . " INNER JOIN qj_group grp on grp._id = usrgrp_grp._group_id";
    $sql = $sql . " WHERE user._id = %i_id";
    //
    $items = DB::query($sql,array(
        "id" => $tokenData->_user_id
        ));

    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

define('GROUP_ROUTE_COMBOBOX_ALL', "GET /combobox_all");


Flight::route(GROUP_ROUTE_COMBOBOX_ALL, function($_user_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $cols = "grp.*";
    $sql = "SELECT ".$cols." FROM qj_group grp";    
    //
    $items = DB::query($sql,array(
        "id" => $tokenData->_user_id
        ));

    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});



?>