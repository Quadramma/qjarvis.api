<?php

//LIBS COMPOSER
require ROOT . '/vendor/autoload.php';

//LIB EXTERNAL
require ROOT . '/libs/medoo.min.php'; 			//MEEDODB
require ROOT . '/libs/meekrodb.2.2.class.php'; 	//MEEKRODB
require ROOT . '/libs/flight/Flight.php';  		//FLIGHT LIB FOR ROUTES
//QJ CLASSES
require ROOT . '/classes/QJError.php';  
require ROOT . '/classes/QJDB.php';        //DB INIT CONFIG
require ROOT . '/classes/QJImageUploader.php';  
require ROOT . '/classes/QJFlightHelper.php';  


//QJ CONFIG
require ROOT . '/config/config.php';  

require ROOT . '/libs/qj_flight_helpers.php';  
require ROOT . '/libs/qj_flight_crossdomain.php';  
require ROOT . '/libs/qj_flight_user.php';  
require ROOT . '/libs/qj_flight_auth.php';  
//MAIN QJ FLIGHT ROUTES
require ROOT . '/config/qjarvis.php';  
?>
