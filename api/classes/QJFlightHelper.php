<?php
class QJFlightHelper{
    public static function getData() {
        return json_decode(file_get_contents('php://input'),TRUE);
    }
}



//snippets

function get_millis(){
  list($usec, $sec) = explode(' ', microtime());
  return (int) ((int) $sec * 1000 + ((float) $usec * 1000));
}


?>