<?

    // updates all of the logos for the teams based upon team name. Sets them to the urls in the
    // _assets/_img/_logos/nhl folder

    require_once('_app/_classes/connect.php');


    $query = "UPDATE teams SET logo = " . teamName . " WHERE some_column=some_value";

    $query = "SELECT * FROM teams";
    $result = mysql_query($query);

    while($row = mysql_fetch_assoc($result)){
        $tm = $row['teamName'];
        $url = "_assets/_img/_logos/nhl/" . str_replace(" ", "-",strtolower($tm)) . ".jpg";

        $updateQuery = "UPDATE teams SET logo = '" . $url . "' WHERE teamName='" . $row['teamName'] . "'";
    }

?>
