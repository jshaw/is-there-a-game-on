<html>
    <head>
        <title></title>
    </head>
    <body>

<?

// scrapes the NHL schedule page

/*
$doc = new DOMDocument('1.0');
// we want a nice output
$doc->formatOutput = true;

$root = $doc->createElement('book');
$root = $doc->appendChild($root);

$title = $doc->createElement('title');
$title = $root->appendChild($title);

$text = $doc->createTextNode('This is the title');
$text = $title->appendChild($text);

echo "Saving all the document:\n";
echo $doc->saveXML() . "\n";

echo "Saving only the title part:\n";
echo $doc->saveXML($title);
*/


    //http://eventful.com/toronto/events?q=nhl
    include('../_helperScripts/simple_dom.php');

    $html = new simple_html_dom();
    // retRes = number of buildings i guess

    //http://www.nhl.com/schedules/20112012.html
    $html->load_file('http://isthereagameon.com/table3.php');
//  http://isthereagameon.com/table.php
    $count = 928;

//  $xml =
/*  echo '< season id="2011">'; */

    foreach($html->find('tr') as $e){

        // date
        $date = $e->find('.skedStartDateSite', 0)->plaintext;
        $visiting = $e->find('.teamName a', 0)->plaintext;
        $home = $e->find('.teamName a', 1)->plaintext;
        $time = $e->find('.skedStartTimeEST',0)->plaintext;

/*
        echo $date . "<br />";
        echo $visiting . "<br />";
        echo $home . "<br />";
        echo $time . "<br />";
*/


        if($date != ""){
            echo '< game id="'.$count.'" date="'.$date.'">';
            echo "< home>".$home."< /home>";
            echo "< visiting>".$visiting."< /visiting>";
            echo "< time >".$time."< /time >";
            echo "< /game>";

            $count++;
        }

    }

/*  echo "< /season>"; */

/*  echo $xml; */

?>

</body>
</html>
