<?php

	Flight::map("DB_GetUserByID",function($id, $_group_id){
	    $cols = "user._id";
	    $cols = $cols. ","."user.loginname";
	    $cols = $cols. ","."user.password";
	    $cols = $cols. ","."user.first_name";
	    $cols = $cols. ","."user.last_name";
	    $cols = $cols. ","."user._usergroup_id";
	    $cols = $cols. ","."usrgrp.description as usergroup_description";
	    $cols = $cols. ","."usrgrp_grp._group_id";
	    $cols = $cols. ","."grp.description as group_description";
	    
	    $cols = $cols. ","."usrgrp_grp._profile_id";
	    $cols = $cols. ","."prf.description as profile_description";
	    //
	    $sql = "SELECT ".$cols." FROM qj_user user";
	    $sql = $sql . " INNER JOIN qj_group grp on grp._id = %i_group_id";
	    $sql = $sql . " INNER JOIN qj_usergroup usrgrp on usrgrp._id = user._usergroup_id";
	    $sql = $sql . " INNER JOIN qj_usergroup_group usrgrp_grp on usrgrp_grp._usergroup_id = user._usergroup_id and _group_id = %i_group_id";
	    $sql = $sql . " INNER JOIN qj_profile prf on prf._id = usrgrp_grp._profile_id";
	    $sql = $sql . " WHERE user._id = %i_id";
	    //
	    $rta = DB::query($sql,array(
	        "group_id" => $_group_id,
	        "id" => $id
	        ));
	    return $rta[0];
	});

	
	Flight::map("DB_GetUserByCredentials",function($loginname,$password ,$_group_id){
	    $cols = "user._id";
	    $cols = $cols. ","."user.loginname";
	    $cols = $cols. ","."user.password";
	    $cols = $cols. ","."usrgrp_grp._group_id";
	    $cols = $cols. ","."usrgrp_grp._profile_id";

	    $sql = "SELECT ".$cols." FROM qj_user user";
	    $sql = $sql . " INNER JOIN qj_usergroup_group usrgrp_grp on usrgrp_grp._usergroup_id = user._usergroup_id and _group_id = %i_group_id";
	    $sql = $sql . " WHERE user.loginname = %s_loginname AND user.password = %s_password";

	    $rta = DB::query($sql,array(
	        "group_id" => $_group_id,
	        "loginname" => $loginname
	        ,"password" => base64_encode($password)
	        ));
	    
	  

	    if(json_encode($rta) == "[]"){
	        return null;
	    }    
	    

	    //echo json_encode($rta);
	    //exit;

	    return $rta[0];
	});

?>