<?

/*
    using http://www.ipinfodb.com/ as a source for lat and long info
    api key: 6ec0b641be383987a46796ba7a7c0d00c4d11c7602305ae39f447e5fbd88fff4
    my current ip : 174.117.114.172

    http://en.wikipedia.org/wiki/Haversine_formula

    Haversine formula calc taken from:
    Taken from the blog post at http://www.marketingtechblog.com/calculate-distance/

*/

// include location class
require_once('ip2locationlite.class.php');

class location extends ip2location_lite {

    function __construct(){

    }

    function getUserLocation(){

        // setting cookie to cut down on locaiton service requests
        if(!$_COOKIE["gameOn"]){

            $userIp = $_SERVER['REMOTE_ADDR'];
            $apiKey = '6ec0b641be383987a46796ba7a7c0d00c4d11c7602305ae39f447e5fbd88fff4';

            //test with this IP 206.223.170.187
            // says im' in ottawa

            $ipLite = new ip2location_lite;
            $ipLite->setKey($apiKey);

            //Get errors and locations
            $locations = $ipLite->getCity($userIp);
            $errors = $ipLite->getError();

            if (!empty($locations) && is_array($locations)) {

                // user location array
                $userL = array(
                    "countryCode" => $locations['countryCode'],
                    "country" => $locations['countryName'],
                    "region" => $locations['regionName'],
                    "city" => $locations['cityName'],
                    "lat1" => $locations['latitude'],
                    "lng1" => $locations['longitude']);

                // we are checking to see if the user's city has a hockey team,
                // if they do use that $city
                // if they DO NOT we loop through all of the teams and get their lat/lng
                // and compare to the users location
                if($this->checkCityHasTeam($city) == false){

                    // sets the default closest city and distance
                    $closestCity = "";
                    $cityDistance = 10000;

                    // loop through all of the cities and compare their lat and long
                    $query = "SELECT * FROM `teams`";
                    $result = mysql_query($query);

                    while($row = mysql_fetch_assoc($result)){

                        $toCity = $this->getDistanceBetweenPointsNew($userL['lat1'],$userL['lng1'],$row['lat'],$row['lng'],'KM');

                         if ($toCity < $cityDistance){
                            $cityDistance = $toCity;
                            $closestCity = $row['city'];
                         }

                    }

                    $city = $closestCity;

                }

                $data = base64_encode(serialize($city));
                setcookie("gameOn", $data, time()+3600); //set cookie for 1 day

                return ucfirst(strtolower($city));

            }

            // if there is an error we will let the user know
            if (!empty($errors) && is_array($errors)) {
              foreach ($errors as $error) {
                echo var_dump($error) . "<br /><br />\n";
              }
            } else {
                // no need to show that we don't have an error
                //echo "No errors" . "<br />\n";
            }

        }else{

            $city = unserialize(base64_decode($_COOKIE["gameOn"]));
            return ucfirst(strtolower($city));

        }

    }

    function getIpAddress(){

        $userIp = $_SERVER['REMOTE_ADDR'];

        if(!empty($userIp)){
            return true;
        }else{
            return false;
        }

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

}
