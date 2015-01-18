<?

require_once('GamesClass.php');

class Schedule extends Games{

    function __construct(){

        $this->team = $_GET['id'];
        $this->league = $_GET['l'];
        $this->teamName = $_GET['t'];
        $this->currentDate = date('D M j, Y');

    }

    function getTeamName(){
        return ucwords($this->teamName);
    }

    function getTeamLogo(){

        $query = "SELECT logo FROM teams WHERE id=".$this->team;
        $result = mysql_query($query);
        $row = mysql_fetch_row($result);

        return ucwords($row[0]);

    }

    function getLegueName(){
        return $this->league;
    }

    function getAllGames(){



        echo "<div id='schedule'>";

        if($this->team){

            $result = parent::getAllGames($this->team);

        }else{

            echo "<h2>You didn't specify a team. Please pick one</h2>";

        }

        echo '</div>';

    }

    function getAllTeams($league){

        $query = "SELECT id,teamName,logo FROM teams WHERE league LIKE '$league'";
        $result = mysql_query($query);

        while($row = mysql_fetch_assoc($result)){
            echo "<a href=\"schedule/" . $row['id'] . "/" . $league . "/" . urlencode($row['teamName']) . "\"><img width=\"50\" src='" . $row['logo'] . "' /></a>";

        }

    }

}
