<?

require_once('../../_app/_classes/connect.php');

/*

Taken from the blog post at http://www.marketingtechblog.com/calculate-distance/

http://en.wikipedia.org/wiki/Haversine_formula

SQL - MILES

$qry = "SELECT *,(((acos(sin((".$latitude."*pi()/180)) * sin((`Latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((".$longitude."- `Longitude`)*pi()/180))))*180/pi())*60*1.1515) as distance FROM `MyTable` WHERE distance >= ".$distance."

SQL - KM

$qry = "SELECT *,(((acos(sin((".$latitude."*pi()/180)) * sin((`Latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((".$longitude."- `Longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM `MyTable` WHERE distance >= ".$distance."

*/

require_once('../_classes/ip2locationlite.class.php');

$userIp = $_SERVER['REMOTE_ADDR'];
$apiKey = '6ec0b641be383987a46796ba7a7c0d00c4d11c7602305ae39f447e5fbd88fff4';

$ipLite = new ip2location_lite;
$ipLite->setKey($apiKey);

$locations = $ipLite->getCity($userIp);

$city = 'asdfasdfasdf';
$lat1 = $locations['latitude'];
$lng1 = $locations['longitude'];

$lat1 = 46.3;
$lng1 = -72.3;

//print_r($locations);

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi'){
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;

    switch($unit){
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }

    return (round($distance,2));
}

function checkCityHasTeam($city){

    $query = "SELECT * FROM `teams` WHERE `city` = '$city'";
    $result = mysql_query($query);

    if(mysql_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }

}


if(checkCityHasTeam($city) == false){

    $closestCity = "";
    $cityDistance = 10000;

    // loop through all of the cities and compare their lat and long

    $query = "SELECT * FROM `teams`";
    $result = mysql_query($query);

    while($row = mysql_fetch_assoc($result)){

         $toCity = getDistanceBetweenPointsNew($lat1,$lng1,$row['lat'],$row['lng'],'KM');

        echo $toCity . "<br />";

         if ($toCity < $cityDistance){
            $cityDistance = $toCity;
            $closestCity = $row['city'];
         }

    }

    $city = $closestCity;

    echo "---" . $city . "---";

}
