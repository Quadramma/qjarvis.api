<?php


define('QJ_GROUP_ID', "2");


function QJConfigure(){

	//DB CONFIG XAMPP
	$dbname 	= "lc000386_qjarvis";
	$dbserver 	= "localhost";
	$dbuser 	= 'root';
	$dbpass		= '';
	$port		= '3306'; //default 3306
/*
	//DB CONFIG
	$dbname 	= "lc000386_qjarvis";
	$dbserver 	= "localhost";
	$dbuser 	= 'lc000386_qjarvis';
	$dbpass		= 'Gugurama12';
	$port		= '3306'; //default 3306
	*/
	
	QJDB::$medoo = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => $dbname, 
		'server' 		=> $dbserver, 
		'username' 		=> $dbuser,
		'password' 		=> $dbpass,
		'port' 			=> $port,
	));

	DB::$user 		= $dbuser;
	DB::$password 	= $dbpass;
	DB::$dbName 	= $dbname;
	DB::$host 		= $dbserver;
	DB::$port 		= $port;
}
QJConfigure();

	

?>