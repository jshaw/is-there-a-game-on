<?

    require_once('../_app/_classes/connect.php');
    require_once('../_app/_classes/GamesClass.php');

    $service = $_GET['service'];
    $city = $_GET['city'];

    $getGames = new games($city);

    // sends back the json request
    header('Cache-Control: no-cache, must-revalidate');
    header("Content-type: application/json");

    switch ($service) {
        case 'getLocalGameHeader':
            $return = $getGames->getLocalGameHeader(true);
            break;
        case 'getLocalGames':
            $return = $getGames->getLocalGames(true);
            break;
        case 2:
            echo "i equals 2";
            break;
    }
?>
