<?php
//FILE
define('FILE_ROUTE_CHECK',  "GET /");
define('FILE_ROUTE_UPLOAD', "POST /upload");
define('FILE_ROUTE_CHECK_POST', "POST /check");

Flight::route(FILE_ROUTE_CHECK, function(){
    Flight::setCrossDomainHeaders();
    $rta = array(
        "Info" => "QJ-Api-File OK"
    );
    Flight::jsoncallback($rta);
});

Flight::route(FILE_ROUTE_CHECK_POST, function(){
    Flight::setCrossDomainHeaders();
    $rta = array(
        "Info" => "QJ-Api-File-Check-POST OK",
        "POST" => $_POST
    );
    Flight::jsoncallback($rta);
});

Flight::route(FILE_ROUTE_UPLOAD, function(){
    Flight::setCrossDomainHeaders();
    $fileInputName = $_POST["fileInputName"];
    $rta = Flight::uploadImage($fileInputName,"images");
    Flight::jsoncallback($rta);
});



Flight::map("uploadImage",function($fileInputName,$uploadFolder){
    //
    $extraMessage = "";
    //VAL #0: existe en FILE
    if(!isset($_POST["fileInputName"]) || $_POST["fileInputName"]==""){ 
        $extraMessage = " [fieldValue 'fileInputName' required] ";
    }
    //
    $width = 0;
    $height = 0;
    if (isset($_FILES[$fileInputName])) {
        $filename = $_FILES[$fileInputName]['tmp_name'];
        list($width, $height) = getimagesize($filename);
    }
    //
    $settings = array(
        "imageFileInputName"=>$fileInputName,
        "imageTempFileNamePrefix"=>"image_",
        "imageFileNameGeneration"=> function(){
            return md5(time().rand()) . "_gen";
        },
        "imageCanvasW" => $width,
        "imageCanvasY" => $height,
        "imageTempFolder" => $uploadFolder,
        "imageMaxSize"=> 2048,
        "imageQuality"=> 90,
        "imageX" => 0,
        "imageY" => 0,
        "imageW" => $width,
        "imageH" => $height
    );
    //
    $root = "http://www.quadramma.com/pruebas/qjarvis/api/file";
    $root = $root . "/" . $settings["imageTempFolder"];
    $response = QJImageUploader::upload($settings);
    //
    $rta = array(
        "ok"=>$response["ok"]?"1":"0",
        "root"=> $root,
        "filename"=>$response["filename"],
        "url" => $root . '/' . $response["filename"],
        "message"=> $extraMessage . $response["message"]
    );
    return $rta;
});




?>