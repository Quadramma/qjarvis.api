<?php
//BRAND
define('BRAND_ROUTE_ALL', "GET /list");
define('BRAND_ROUTE_SINGLE', "GET /single/@id:[0-9]+");
define('BRAND_ROUTE_CREATE', "POST /create");
define('BRAND_ROUTE_UPDATE', "POST /update/@id:[0-9]+");
define('BRAND_ROUTE_DELETE', "DELETE /delete/@id");

Flight::route(BRAND_ROUTE_ALL, function(){
    Flight::setCrossDomainHeaders();

    $cols = "b._id";
    $cols = $cols. ","."b.description";
    $cols = $cols. ","."(CONCAT(cat.path,'/',img.filename)) as filename";
    
    $sql = "SELECT ".$cols." FROM qj_brand b";
    $sql = $sql . " INNER JOIN qj_image img on img._id = b._image_id";
    $sql = $sql . " INNER JOIN qj_category cat on cat._id = img._category_id";
    $sql = $sql . " INNER JOIN qj_company comp on comp._id = b._company_id";
    //$sql = $sql . " WHERE comp._group_id = 3";
    $rta = DB::query($sql);

    $res = array(
        "ok"   => true,
        "list" => $rta
        );

    Flight::jsoncallback($res);
});

Flight::route('/la', function(){
    header("Access-Control-Allow-Origin: *");
    echo "Vimoda API OK LOL OLO LO LO !!!";
});

?>