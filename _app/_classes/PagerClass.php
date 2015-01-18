<?

// pager class will get the next and previous games for local city and overall

require_once('LocationClass.php');

class GamePager extends location{

    function __construct(){

        $this->day = $_GET["d"];

        if(is_null($this->day) == false && empty($this->day) == false ){

            // get date for date in the url
            $tomorrow = strtotime("+1 day",$this->day);
            $yesterday = strtotime("-1 day",$this->day);
            $this->nextDate = $tomorrow;
            $this->previousDate = $yesterday;

        }else{

            // empty... get date for tomorrow or today
            $tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
            $yesterday = mktime(0, 0, 0, date("m"), date("d")-1, date("y"));
            $this->nextDate = $tomorrow;
            $this->previousDate = $yesterday;

        }

    }

    function nextDate(){

        echo "day/" . $this->nextDate;

    }

    function previousDate(){

        echo "day/" . $this->previousDate;

    }

    function nextLocal(){

    }

    function previousLocal(){

    }

    function nextGlobal(){

    }

    function previousGlobal(){

    }

}
