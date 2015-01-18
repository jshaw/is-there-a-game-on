<?
$hostname="****";
$username="****";
$password="****";
$dbname="****";

mysql_connect($hostname,$username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);


// insert nhl.xml file into our db

//Get the XML document loaded into a variable
//Set up the parser object
include_once('../_helperScripts/xml_parser.php');
$xml = file_get_contents('../../_assets/_xml/nhl.xml');
$parser = new XMLParser($xml);

$parser->Parse();
$count = 0;

foreach($parser->document->game as $game){

    $gameDate = $game->tagAttrs['date'];
    $homeTeam = $game->home[0]->tagData;
    $visitingTeam = $game->visiting[0]->tagData;
    $gameTime = $game->time[0]->tagData;
    $dateStamp =  strtotime($gameDate . trim($gameTime, 'ET'));

    $query = "INSERT INTO games (homeTeam, visitingTeam, gameDate, gameTime, dateStamp, league, season) VALUES ( '$homeTeam', '$visitingTeam', '$gameDate', '$gameTime', '$dateStamp', 'NHL','2011')";
    echo $query . "<br />";
    // do not uncomment
    //mysql_query($query);

}
