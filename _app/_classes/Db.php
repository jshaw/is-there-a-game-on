<?php

class Db {

    function connect(){

        //Connect To Database
        $hostname="****";
        $username="****";
        $password="****";
        $dbname="****";

        mysql_connect($hostname,$username, $password) OR DIE ("Unable to connect to database! Please try again later.");
        mysql_select_db($dbname);
    }
}

?>
