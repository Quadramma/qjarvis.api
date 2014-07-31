<?php

class QJImageUploader {
    public static function moveTempFileToTempDirectory($tempFileName,$settings,$response){
        $inputName = $settings["imageFileInputName"];
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $tempFileName);
        $response["trace"][] = "file moved to " . $tempFileName;
        @chmod($tempFileName, 0644);
        return $response;
    }
    public static function configureTempDirectory($tempDir,$response){
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777);
            $response["trace"][] = "directory " . $tempDir ." was successfully created.";
            exit;
        } else {
            $response["trace"][] = "directory " . $tempDir ." founded.";
        }
        return $response;
    }
    public static function generateTempFileName($settings){
        return $settings["imageTempFileNamePrefix"] . $settings["imageFileNameGeneration"]();
    }
    public static function isFileAvailable($inputName) { 
        return (isset($_FILES[$inputName])==true);
    }
    public static function fileExistsAndHasSize($tempFileName){
        return file_exists($tempFileName) && filesize($tempFileName) > 0;
    }
    public static function upload($settings) {
        $response = array(
                "ok" => true,
                "message"=>"Everything work just fine",
                "trace" => array(),
                "path" => ""
            );


		//$response["file"] = $_FILES["fileUpload"];

         


        //VAL #1: existe en FILE
        if(!QJImageUploader::isFileAvailable($settings["imageFileInputName"])){ 
            $response["message"] = "File " . $settings["imageFileInputName"] . " cannot be found in FILES";
            $response["ok"] = false;
            return $response;
        }
        $inputName = $settings["imageFileInputName"];

        //VAL #2: contiene error?
        if ($_FILES['image_file']['error']) {
            $response["message"] = "File " . $settings["imageFileInputName"] . " has errors : " . $_FILES['image_file']['error'];
            $response["ok"] = false;
            return $response;
        }


        //VAL #3: supera tamanio ?
        if($_FILES['image_file']['size'] > $settings["imageMaxSize"] * 1024){
            $response["message"] = "File " . $settings["imageFileInputName"] . " size exeded (" . $settings["imageMaxSize"] .") Kbs";
            $response["trace"][] = "File size: " . $_FILES['image_file']['size'] / 1024 . " Kbs";
            $response["ok"] = false;
            return $response;
        }
        //
        $tempDir = $settings["imageTempFolder"];

        //VAL #4: verifica si la carpeta temporal existe sino la crea
        $response = QJImageUploader::configureTempDirectory($tempDir,$response);
        //

        //-Genera un filename 
        $tempFileNameOnly = QJImageUploader::generateTempFileName($settings);

        //-Genera un nombre para el tempfile
        $tempFileName = $tempDir . "/" . $tempFileNameOnly;
        //
        $response = QJImageUploader::moveTempFileToTempDirectory($tempFileName,$settings,$response);
        //
        //VAL #5: verifica si se movio correctamente el temp file
        if(!QJImageUploader::fileExistsAndHasSize($tempFileName)){ 
            $response["message"] = "File " . $tempFileName . " cannot be found in temp directory or there was and error during moving operation";
            $response["ok"] = false;
            return $response;
        }
        //

        $aSize = getimagesize($tempFileName); // try to obtain image info
        if (!$aSize) {
            @unlink($tempFileName);
            $response["message"] = "File " . $tempFileName . " imposible to extract image info.";
            $response["ok"] = false;
            return $response;
        }


        // check for image type
        switch($aSize[2]) {
            case IMAGETYPE_JPEG:
                $sExt = '.jpg';
                // create a new image from file 
                $vImg = @imagecreatefromjpeg($tempFileName);
                break;
            case IMAGETYPE_PNG:
                $sExt = '.png';
                // create a new image from file 
                $vImg = @imagecreatefrompng($tempFileName);
                break;
            default:
                @unlink($tempFileName);
                $response["message"] = "File " . $tempFileName . " extensions allowed (jpg,png)";
                $response["ok"] = false;
                return $response;
        }


        //
        $iWidth =  $settings["imageCanvasW"];
        $iHeight = $settings["imageCanvasY"];; // desired image result dimensions
        $iJpgQuality = $settings["imageQuality"];
        $response["trace"][] = "creating image canvas...";
        // create a new true color image
        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
        // copy and resize part of an image with resampling
        $response["trace"][] = "resampling image...";
        imagecopyresampled($vDstImg, $vImg, 0, 0
        	, (int)$settings["imageX"], (int)$settings["imageY"], $iWidth, $iHeight
        	, (int)$settings["imageW"], (int)$settings["imageH"]);



        // define a result image filename
        $sResultFileName = $tempFileName . $sExt;
        $response["trace"][] = "moving image...";
        // output image to file
        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
        @unlink($tempFileName);
        //
        $response["filename"] = $tempFileNameOnly . $sExt;
        $response["trace"][] = "Proccess end :)";
        return $response;
    }
}

?>