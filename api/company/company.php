<?php
//COMPANY
define('COMPANY_ROUTE_GETCURRENT', "GET /current");
define('COMPANY_ROUTE_GETALL', "GET /all");
define('COMPANY_ROUTE_SINGLE', "GET /single/@_COMPANY_id:[0-9]+");
define('COMPANY_ROUTE_SAVE', "POST /save");

define('COMPANY_ROUTE_COMBOBOX_ALL', "GET /combobox_all");
//

Flight::route(COMPANY_ROUTE_COMBOBOX_ALL, function($_COMPANY_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $items = QJDB::$medoo->select('qj_company',[
            "_id","description"]
    );
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

/*
Flight::route(COMPANY_ROUTE_SAVE, function($_COMPANY_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->update('qj_COMPANY',[
            "loginname"=>$data["loginname"],
            "first_name"=>$data["first_name"],
            "last_name"=>$data["last_name"]
        ],[
            "_id"=>$data["_id"]
        ]);
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(COMPANY_ROUTE_GETCURRENT, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $COMPANY = Flight::DB_GetCOMPANYByID($tokenData->_COMPANY_id,$tokenData->_group_id);
    $rta['response']['COMPANY'] = $COMPANY;
    //
    Flight::jsoncallback($rta['response']);
});

Flight::route(COMPANY_ROUTE_SINGLE, function($_COMPANY_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $COMPANY = Flight::DB_GetCOMPANYByID($_COMPANY_id,$tokenData->_group_id);
    $rta['response']['COMPANY'] = $COMPANY;
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(COMPANY_ROUTE_GETALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    //$tokenData= $rta['tokenData'];
    $cols = "COMPANY.*";
    //$cols = $cols. ","."usrgrp.description as COMPANYgroup_description";
    //$cols = $cols. ","."grp.description as group_description";
    //$cols = $cols. ","."usrgrp_grp._group_id";
    //$cols = $cols. ","."usrgrp_grp._profile_id";
    //
    $sql = "SELECT ".$cols." FROM qj_COMPANY COMPANY";
    //$sql = $sql . " INNER JOIN qj_group grp on grp._id = %i_group_id";
    //$sql = $sql . " INNER JOIN qj_COMPANYgroup usrgrp on usrgrp._id = COMPANY._COMPANYgroup_id";
    //$sql = $sql . " INNER JOIN qj_COMPANYgroup_group usrgrp_grp on usrgrp_grp._COMPANYgroup_id = COMPANY._COMPANYgroup_id and _group_id = %i_group_id";
    //
    $items = DB::query($sql,array(
      //  "group_id" => QJ_GROUP_ID,
        ));
    $rta['response']['items'] = $items;
    //
    Flight::jsoncallback($rta['response']);
});

*/
?>