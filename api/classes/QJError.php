<?php

define('QJERROR_REGISTRATION_LOGINNAME_REQUIRED', "1000");
define('QJERROR_REGISTRATION_PASSWORD_REQUIRED', "1001");


Flight::map("getErrorDescription",function($errorcode){
	switch($errorcode){
		case QJERROR_REGISTRATION_LOGINNAME_REQUIRED:
			return "QJ Register Loginname required";
			break;
		case QJERROR_REGISTRATION_PASSWORD_REQUIRED:
			return "QJ Register Password required";
			break;
		default:
			return "QJ Error no message attached (".$errorcode.")";
			break;	
	}
});

?>
