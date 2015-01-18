<?

//this is everything that has to do with displaying the games currently playing
// we get the current city via the location class and display it dynamically
// include user location class
require_once('LocationClass.php');

class Games extends location{

    function __construct($city){

/*      print_r($city); */

        // checks if it is the first page load of the day and sets the city appropriatly
        // either with what is passed or by grabing the cookie
        if($_COOKIE["gameOn"]){
            $this->myCity = unserialize(base64_decode($_COOKIE["gameOn"]));
        }else{
            $this->myCity = $city;
        }

        $this->day = $_GET["d"];

        //NOTE: $this->currentDate is used also as 'today' as well as the searched date

        if(is_null($this->day) == false && empty($this->day) == false ){

            // get date for date in the url
            $this->currentDate = date('D M j, Y', $this->day);

        }else{

            // empty... get date for tomorrow or today
            $this->currentDate = date('D M j, Y');

        }

    }

    function getLocalGameHeader(){

        $query = "SELECT games.*, teams.`teamName`,
            (SELECT `logo` FROM teams WHERE `city`= games.homeTeam ) AS `home_logo`,
            (SELECT `logo` FROM teams WHERE `city`= games.visitingTeam ) AS `visiting_logo`
            FROM games, teams WHERE (homeTeam LIKE '$this->myCity%' OR visitingTeam LIKE '$this->myCity%')
            AND gameDate = '$this->currentDate'
            AND games.`homeTeam` = teams.`city`
            ORDER BY games.`id` DESC";

        $result = mysql_query($query);

        if(mysql_num_rows($result) > 0){

            if(is_null($this->day) == false && empty($this->day) == false ){
                // there's no game on for the date searched
                echo "<h1>$this->myCity is playing $this->currentDate!</h1>";
            }else{
                // Todays date
                echo "<h1>$this->myCity is playing today!</h1>";
            }

        }else{

            if(is_null($this->day) == false && empty($this->day) == false ){
                // there's no game on for the date searched
                echo "<h1>$this->myCity isn't playing on $this->currentDate but their next game is:</h1>";
            }else{
                // there's no current game on now
                echo "<h1>$this->myCity isn't playing today but their next game is:</h1>";
            }

        }

    }

    function getGlobalGameHeader(){

        if(is_null($this->day) == false && empty($this->day) == false ){
            echo "<h1>Other Games On $this->currentDate</h1>";
        }else{
            echo "<h1>Other Games On Today</h1>";
        }

    }

    function getLocalGames($mobile){

        if($mobile == true){
            $dir = "../";
        }else{
            $dir = "";
        }

        $query = "SELECT games.*, teams.`teamName`,
                    (SELECT `teamName` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeam`,
                    (SELECT `teamName` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamName`,
                    (SELECT `logo` FROM teams WHERE `city`= games.homeTeam ) AS `home_logo`,
                    (SELECT `logo` FROM teams WHERE `city`= games.visitingTeam ) AS `visiting_logo`,
                    (SELECT `id` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeamId`,
                    (SELECT `id` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamId`
                    FROM games, teams WHERE (homeTeam LIKE '$this->myCity%' OR visitingTeam LIKE '$this->myCity%')
                    AND gameDate = '$this->currentDate'
                    AND games.`homeTeam` = teams.`city`
                    ORDER BY games.`id` DESC";

        $result = mysql_query($query);

        if(mysql_num_rows($result) > 0){

            while($row = mysql_fetch_assoc($result)){

                echo "<h3><img class='left' alt='" . $row['teamName'] . "' width='141' src='" . $dir . $row['home_logo'] ."' /> <img class='right' alt='" . $row['visitingTeamName'] . "' width='141' src='" . $dir . $row['visiting_logo'] ."' /></h3>";
                echo '<div class="content"><p>';
                echo "<a href='schedule/".$row['homeTeamId']."/".$row['league']."/".urlencode($row['homeTeam'])."'>" . $row['homeTeam'] . "</a> VS <a href='schedule/".$row['visitingTeamId']."/".$row['league']."/".urlencode($row['visitingTeamName'])."'>" . $row['visitingTeamName'] . "</a><br />";
                echo $row['gameDate'] . " at " . $row['gameTime'] . "<br />";
                echo '</p></div>';

            }

        }else{

            // get games where date is after today
            $dateStampTomorrow = strtotime($this->currentDate);
            $query = "SELECT games.*, teams.`teamName`,
                        (SELECT `teamName` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeam`,
                        (SELECT `teamName` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamName`,
                        (SELECT `logo` FROM teams WHERE `city`= games.homeTeam ) AS `home_logo`,
                        (SELECT `logo` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visiting_logo` ,
                        (SELECT `id` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeamId`,
                        (SELECT `id` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamId`
                        FROM games, teams WHERE (homeTeam LIKE '$this->myCity%' OR visitingTeam LIKE '$this->myCity%')
                        AND dateStamp >= '$dateStampTomorrow'
                        AND games.`homeTeam` = teams.`city`
                        ORDER BY games.`id` ASC LIMIT 1";

            $result = mysql_query($query);

        }

        while($row = mysql_fetch_assoc($result)){

            echo "<h3><img class='left' alt='" . $row['teamName'] . "' width='141' src='" . $dir . $row['home_logo'] ."' /> <img class='right' alt='" . $row['visitingTeamName'] . "' width='141' src='" . $dir . $row['visiting_logo'] ."' /></h3>";
            echo '<div class="content"><p>';
            echo "<a href='schedule/".$row['homeTeamId']."/".$row['league']."/".urlencode($row['homeTeam'])."'>" . $row['homeTeam'] . "</a> VS <a href='schedule/".$row['visitingTeamId']."/".$row['league']."/".urlencode($row['visitingTeamName'])."'>" . $row['visitingTeamName'] . "</a><br />";
            echo $row['gameDate'] . " at " . $row['gameTime'] . "<br />";
            echo '</p></div>';

        }

    }

    // accepts if there is a mob
    function getTodaysGames($mobile){

        //$query = "SELECT * FROM `games` WHERE gameDate = '$currentDate' ORDER BY id DESC";
        // used GROUP BY to eliminate duplicate home and vising teams...
        // get all other games that are on except the current game on from your city this evening,
        // everything else

        // IMPORTANT NEED TO FIX THIS.... FROM IN TORONTO WON't SHOW ME THE TORONTO GAME ON NOV 8th

        $query = "SELECT games.*, teams.`teamName`,
                        (SELECT `teamName` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeam`,
                        (SELECT `teamName` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamName`,
                        (SELECT `logo` FROM teams WHERE `city`= games.`homeTeam` ) AS `home_logo`,
                        (SELECT `logo` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visiting_logo`,
                        (SELECT `id` FROM teams WHERE `city`= games.`homeTeam` ) AS `homeTeamId`,
                        (SELECT `id` FROM teams WHERE `city`= games.`visitingTeam` ) AS `visitingTeamId`
                        FROM games, teams WHERE gameDate = '$this->currentDate'
                        AND games.`homeTeam` <> '$this->myCity'
                        AND games.`visitingTeam` <> '$this->myCity' GROUP BY games.`id`";

        $result = mysql_query($query);

        if($mobile == true){
            $dir = "../";
        }else{
            $dir = "";
        }

        while($row = mysql_fetch_assoc($result)){

            echo "<h3><img class='left' alt='" . $row['homeTeam'] . "' width='141' src='" . $dir . $row['home_logo'] ."' /> <img class='right' alt='" . $row['visitingTeamName'] . "' width='141' src='" . $dir . $row['visiting_logo'] ."' /></a></h3>";
            echo '<div class="content"><p>';
            echo "<a href='schedule/".$row['homeTeamId']."/".$row['league']."/".urlencode($row['homeTeam'])."'>" . $row['homeTeam'] . "</a> VS <a href='schedule/".$row['visitingTeamId']."/".$row['league']."/".urlencode($row['visitingTeamName'])."'>" . $row['visitingTeamName'] . "</a><br />";
            echo $row['gameDate'] . " at " . $row['gameTime'] . "<br />";
            echo '</p></div>';

        }

    }

    function getAllGames($teamId){

    $ds =  strtotime($this->currentDate);

    // UGLY FIX BUT GOOD ENOUGH FOR NOW
    // http://stackoverflow.com/questions/2366780/how-to-do-an-inner-join-on-multiple-columns

    */

    $query = "SELECT city FROM teams WHERE id = " . $teamId;
    $result = mysql_query($query);
    $row = mysql_fetch_row($result);
    $teamCity = $row[0];
    //  echo $teamCity;

    $query = "SELECT * FROM games WHERE (homeTeam LIKE '$teamCity' OR visitingTeam LIKE '$teamCity') AND dateStamp >= '$ds'";

    $result = mysql_query($query);

    //Ideal would ahve liked ot return the result here and let the computatio be handeled in teh schedule class but we didn't have access to the teamname...
    // will still ike to get a better sql statement done here so we have access to the team name as the VS
    //return $result;

    while($row = mysql_fetch_assoc($result)){

        if($row['homeTeam'] == ucwords($teamCity)){
             $homeGame = " homeGame";
        }else{
            $homeGame = "";
        }

        echo '<div class="game'.$homeGame.'" id="game-' .$row['id']. '">';

        if($row['homeTeam'] == ucwords($teamCity)){
            echo '<span class="left">H</span> ';
        }

        $against = ($row['visitingTeam'] == $teamCity) ? $row['homeTeam'] : $row['visitingTeam'];

        echo $row['gameDate'] . ' VS ' . $against ;
        echo '<br />';

        echo '</div>';

    }

    }

}
