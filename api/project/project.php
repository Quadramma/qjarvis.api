<?php
//PROJECT
define('PROJECT_ROUTE_GETCURRENT', "GET /current");
define('PROJECT_ROUTE_GETALL', "GET /all");
define('PROJECT_ROUTE_SINGLE', "GET /single/@_PROJECT_id:[0-9]+");
define('PROJECT_ROUTE_SAVE', "POST /save");
define('PROJECT_ROUTE_DELETE', "POST /delete");
define('PROJECT_ROUTE_COMBOBOX_ALL', "GET /combobox_all");
//
define('PROJECT_ROUTE_HOURS_GETCURRENT', "GET /hours_current");
define('PROJECT_ROUTE_HOURS_DELETE', "POST /hours_delete");
define('PROJECT_ROUTE_HOURS_GETALL', "GET /hours_all");
define('PROJECT_ROUTE_HOURS_SINGLE', "GET /hours_single/@_id:[0-9]+");
define('PROJECT_ROUTE_HOURS_SAVE', "POST /hours_save");

Flight::route(PROJECT_ROUTE_HOURS_SAVE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    $fields = [
        "_id_project"   =>$data["_id_project"],
        "_id_user"      =>$tokenData->_user_id, //$data["_id_user"]
        "start"         =>$data["start"],
        "end"           =>$data["end"],
        "difference"  =>$data["difference"]
    ];
    if($data["_id"] == -1){
        QJDB::$medoo->insert('qj_project_hours',$fields);
    }else{
        QJDB::$medoo->update('qj_project_hours',$fields,[
            "_id"       =>$data["_id"]
        ]);
    }
    //
    Flight::jsoncallback($rta['response']);
});
Flight::route(PROJECT_ROUTE_HOURS_GETCURRENT, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = array('_id_project' => $_GET["_id_project"]);
    $cols = "prjhours.*";
    $sql = "SELECT ".$cols." FROM qj_project_hours prjhours";
    $sql = $sql .  " WHERE prjhours._id_project = %i_id_project";
    $sql = $sql .  " AND prjhours._id_user = %i_id_user AND prjhours.end is null";
    $item = (DB::query($sql,array(
        "id_user" => $tokenData->_user_id,
        "id_project" => $data["_id_project"],
    )));
    $item = sizeof($item) > 0 ? $item[0] : null;
    $rta['response']['item'] = !$item?null:$item;
    Flight::jsoncallback($rta['response']);
});
Flight::route(PROJECT_ROUTE_HOURS_DELETE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    QJDB::$medoo->delete('qj_project_hours',[
        "_id"=>$data["_id"]
    ]);
    Flight::jsoncallback($rta['response']);
});
Flight::route(PROJECT_ROUTE_HOURS_SINGLE, function($_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    $tokenData= $rta['tokenData'];
    $rta['response']['item'] = Flight::getProjectHoursByID($_id);
    Flight::jsoncallback($rta['response']);
});
Flight::map("getProjectHoursByID",function($_id){
    $cols = "prjhours.*";
    $cols = $cols . ",comp.description as companyName";
    $cols = $cols . ",prj.name as projectName";
    $cols = $cols . ",usr.loginname as userName";
    $sql = "SELECT ".$cols." FROM qj_project_hours prjhours";
    $sql = $sql . " INNER JOIN qj_project prj on prj._id = prjhours._id_project";
    $sql = $sql . " INNER JOIN qj_user usr on usr._id = prjhours._id_user";
    $sql = $sql . " INNER JOIN qj_company comp on comp._id = prj._id_company";
    $sql = $sql .  " WHERE prjhours._id = %i_id";
    $item = DB::query($sql,array(
        "id" => $_id,
    ));
    $item = sizeof($item) > 0 ? $item[0] : null;
    return $item;
});
Flight::route(PROJECT_ROUTE_HOURS_GETALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    
    //$data = QJFlightHelper::getData();//data
    $data = array(
            '_id_project' => $_GET["_id_project"]
        );

    $cols = "prj.name as projectName";
    $cols = $cols. ","."prjhours._id";
    $cols = $cols. ","."prjhours._id_user";
    $cols = $cols. ","."usr.loginname";
    $cols = $cols. ","."prj._id_company";
    $cols = $cols. ","."prjhours._id_project";
    $cols = $cols. ","."prjhours.difference as difference";
    $cols = $cols. ","."prjhours.start";
    $cols = $cols. ","."prjhours.end";
    //
    $sql = "SELECT ".$cols." FROM qj_project_hours prjhours";
    $sql = $sql . " INNER JOIN qj_project prj on prj._id = prjhours._id_project";
    $sql = $sql . " INNER JOIN qj_user usr on usr._id = prjhours._id_user";
    $sql = $sql . " INNER JOIN qj_company comp on comp._id = prj._id_company";
    if((string)$data["_id_project"]!="-1"){
        $sql = $sql . " WHERE";
        $sql = $sql . " prjhours._id_project = %i_id_project";
    }
    $items = DB::query($sql,array(
        "id_project" => $data["_id_project"],
    ));
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});

Flight::route(PROJECT_ROUTE_COMBOBOX_ALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    //$data = QJFlightHelper::getData();//data
    $data = array(
        '_id_company' => isset($_GET["_id_company"])?$_GET["_id_company"]:-1
    );

    $cols = "project._id,project.name as description";
    $sql = "SELECT ".$cols." FROM qj_project project";
    if((string)$data['_id_company'] != '-1'){
        $sql = $sql . " WHERE project._id_company = %i_id_company";    
    }
    $items = DB::query($sql,array(
        "id_company" => $data['_id_company'],
    ));

    
    //
    $rta['response']['items'] = $items;
    $rta['response']['req'] = $data;
    Flight::jsoncallback($rta['response']);
});

Flight::route(PROJECT_ROUTE_DELETE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    QJDB::$medoo->delete('qj_project',[
        "_id"=>$data["_id"]
    ]);
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(PROJECT_ROUTE_SAVE, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    $data = QJFlightHelper::getData();//data
    //
    if($data["_id"] == -1){
         QJDB::$medoo->insert('qj_project',[
            "name"=>$data["name"],
            "description"=>$data["description"],
            "_id_company"=>$data["_id_company"]
        ]);
    }else{
        QJDB::$medoo->update('qj_PROJECT',[
            "name"=>$data["name"],
            "description"=>$data["description"],
            "_id_company"=>$data["_id_company"]
        ],[
            "_id"=>$data["_id"]
        ]);
    }
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(PROJECT_ROUTE_SINGLE, function($_PROJECT_id){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    //
    $cols = "project.*";
    $sql = "SELECT ".$cols." FROM qj_project project WHERE project._id = %i_id";
    $item = DB::query($sql,array(
        "id" => $_PROJECT_id,
    ));
     //
    $rta['response']['item'] = $item[0];
    //
    Flight::jsoncallback($rta['response']);
});


Flight::route(PROJECT_ROUTE_GETALL, function(){
    $rta = Flight::proccessRequestTokenAndResponseData();
    //
    $tokenData= $rta['tokenData'];
    
    //$data = QJFlightHelper::getData();//data
    $data = array(
            '_id_company' => $_GET["_id_company"]
        );

    $cols = "project.name";
    $cols = $cols. ","."project._id";
    $cols = $cols. ","."project.description";
    $cols = $cols. ","."project._id_company";
    $cols = $cols. ","."comp.description as companyDescription";
    $sql = "SELECT ".$cols." FROM qj_project project";
    $sql = $sql . " INNER JOIN qj_company comp on comp._id = project._id_company";
    if($data["_id_company"]!=-1){
        $sql = $sql . " WHERE";
        $sql = $sql . " project._id_company == %i_id_company";
    }
    $items = DB::query($sql,array(
        "id_company" => $data["_id_company"],
    ));
    //
    $rta['response']['items'] = $items;
    Flight::jsoncallback($rta['response']);
});


?>