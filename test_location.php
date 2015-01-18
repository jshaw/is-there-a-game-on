<!DOCTYPE html>

<!--

	was test page for getting locaiton down pat

 -->
<html lang="en">
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=620">
	<title>Is there a game on?</title>
	<link rel="stylesheet" href="_assets/_css/style.css">
	<script src="_assets/_js/h5utils.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	
	<?	
		include_once('analytics.php');
		require_once('_app/_classes/connect.php');
		require_once('_app/_classes/GamesClass.php');
	?>
	
</head>
<body>
<section id="wrapper">
    <header>
      <h1 id="header">Is there a game on?</h1>
    </header>
	<meta name="viewport" content="width=620" />
	<article>
	
			
			<h2>Your Local Games</h2>
			<br />
					
		<?
			/*display most recent job posts*/
			$getGames = new games;
			$getGames->getLocalGames();

			echo "<br />";
			
			echo "<h2>Other Games On Now</h2>";
			
			$getGames->getTodaysGames();
			
		?>
		
	</article>
</section>
<script src="_assets/_js/prettify.packed.js"></script>
<script src="_assets/_js/date.js"></script>
</body>
</html>